<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1. AKUN OWNER (Akses Semua)
            [
                'username'   => 'owner',
                'password'   => password_hash('owner123', PASSWORD_DEFAULT),
                'name'       => 'Pemilik Toko',
                'role'       => 'owner',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            // 2. AKUN ADMIN (Akses Gudang)
            [
                'username'   => 'admin',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'name'       => 'Super Admin',
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            // 3. AKUN KASIR (Akses POS)
            [
                'username'   => 'kasir',
                'password'   => password_hash('kasir123', PASSWORD_DEFAULT),
                'name'       => 'Kasir Utama',
                'role'       => 'kasir',
                'created_at' => date('Y-m-d H:i:s'),
            ]
        ];

        // LOGIKA PINTAR (Safe Insert):
        foreach ($data as $user) {
            // Cek apakah username ini sudah ada di database?
            $exist = $this->db->table('users')->where('username', $user['username'])->get()->getRow();

            if ($exist) {
                // JIKA SUDAH ADA: Kita Update saja (biar password/role-nya ter-reset ke yang benar)
                // Kita hapus 'created_at' dari array update agar tanggal lama tidak berubah
                unset($user['created_at']); 
                $this->db->table('users')->where('username', $user['username'])->update($user);
            } else {
                // JIKA BELUM ADA: Baru kita Insert
                $this->db->table('users')->insert($user);
            }
        }
    }
}