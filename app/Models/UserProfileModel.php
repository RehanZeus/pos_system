<?php

namespace App\Models;

use CodeIgniter\Model;

class UserProfileModel extends Model
{
    protected $table            = 'user_profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city'
    ];

    /**
     * user_profiles TIDAK WAJIB timestamp otomatis
     * Aman dimatikan
     */
    protected $useTimestamps = false;

    /**
     * VALIDASI DASAR (AMAN)
     */
    protected $validationRules = [
        'user_id'   => 'required|integer',
        'full_name' => 'permit_empty|min_length[3]',
        'phone'     => 'permit_empty|min_length[8]',
        'address'   => 'permit_empty|min_length[5]',
        'city'      => 'permit_empty|min_length[3]',
    ];

    protected $skipValidation = false;
}
