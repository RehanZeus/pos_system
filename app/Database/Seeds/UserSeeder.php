<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // User Gudang (Pengganti Admin)
            [
                'username' => 'gudang',
                'password' => password_hash('gudang123', PASSWORD_DEFAULT),
                'name'     => 'Staf Gudang',
                'role'     => 'gudang',
            ],
            // User Kasir
            [
                'username' => 'kasir',
                'password' => password_hash('kasir123', PASSWORD_DEFAULT),
                'name'     => 'Kasir Utama',
                'role'     => 'kasir',
            ],
            // User Owner
            [
                'username' => 'owner',
                'password' => password_hash('owner123', PASSWORD_DEFAULT),
                'name'     => 'Pemilik Toko',
                'role'     => 'owner',
            ]
        ];

        foreach ($data as $user) {
            // Cek user, jika ada update, jika belum insert
            $exist = $this->db->table('users')->where('username', $user['username'])->get()->getRow();
            if (!$exist) {
                $user['created_at'] = date('Y-m-d H:i:s');
                $this->db->table('users')->insert($user);
            } else {
                $this->db->table('users')->where('username', $user['username'])->update([
                    'password' => $user['password'],
                    'role'     => $user['role']
                ]);
            }
        }
    }
}