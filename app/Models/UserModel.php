<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'username',
        'password',
        'name',
        'role'
    ];

    /**
     * TABEL users TIDAK punya created_at & updated_at
     * Jika true → ERROR SQL
     */
    protected $useTimestamps = false;

    /**
     * VALIDATION RULES (AMAN)
     */
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[6]',
        'name'     => 'required|min_length[3]',
        'role'     => 'required|in_list[owner,admin,kasir]',
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan'
        ]
    ];

    protected $skipValidation = false;
}
