<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return $this->redirectBasedOnRole(session()->get('role'));
        }
        return view('auth/login');
    }

    public function loginProcess()
    {
        $session = session();
        $model = new UserModel();
        
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        
        $data = $model->where('username', $username)->first();

        if ($data) {
            if (password_verify($password, $data['password'])) {
                $ses_data = [
                    'id'        => $data['id'],
                    'username'  => $data['username'],
                    'name'      => $data['name'],
                    'role'      => $data['role'],
                    'isLoggedIn'=> TRUE
                ];
                $session->set($ses_data);
                
                return $this->redirectBasedOnRole($data['role']);
                
            } else {
                $session->setFlashdata('error', 'Password Salah.');
                return redirect()->to('/');
            }
        } else {
            $session->setFlashdata('error', 'Username tidak ditemukan.');
            return redirect()->to('/');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    // --- LOGIKA REDIRECT BARU ---
    private function redirectBasedOnRole($role)
    {
        if ($role == 'owner') {
            return redirect()->to('/dashboard'); // Owner -> Dashboard
        } elseif ($role == 'admin') {
            return redirect()->to('/products');  // Admin -> Produk (Gudang)
        } elseif ($role == 'kasir') {
            return redirect()->to('/pos');       // Kasir -> POS
        }
        return redirect()->to('/'); 
    }
}