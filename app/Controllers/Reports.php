<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Models\SaleItemModel;
use App\Models\ProductModel;

class Reports extends BaseController
{
    protected $saleModel;
    protected $saleItemModel;
    protected $productModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->saleItemModel = new SaleItemModel();
        $this->productModel = new ProductModel();
    }

    // --- HALAMAN UTAMA LAPORAN (WEB VIEW) ---
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        if (empty($startDate) || empty($endDate)) {
            $startDate = date('Y-m-d');
            $endDate   = date('Y-m-d');
        }

        $sales = $this->saleModel->getSalesByRange($startDate, $endDate);

        $totalOmset = 0;
        foreach ($sales as $s) {
            $totalOmset += $s['total_price'];
        }

        $data = [
            'title'      => 'Laporan Penjualan',
            'sales'      => $sales,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'total_omset'=> $totalOmset
        ];

        return view('reports/index', $data);
    }

    public function detail($saleId)
    {
        $items = $this->saleItemModel->select('sale_items.*, products.name, products.barcode')
                                     ->join('products', 'products.id = sale_items.product_id')
                                     ->where('sale_id', $saleId)
                                     ->findAll();
        
        return $this->response->setJSON($items);
    }

    // --- FUNGSI EXPORT EXCEL (PERBAIKAN: LOGIKA STOK BERGERAK/DINAMIS) ---
    public function exportExcel()
    {
        $db = \Config\Database::connect();
        $mode = $this->request->getGet('mode');

        // 1. TENTUKAN PERIODE
        if ($mode == 'all') {
            $startDate = '2000-01-01';
            $endDate   = date('Y-m-d');
            $mainTitle = "LAPORAN STOK & PENJUALAN (ALL TIME)";
            $filename  = 'Laporan_Semua_Produk_' . date('Y-m-d') . '.xls';
        } else {
            $startDate = $this->request->getGet('start_date') ?: date('Y-m-01');
            $endDate   = $this->request->getGet('end_date') ?: date('Y-m-t');
            $mainTitle = "LAPORAN PERIODE: " . date('d/m/Y', strtotime($startDate)) . " s/d " . date('d/m/Y', strtotime($endDate));
            $filename  = 'Laporan_' . $startDate . '_sd_' . $endDate . '.xls';
        }

        // 2. HITUNG "GAP" PENJUALAN (Transaksi yang terjadi SETELAH periode laporan)
        // Ini penting agar hitungan mundur stoknya akurat jika Anda download laporan bulan lalu.
        $gapQuery = $db->table('sale_items')
                       ->select('sale_items.product_id, SUM(sale_items.qty) as total_qty_gap')
                       ->join('sales', 'sales.id = sale_items.sale_id')
                       ->where('sales.created_at >', $endDate . ' 23:59:59')
                       ->groupBy('sale_items.product_id')
                       ->get()->getResultArray();
        
        $salesGap = [];
        foreach($gapQuery as $g) {
            $salesGap[$g['product_id']] = $g['total_qty_gap'];
        }

        // 3. QUERY DATA PENJUALAN (TERJUAL)
        $builder = $db->table('sale_items');
        $builder->select('
            sale_items.product_id,
            sale_items.qty,
            sale_items.subtotal as total_omset,
            sales.invoice_no,
            sales.created_at,
            products.name as product_name,
            products.purchase_price as harga_beli_satuan,
            products.stock as current_real_stock, 
            categories.name as category_name
        ');
        $builder->join('sales', 'sales.id = sale_items.sale_id');
        $builder->join('users', 'users.id = sales.user_id');
        $builder->join('products', 'products.id = sale_items.product_id');
        $builder->join('categories', 'categories.id = products.category_id', 'left');
        
        $builder->where('sales.created_at >=', $startDate . ' 00:00:00');
        $builder->where('sales.created_at <=', $endDate . ' 23:59:59');
        // PENTING: Order harus DESC (Terbaru -> Terlama) untuk logika mundur
        $builder->orderBy('sales.created_at', 'DESC'); 
        
        $salesResults = $builder->get()->getResultArray();

        // 4. GROUPING & LOGIKA BACKTRACKING STOK
        $groupedData = [];
        $soldProductIds = []; 
        $stockTracker = []; // Array untuk melacak posisi stok terakhir per produk

        foreach ($salesResults as $row) {
            $pId = $row['product_id'];
            $soldProductIds[] = $pId;

            // --- LOGIKA HITUNG MUNDUR STOK ---
            // Jika ini pertama kali produk ditemukan dalam loop (artinya transaksi paling baru di periode ini)
            if (!isset($stockTracker[$pId])) {
                // Stok Akhir Laporan = Stok Real DB + Penjualan yang terjadi SETELAH laporan ini (Gap)
                $stockTracker[$pId] = $row['current_real_stock'] + ($salesGap[$pId] ?? 0);
            }

            // Hitung Sisa & Awal untuk baris ini
            $sisaDiBarisIni = $stockTracker[$pId];
            $awalDiBarisIni = $sisaDiBarisIni + $row['qty'];

            // Update tracker agar baris berikutnya (yang lebih lampau) menggunakan stok awal baris ini
            $stockTracker[$pId] = $awalDiBarisIni;

            // Masukkan data hasil hitungan ke array row
            $row['calculated_sisa'] = $sisaDiBarisIni;
            $row['calculated_awal'] = $awalDiBarisIni;

            // Grouping per Bulan
            $monthKey = date('F Y', strtotime($row['created_at'])); 
            $groupedData[$monthKey][] = $row;
        }

        // 5. DATA BARANG TIDAK TERJUAL
        $allProducts = $this->productModel->select('products.*, categories.name as category_name')
                                          ->join('categories', 'categories.id = products.category_id', 'left')
                                          ->findAll();

        $unsoldItems = [];
        foreach ($allProducts as $prod) {
            if (!in_array($prod['id'], $soldProductIds)) {
                // Untuk barang yang tidak laku, stoknya adalah (Real + Gap)
                $stokDiam = $prod['stock'] + ($salesGap[$prod['id']] ?? 0);
                
                $unsoldItems[] = [
                    'created_at'        => null,
                    'invoice_no'        => '-',
                    'product_name'      => $prod['name'],
                    'category_name'     => $prod['category_name'],
                    'qty'               => 0,
                    'calculated_awal'   => $stokDiam,
                    'calculated_sisa'   => $stokDiam, // Awal & Sisa sama karena Qty 0
                    'harga_beli_satuan' => $prod['purchase_price'],
                    'total_omset'       => 0
                ];
            }
        }
        if (!empty($unsoldItems)) {
            $groupedData['PRODUK TIDAK TERJUAL PADA PERIODE INI'] = $unsoldItems;
        }

        // 6. HEADER EXCEL
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo '
        <style>
            body { font-family: Arial, sans-serif; font-size: 12px; }
            .title { font-size: 16pt; font-weight: bold; text-align: center; margin-bottom: 20px; }
            .month-header { background-color: #ffc107; font-weight: bold; padding: 10px; border: 1px solid #000; font-size: 12pt; margin-top: 20px; }
            .unsold-header { background-color: #e2e3e5; color: #555; font-weight: bold; padding: 10px; border: 1px solid #000; font-size: 12pt; margin-top: 20px; }
            table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
            th { border: 1px solid #000; background-color: #343a40; color: white; padding: 8px; text-align: center; vertical-align: middle; }
            td { border: 1px solid #000; padding: 6px; vertical-align: middle; }
            .text-center { text-align: center; }
            .text-right { text-align: right; }
            .text-bold { font-weight: bold; }
            .bg-grey { background-color: #f2f2f2; }
            .text-green { color: #198754; font-weight:bold; }
        </style>
        ';

        echo '<div class="title">' . strtoupper($mainTitle) . '</div>';

        if (empty($groupedData)) {
            echo '<table border="1"><tr><td class="text-center">Tidak ada data.</td></tr></table>'; exit;
        }

        // 7. LOOPING TABEL
        foreach ($groupedData as $groupName => $items) {
            $headerClass = (strpos($groupName, 'TIDAK TERJUAL') !== false) ? 'unsold-header' : 'month-header';
            
            echo '<div class="' . $headerClass . '">' . strtoupper($groupName) . '</div>';
            echo '<table>
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th width="10%">Waktu</th>
                            <th width="10%">No. Invoice</th>
                            <th width="10%">Kategori</th>
                            <th width="15%">Nama Produk</th>
                            <th width="6%" style="background-color:#6c757d;">Stok Awal</th>
                            <th width="6%" style="background-color:#dc3545;">Terjual</th>
                            <th width="6%" style="background-color:#198754;">Sisa</th>
                            <th width="9%">Modal (Satuan)</th>
                            <th width="9%">Total Modal</th>
                            <th width="9%">Total Omset</th>
                            <th width="9%">Keuntungan</th>
                        </tr>
                    </thead>
                    <tbody>';

            $no = 1;
            $grandProfit = 0;

            foreach ($items as $row) {
                $qty         = $row['qty'];
                $stokAwal    = $row['calculated_awal']; // Hasil backtrack
                $stokSisa    = $row['calculated_sisa']; // Hasil backtrack
                
                $modalSatuan = $row['harga_beli_satuan'];
                $totalModal  = $modalSatuan * $qty;
                $totalOmset  = $row['total_omset'];
                $profit      = $totalOmset - $totalModal;

                $grandProfit += $profit;

                $waktuTampil = ($row['created_at']) ? date('d/m/y H:i', strtotime($row['created_at'])) : '-';

                echo '<tr>
                        <td class="text-center">' . $no++ . '</td>
                        <td class="text-center">' . $waktuTampil . '</td>
                        <td class="text-center" style="mso-number-format:\@">' . $row['invoice_no'] . '</td>
                        <td class="text-center">' . $row['category_name'] . '</td>
                        <td>' . $row['product_name'] . '</td>
                        <td class="text-center bg-grey">' . $stokAwal . '</td>
                        <td class="text-center text-bold" style="color:#dc3545;">' . $qty . '</td>
                        <td class="text-center text-bold" style="color:#198754;">' . $stokSisa . '</td>
                        <td class="text-right">Rp ' . number_format($modalSatuan, 0, ',', '.') . '</td>
                        <td class="text-right">Rp ' . number_format($totalModal, 0, ',', '.') . '</td>
                        <td class="text-right">Rp ' . number_format($totalOmset, 0, ',', '.') . '</td>
                        <td class="text-right text-green">Rp ' . number_format($profit, 0, ',', '.') . '</td>
                      </tr>';
            }

            echo '<tr class="bg-grey">
                    <td colspan="6" class="text-right text-bold">TOTAL PROFIT ' . strtoupper($groupName) . '</td>
                    <td></td><td></td><td></td><td></td><td></td>
                    <td class="text-right text-bold text-green" style="font-size:1.1em;">Rp ' . number_format($grandProfit, 0, ',', '.') . '</td>
                  </tr>';
            
            echo '</tbody></table><br>';
        }
        exit;
    }
}