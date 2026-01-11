<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    
    // --- TAMBAHAN 1: AKTIFKAN SOFT DELETE ---
    protected $useSoftDeletes   = true;
    protected $deletedField     = 'deleted_at';

    // --- TAMBAHAN 2: Masukkan 'deleted_at' agar bisa disimpan ---
    protected $allowedFields    = ['name', 'deleted_at'];

    // Validasi
    protected $validationRules = [
        'id'   => 'permit_empty', 
        'name' => 'required|min_length[3]|is_unique[categories.name,id,{id}]'
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Nama kategori wajib diisi.',
            'min_length' => 'Nama kategori minimal 3 karakter.',
            'is_unique'  => 'Nama kategori sudah ada, gunakan nama lain.'
        ]
    ];
}