<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\CategoryModel;

class Products extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Cek Login
        if (!session()->get('isLoggedIn')) return redirect()->to('/');

        $data = [
            'title'      => 'Manajemen Produk',
            'products'   => $this->productModel->getProducts(), 
            'categories' => $this->categoryModel->findAll()     
        ];

        return view('products/index', $data);
    }

    public function store()
    {
        // Ambil Data dari Form
        $id = $this->request->getPost('id');
        $oldImage = $this->request->getPost('old_image');

        $data = [
            'category_id'    => $this->request->getPost('category_id'),
            'barcode'        => $this->request->getPost('barcode'),
            'name'           => $this->request->getPost('name'),
            'purchase_price' => $this->request->getPost('purchase_price'),
            'price'          => $this->request->getPost('price'),
            'stock'          => $this->request->getPost('stock'),
        ];

        // --- 1. PROSES UPLOAD GAMBAR ---
        $file = $this->request->getFile('image');
        
        // Cek apakah user upload gambar baru?
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validasi file gambar (Opsional tapi disarankan)
            if (!$file->hasMoved()) {
                $fileName = $file->getRandomName();
                $file->move('uploads/products', $fileName);
                $data['image'] = $fileName;
            }
        } else {
            // Jika tidak upload baru, pakai gambar lama (saat edit)
            if (!empty($id)) {
                $data['image'] = $oldImage;
            }
        }

        // --- 2. SIMPAN KE DATABASE ---
        if (!empty($id)) {
            $data['id'] = $id; // Mode Edit
            $res = $this->productModel->save($data);
            $msg = 'Produk berhasil diupdate.';
        } else {
            $res = $this->productModel->insert($data); // Mode Tambah
            $msg = 'Produk berhasil ditambah.';
        }

        // --- 3. CEK VALIDASI DARI MODEL (PENTING UNTUK ANTI MINUS) ---
        // Jika model menolak (karena minus), kita kembalikan ke form dengan pesan error
        if ($this->productModel->errors()) {
            $errors = $this->productModel->errors();
            return redirect()->back()->withInput()->with('error', reset($errors));
        }

        return redirect()->to('/products')->with('success', $msg);
    }

    public function delete($id)
    {
        // Hapus data (Soft Delete otomatis bekerja karena sudah di-set di Model)
        $this->productModel->delete($id);
        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus.');
    }
}