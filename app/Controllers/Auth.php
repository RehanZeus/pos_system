<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, lempar ke dashboard (nanti kita buat dashboardnya)
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();
        
        // Ambil input dari form
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        // Cari user berdasarkan username
        $data = $model->where('username', $username)->first();

        if ($data) {
            $pass = $data['password'];
            // Verifikasi Password Hash
            if (password_verify($password, $pass)) {
                // Password Benar! Simpan sesi
                $ses_data = [
                    'id'        => $data['id'],
                    'username'  => $data['username'],
                    'name'      => $data['name'],
                    'role'      => $data['role'],
                    'isLoggedIn'=> TRUE
                ];
                $session->set($ses_data);
                
                // Redirect sesuai role (Nanti kita sempurnakan di Tahap Dashboard)
                return redirect()->to('/dashboard');
                
            } else {
                // Password Salah
                $session->setFlashdata('error', 'Password Salah.');
                return redirect()->to('/');
            }
        } else {
            // Username tidak ditemukan
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}