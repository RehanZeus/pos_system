<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\SaleModel;

class Dashboard extends BaseController
{
    public function index()
    {
        // Cek Login
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        $productModel = new ProductModel();
        $saleModel = new SaleModel();
        
        $today = date('Y-m-d');

        // 1. HITUNG OMSET & JUMLAH TRANSAKSI HARI INI
        // Kita ambil datanya dulu agar akurat
        $todaysTransactions = $saleModel->where('created_at >=', $today . ' 00:00:00')
                                        ->where('created_at <=', $today . ' 23:59:59')
                                        ->findAll();
        
        $todaysEarnings = 0;
        foreach ($todaysTransactions as $t) {
            $todaysEarnings += $t['total_price'];
        }
        $todaysCount = count($todaysTransactions);

        // 2. TOTAL PRODUK AKTIF
        $totalProducts = $productModel->countAll();

        // 3. DATA STOK MENIPIS (PENTING: Diambil datanya, bukan cuma dihitung)
        // Limit 5 agar dashboard tidak kepanjangan
        $lowStock = $productModel->where('stock <=', 5)
                                 ->orderBy('stock', 'ASC')
                                 ->limit(5)
                                 ->findAll();

        // 4. AKTIVITAS TERBARU (5 Transaksi Terakhir)
        // Join ke tabel users untuk ambil nama kasir
        $recentSales = $saleModel->select('sales.*, users.name as cashier_name')
                                 ->join('users', 'users.id = sales.user_id')
                                 ->orderBy('created_at', 'DESC')
                                 ->limit(5)
                                 ->findAll();

        // 5. (OPSIONAL) DATA GRAFIK - Tetap saya sertakan jika nanti ingin dipakai
        $chartData = [];
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $sum = $saleModel->selectSum('total_price')
                             ->where("DATE(created_at)", $date)
                             ->first();
            
            $chartLabels[] = date('d M', strtotime($date));
            $chartData[] = $sum['total_price'] ?? 0;
        }

        // Kirim Data ke View
        $data = [
            'title'           => 'Dashboard Utama',
            'todays_earnings' => $todaysEarnings, // Sesuai dengan View
            'todays_count'    => $todaysCount,    // Sesuai dengan View
            'total_products'  => $totalProducts,
            'recent_sales'    => $recentSales,
            'low_stock'       => $lowStock,       // Sekarang berisi array data produk
            'chart_labels'    => json_encode($chartLabels),
            'chart_data'      => json_encode($chartData)
        ];

        return view('dashboard/index', $data);
    }
}