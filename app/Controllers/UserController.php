<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\UserProfileModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $profileModel;

    public function __construct()
    {
        $this->userModel    = new UserModel();
        $this->profileModel = new UserProfileModel();
    }

    /**
     * HARD GUARD: OWNER ONLY
     * WAJIB return supaya eksekusi berhenti
     */
    private function ownerOnly()
    {
        if (session()->get('role') !== 'owner') {
            redirect()->to('/dashboard')
                ->with('error', 'Akses ditolak')
                ->send();
            exit;
        }
    }

    /**
     * LIST USER (NON OWNER)
     */
    public function index()
    {
        $this->ownerOnly();

        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel
                ->where('role !=', 'owner')
                ->findAll()
        ];

        return view('users/index', $data);
    }

    /**
     * FORM TAMBAH USER
     */
    public function create()
    {
        $this->ownerOnly();

        return view('users/create', [
            'title' => 'Tambah User'
        ]);
    }

    /**
     * SIMPAN USER BARU (PILIH ROLE)
     */
    public function store()
    {
        $this->ownerOnly();

        $password = password_hash(
            $this->request->getPost('password'),
            PASSWORD_DEFAULT
        );

        $userId = $this->userModel->insert([
            'username' => $this->request->getPost('username'),
            'password' => $password,
            'name'     => $this->request->getPost('name'),
            'role'     => $this->request->getPost('role'),
        ]);

        // Buat profile kosong (aman)
        $this->profileModel->insert([
            'user_id' => $userId,
        ]);

        return redirect()->to('/users')
            ->with('success', 'User berhasil ditambahkan');
    }

    /**
     * FORM EDIT PROFIL USER
     */
    public function edit($id)
    {
        $this->ownerOnly();

        $user = $this->userModel->find($id);

        if (!$user || $user['role'] === 'owner') {
            return redirect()->to('/users')
                ->with('error', 'User tidak valid');
        }

        $data = [
            'title'   => 'Edit Profil User',
            'user'    => $user,
            'profile' => $this->profileModel
                ->where('user_id', $id)
                ->first()
        ];

        return view('users/edit', $data);
    }

    /**
     * UPDATE PROFIL USER
     */
    public function update($id)
    {
        $this->ownerOnly();

        $this->profileModel->save([
            'user_id'   => $id,
            'full_name' => $this->request->getPost('full_name'),
            'phone'     => $this->request->getPost('phone'),
            'address'   => $this->request->getPost('address'),
            'city'      => $this->request->getPost('city'),
        ]);

        return redirect()->to('/users')
            ->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * RESET PASSWORD USER
     */
    public function resetPassword($id)
    {
        $this->ownerOnly();

        $user = $this->userModel->find($id);

        if (!$user || $user['role'] === 'owner') {
            return redirect()->to('/users')
                ->with('error', 'Tidak bisa reset user ini');
        }

        $newPassword = 'POS' . rand(1000, 9999);

        $this->userModel->update($id, [
            'password' => password_hash($newPassword, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/users')
            ->with('success', 'Password baru: ' . $newPassword);
    }

    /**
     * HAPUS USER (NON OWNER)
     */
    public function delete($id)
    {
        $this->ownerOnly();

        $user = $this->userModel->find($id);

        if (!$user || $user['role'] === 'owner') {
            return redirect()->to('/users')
                ->with('error', 'Tidak bisa menghapus user ini');
        }

        $this->userModel->delete($id); // CASCADE → profile ikut terhapus

        return redirect()->to('/users')
            ->with('success', 'User berhasil dihapus');
    }
}
