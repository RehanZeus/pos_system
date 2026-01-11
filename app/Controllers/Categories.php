<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Categories extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        $data = [
            'title'      => 'Manajemen Kategori',
            // Karena Soft Delete aktif, findAll() otomatis memfilter data yang sudah dihapus
            'categories' => $this->categoryModel->findAll()
        ];

        return view('categories/index', $data);
    }

    public function store()
    {
        $id = $this->request->getPost('id');
        $data = ['name' => $this->request->getPost('name')];

        // LOGIKA PENYIMPANAN
        if (!empty($id)) {
            $data['id'] = $id; 
            $res = $this->categoryModel->save($data);
            $msg = 'Kategori berhasil diupdate.';
        } else {
            $res = $this->categoryModel->insert($data);
            $msg = 'Kategori berhasil ditambah.';
        }

        // Cek Validasi dari Model
        if ($this->categoryModel->errors()) {
            // Ambil error pertama untuk ditampilkan
            $errors = $this->categoryModel->errors();
            return redirect()->back()->with('error', reset($errors));
        }

        return redirect()->to('/categories')->with('success', $msg);
    }

    // --- BAGIAN INI YANG DIPERBAIKI ---
    public function delete($id)
    {
        // Kita HAPUS try-catch nya.
        // Karena pakai Soft Delete, perintah ini sebenarnya melakukan UPDATE di database.
        // Jadi tidak akan bentrok dengan Foreign Key produk.
        
        $this->categoryModel->delete($id);
        
        return redirect()->to('/categories')->with('success', 'Kategori berhasil dihapus.');
    }
}