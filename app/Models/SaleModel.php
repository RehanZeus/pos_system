<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // Konfigurasi agar data bisa disimpan
    protected $allowedFields    = [
        'invoice_no', 
        'user_id', 
        'total_price', 
        'pay_amount', // <-- PENTING: Agar uang tunai tidak jadi 0
        'payment_method', 
        'created_at'
    ];
    
    protected $useTimestamps    = false; 

    // --- FUNGSI TAMBAHAN UNTUK LAPORAN ---
    // Fungsi ini digunakan untuk mengambil data berdasarkan rentang tanggal
    public function getSalesByRange($startDate, $endDate)
    {
        return $this->select('sales.*, users.name as cashier_name')
                    ->join('users', 'users.id = sales.user_id')
                    // Filter Waktu: Dari jam 00:00 di tanggal awal sampai 23:59 di tanggal akhir
                    ->where('sales.created_at >=', $startDate . ' 00:00:00')
                    ->where('sales.created_at <=', $endDate . ' 23:59:59')
                    ->orderBy('sales.created_at', 'DESC')
                    ->findAll();
    }
}