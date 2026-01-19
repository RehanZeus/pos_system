<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Models\SaleItemModel;

class Reports extends BaseController
{
    protected $saleModel;
    protected $saleItemModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
        $this->saleItemModel = new SaleItemModel();
    }

    // --- HALAMAN UTAMA LAPORAN (WEB VIEW) ---
    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        // 1. Ambil Filter Tanggal dari Form
        $startDate = $this->request->getGet('start_date');
        $endDate   = $this->request->getGet('end_date');

        // 2. Jika kosong (pertama kali buka), set default ke HARI INI
        if (empty($startDate) || empty($endDate)) {
            $startDate = date('Y-m-d');
            $endDate   = date('Y-m-d');
        }

        // 3. Gunakan fungsi getSalesByRange
        $sales = $this->saleModel->getSalesByRange($startDate, $endDate);

        // 4. Hitung Total Omset untuk Tampilan Web
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

    // API Detail untuk Modal
    public function detail($saleId)
    {
        $items = $this->saleItemModel->select('sale_items.*, products.name, products.barcode')
                                     ->join('products', 'products.id = sale_items.product_id')
                                     ->where('sale_id', $saleId)
                                     ->findAll();
        
        return $this->response->setJSON($items);
    }

    // --- FUNGSI EXPORT EXCEL (MODIFIKASI: BISA ALL DATA & CUSTOM) ---
    public function exportExcel()
    {
        $db = \Config\Database::connect();

        // 1. CEK MODE EXPORT
        $mode = $this->request->getGet('mode'); // Apakah mode 'all' atau biasa?

        if ($mode == 'all') {
            // --- LOGIKA EXPORT SEMUA DATA ---
            $startDate = '2000-01-01'; 
            $endDate   = date('Y-m-d');
            
            $judulPeriode = "SEMUA RIWAYAT TRANSAKSI (ALL TIME)";
            $filename     = 'Laporan_FULL_SEMUA_DATA_' . date('Y-m-d_H-i') . '.xls';
        
        } else {
            // --- LOGIKA EXPORT SESUAI TANGGAL ---
            $startDate = $this->request->getGet('start_date');
            $endDate   = $this->request->getGet('end_date');

            // Default ke bulan ini jika kosong
            if (empty($startDate) || empty($endDate)) {
                $startDate = date('Y-m-01');
                $endDate   = date('Y-m-t');
            }

            $judulPeriode = 'Periode: ' . date('d/m/Y', strtotime($startDate)) . ' s/d ' . date('d/m/Y', strtotime($endDate));
            $filename     = 'Laporan_' . $startDate . '_sd_' . $endDate . '.xls';
        }

        // 2. Helper Hitung Profit (Closure)
        $hitungProfit = function ($sDate, $eDate) use ($db) {
            $query = $db->table('sale_items')
                        ->join('sales', 'sales.id = sale_items.sale_id')
                        ->join('products', 'products.id = sale_items.product_id')
                        ->where('sales.created_at >=', $sDate . ' 00:00:00')
                        ->where('sales.created_at <=', $eDate . ' 23:59:59')
                        ->selectSum('sale_items.subtotal', 'omset')
                        ->select('SUM(sale_items.qty * products.purchase_price) as modal')
                        ->get()
                        ->getRow();

            $omset = $query->omset ?? 0;
            $modal = $query->modal ?? 0;
            return $omset - $modal;
        };

        // 3. Hitung Indikator Dashboard (Tetap Realtime Hari Ini/Minggu Ini/Bulan Ini)
        $profitHari   = $hitungProfit(date('Y-m-d'), date('Y-m-d'));
        $profitMinggu = $hitungProfit(date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week')));
        $profitBulan  = $hitungProfit(date('Y-m-01'), date('Y-m-t'));

        // 4. AMBIL DATA TRANSAKSI SESUAI START & END DATE YANG SUDAH DITENTUKAN DI ATAS
        $sales = $this->saleModel->getSalesByRange($startDate, $endDate);

        // 5. Setup Headers Excel
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$filename\"");

        // 6. Styling CSS Excel
        echo '
        <style>
            table { border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; margin-bottom: 20px; }
            th { border: 1px solid #000; padding: 10px; text-align: center; color: white; }
            td { border: 1px solid #000; padding: 8px; vertical-align: middle; }
            .text-center { text-align: center; } .text-right { text-align: right; }
            .pink { color: #d63384; } .blue { color: #0d6efd; font-weight: bold; } .green { color: #198754; font-weight: bold; }
            .bg-green { background-color: #198754; } .bg-blue { background-color: #0d6efd; } .bg-purple { background-color: #6610f2; }
            .header-title { font-size: 18px; border:none; background:#fff; color:#000; padding-bottom:10px; }
        </style>
        ';

        // --- BAGIAN 1: DASHBOARD RINGKASAN ---
        echo '<table><thead>
                <tr><th colspan="3" class="header-title" style="text-align:left;">DASHBOARD KEUNTUNGAN (REALTIME)</th></tr>
                <tr><th class="bg-green">Hari Ini</th><th class="bg-blue">Minggu Ini</th><th class="bg-purple">Bulan Ini</th></tr>
              </thead><tbody>
                <tr>
                    <td class="text-center" style="font-weight:bold;">Rp ' . number_format($profitHari, 0,',','.') . '</td>
                    <td class="text-center" style="font-weight:bold;">Rp ' . number_format($profitMinggu, 0,',','.') . '</td>
                    <td class="text-center" style="font-weight:bold;">Rp ' . number_format($profitBulan, 0,',','.') . '</td>
                </tr>
              </tbody></table><br>';

        // --- BAGIAN 2: DATA TRANSAKSI ---
        echo '<table><thead>
                <tr><th colspan="7" class="header-title" style="text-align:left;">DATA PENJUALAN<br><small>' . $judulPeriode . '</small></th></tr>
                <tr style="background-color: #333;">
                    <th style="background-color:#444;">No. Invoice</th>
                    <th style="background-color:#444;">Waktu</th>
                    <th style="background-color:#444;">Kasir</th>
                    <th style="background-color:#444;">Metode</th>
                    <th style="background-color:#d63384;">Total Modal</th>
                    <th style="background-color:#0d6efd;">Total Omset</th>
                    <th style="background-color:#198754;">Keuntungan</th>
                </tr></thead><tbody>';

        $grandModal = 0; $grandOmset = 0; $grandProfit = 0;

        if (empty($sales)) {
            echo '<tr><td colspan="7" class="text-center">Tidak ada data pada periode ini</td></tr>';
        } else {
            foreach ($sales as $row) {
                // Hitung Modal & Profit per Transaksi
                $items = $this->saleItemModel->select('sale_items.qty, products.purchase_price')
                                             ->join('products', 'products.id = sale_items.product_id')
                                             ->where('sale_id', $row['id'])
                                             ->findAll();
                
                $modalTransaksi = 0;
                foreach($items as $item) {
                    $modalTransaksi += ($item['qty'] * $item['purchase_price']);
                }

                $omsetTransaksi  = $row['total_price'];
                $profitTransaksi = $omsetTransaksi - $modalTransaksi;

                // Akumulasi Total
                $grandModal += $modalTransaksi;
                $grandOmset += $omsetTransaksi;
                $grandProfit += $profitTransaksi;

                // --- PERBAIKAN FORMAT RUPIAH DISINI ---
                echo '<tr>
                        <td class="text-center" style="mso-number-format:\@">' . $row['invoice_no'] . '</td>
                        <td class="text-center">' . date('d/m/Y H:i', strtotime($row['created_at'])) . '</td>
                        <td>' . $row['cashier_name'] . '</td>
                        <td class="text-center">' . $row['payment_method'] . '</td>
                        <td class="text-right pink">Rp ' . number_format($modalTransaksi, 0, ',', '.') . '</td>
                        <td class="text-right blue">Rp ' . number_format($omsetTransaksi, 0, ',', '.') . '</td>
                        <td class="text-right green">Rp ' . number_format($profitTransaksi, 0, ',', '.') . '</td>
                      </tr>';
            }

            // --- PERBAIKAN FORMAT RUPIAH DI TOTAL FOOTER ---
            echo '<tr>
                    <td colspan="4" class="text-right" style="background:#eee; font-weight:bold;">TOTAL</td>
                    <td class="text-right pink" style="background:#eee; font-weight:bold;">Rp ' . number_format($grandModal, 0, ',', '.') . '</td>
                    <td class="text-right blue" style="background:#eee; font-weight:bold;">Rp ' . number_format($grandOmset, 0, ',', '.') . '</td>
                    <td class="text-right green" style="background:#eee; font-weight:bold; font-size:1.2em;">Rp ' . number_format($grandProfit, 0, ',', '.') . '</td>
                  </tr>';
        }
              
        echo '</tbody></table>';
        exit;
    }
}