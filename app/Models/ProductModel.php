<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // --- FITUR 1: SOFT DELETE (Agar data tidak hilang permanen saat dihapus) ---
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at'; 

    protected $allowedFields    = [
        'category_id', 
        'barcode', 
        'name', 
        'purchase_price', 
        'price', 
        'stock', 
        'image',
        'deleted_at'
    ];

    // --- FITUR 2: VALIDASI DATA (ANTI MINUS) ---
    // Ini adalah pagar penjaga agar data aneh tidak masuk ke database
    protected $validationRules = [
        'name'           => 'required|min_length[3]',
        'category_id'    => 'required',
        
        // greater_than_equal_to[0] artinya Minimal 0 (Tidak boleh negatif)
        'purchase_price' => 'required|numeric|greater_than_equal_to[0]',
        'price'          => 'required|numeric|greater_than_equal_to[0]',
        'stock'          => 'required|integer|greater_than_equal_to[0]',
    ];

    // Pesan Error Bahasa Indonesia (Supaya enak dibaca user)
    protected $validationMessages = [
        'name' => [
            'required' => 'Nama produk wajib diisi.',
            'min_length' => 'Nama produk terlalu pendek.'
        ],
        'purchase_price' => [
            'required' => 'Harga modal wajib diisi.',
            'greater_than_equal_to' => 'Harga modal tidak boleh minus (-).'
        ],
        'price' => [
            'required' => 'Harga jual wajib diisi.',
            'greater_than_equal_to' => 'Harga jual tidak boleh minus (-).'
        ],
        'stock' => [
            'greater_than_equal_to' => 'Stok tidak boleh minus (-).'
        ]
    ];

    // Fungsi JOIN untuk mengambil nama kategori
    public function getProducts()
    {
        return $this->select('products.*, categories.name as category_name')
                    ->join('categories', 'categories.id = products.category_id')
                    // CI4 otomatis menambahkan "WHERE deleted_at IS NULL" karena soft delete aktif
                    ->orderBy('products.id', 'DESC')
                    ->findAll();
    }
}