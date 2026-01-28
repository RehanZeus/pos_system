<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Models\SaleItemModel;

class Pos extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        $data = [
            'title' => 'Kasir / Point of Sale',
            'user'  => session()->get('name')
        ];
        return view('pos/index', $data);
    }

    public function searchProduct()
    {
        $keyword = $this->request->getGet('term');
        $model = new ProductModel();
        
        // Menampilkan produk yang stoknya > 0
        $data = $model->like('name', $keyword)
                      ->orLike('barcode', $keyword)
                      ->where('stock >', 0) 
                      ->findAll(10);

        return $this->response->setJSON($data);
    }

    public function processPayment()
    {
        $json = $this->request->getJSON();
        
        // --- VALIDASI AWAL ---
        if (!$json || empty($json->cart)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Keranjang masih kosong!']);
        }

        // Validasi uang bayar (Mencegah kembalian minus)
        if (!isset($json->pay) || $json->pay < $json->total) {
            return $this->response->setJSON([
                'status' => 'error', 
                'message' => 'Uang tunai tidak cukup atau belum diisi!'
            ]);
        }

        $db = \Config\Database::connect();
        $productModel = new ProductModel();

        // --- LANGKAH 1: HITUNG TOTAL QTY PER PRODUK (PRE-CALCULATION) ---
        // Kita gabungkan dulu qty jika ada produk yang sama discan berkali-kali
        $totalQtyNeeded = [];
        foreach ($json->cart as $item) {
            $id = $item->id;
            if (!isset($totalQtyNeeded[$id])) {
                $totalQtyNeeded[$id] = 0;
            }
            $totalQtyNeeded[$id] += $item->qty;
        }

        // --- LANGKAH 2: VALIDASI STOK (PAKAI TOTAL GABUNGAN) ---
        foreach ($totalQtyNeeded as $productId => $qtyRequired) {
            $product = $productModel->find($productId);
            
            if (!$product) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Produk ID ' . $productId . ' tidak ditemukan!']);
            }

            // Cek apakah Stok Database < Total Qty yang diminta
            if ($product['stock'] < $qtyRequired) {
                return $this->response->setJSON([
                    'status' => 'error', 
                    'message' => 'Stok "' . $product['name'] . '" tidak cukup! Sisa: ' . $product['stock'] . ', Diminta: ' . $qtyRequired
                ]);
            }
        }

        // --- LANGKAH 3: EKSEKUSI TRANSAKSI ---
        $db->transStart();

        $saleModel = new SaleModel();
        $invoiceNo = 'INV-' . date('YmdHis') . '-' . rand(100,999);
        
        // Simpan Header Penjualan
        $saleId = $saleModel->insert([
            'invoice_no'     => $invoiceNo,
            'user_id'        => session()->get('id'),
            'total_price'    => $json->total,
            'pay_amount'     => $json->pay, 
            'payment_method' => 'CASH',
            'created_at'     => date('Y-m-d H:i:s')
        ]);

        $itemModel = new SaleItemModel();
        foreach ($json->cart as $item) {
            // Simpan Detail Item
            $itemModel->insert([
                'sale_id'       => $saleId,
                'product_id'    => $item->id,
                'price_at_time' => $item->price,
                'qty'           => $item->qty,
                'subtotal'      => $item->price * $item->qty
            ]);

            // Kurangi Stok Produk (Query Langsung agar aman & cepat)
            $db->query("UPDATE products SET stock = stock - ? WHERE id = ?", [$item->qty, $item->id]);
        }

        $db->transComplete();

        if ($db->transStatus() === FALSE) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Gagal memproses transaksi ke database.']);
        }

        return $this->response->setJSON(['status' => 'success', 'invoice' => $invoiceNo]);
    }

    public function struk($invoice)
    {
        $saleModel = new SaleModel();
        $itemModel = new SaleItemModel();

        $sale = $saleModel->select('sales.*, users.name as cashier_name')
                          ->join('users', 'users.id = sales.user_id')
                          ->where('invoice_no', $invoice)
                          ->first();

        if (!$sale) return "Invoice " . esc($invoice) . " tidak ditemukan!";

        $items = $itemModel->select('sale_items.*, products.name as product_name')
                           ->join('products', 'products.id = sale_items.product_id')
                           ->where('sale_id', $sale['id'])
                           ->findAll();

        return view('pos/struk', [
            'sale'          => $sale,
            'items'         => $items,
            // Data Toko Anda
            'store_name'    => 'LUCKY MART 7',
            'store_address' => 'Jl. Adipati Mersi No. 66',
            'store_phone'   => '0851-3751-6507'
        ]);
    }
}