<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    // --- FITUR 1: SOFT DELETE ---
    // Ubah ke 'true' HANYA JIKA tabel database Anda memiliki kolom 'deleted_at'
    protected $useSoftDeletes   = false; 
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

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // --- FITUR 2: VALIDASI DATA ---
    // Ini adalah pengaman lapis kedua setelah validasi di Controller
    protected $validationRules = [
        'name'           => 'required|min_length[3]',
        'category_id'    => 'required',
        'purchase_price' => 'required|numeric|greater_than_equal_to[0]',
        'price'          => 'required|numeric|greater_than_equal_to[0]',
        'stock'          => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama produk wajib diisi.',
            'min_length' => 'Nama produk terlalu pendek.'
        ],
        'purchase_price' => [
            'greater_than_equal_to' => 'Harga modal tidak boleh minus.'
        ],
        'price' => [
            'greater_than_equal_to' => 'Harga jual tidak boleh minus.'
        ],
        'stock' => [
            'greater_than_equal_to' => 'Stok tidak boleh minus.'
        ]
    ];

    // --- FITUR 3: FUNGSI JOIN ---
    public function getProducts()
    {
        return $this->select('products.*, categories.name as category_name')
                    // Gunakan LEFT JOIN agar produk tetap muncul meski kategorinya terhapus
                    ->join('categories', 'categories.id = products.category_id', 'left') 
                    ->orderBy('products.id', 'DESC')
                    ->findAll();
    }
}