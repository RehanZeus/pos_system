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
        // Ambil data produk join kategori
        $data = [
            'title'      => 'Manajemen Produk',
            'products'   => $this->productModel->getProducts(), 
            'categories' => $this->categoryModel->findAll()     
        ];

        return view('products/index', $data);
    }

    // --- 1. FUNGSI TAMBAH (STORE) ---
    public function store()
    {
        // Validasi Simple Saja (Cukup pastikan diisi & angka)
        // Tidak perlu cek minus disini karena akan di-fix otomatis
        if (!$this->validate([
            'barcode'        => 'required|is_unique[products.barcode]',
            'name'           => 'required',
            'purchase_price' => 'required|numeric',
            'price'          => 'required|numeric',
            'stock'          => 'required|numeric',
        ])) {
            return redirect()->back()->with('error', 'Gagal: Barcode sudah ada atau data tidak lengkap.');
        }

        // SIMPAN DATA (DENGAN FUNGSI ABSOLUTE)
        $this->productModel->save([
            'barcode'        => $this->request->getPost('barcode'),
            'name'           => $this->request->getPost('name'),
            'category_id'    => $this->request->getPost('category_id'),
            
            // FUNGSI abs() = Otomatis ubah negatif jadi positif tanpa error
            'purchase_price' => abs($this->request->getPost('purchase_price')), 
            'price'          => abs($this->request->getPost('price')),          
            'stock'          => abs($this->request->getPost('stock')),          
            
            'image'          => null
        ]);

        return redirect()->to('/products')->with('success', 'Produk berhasil ditambahkan.');
    }

    // --- 2. FUNGSI EDIT (UPDATE) ---
    public function update()
    {
        $id = $this->request->getPost('id');

        if (!$id) return redirect()->back()->with('error', 'ID Produk hilang.');

        // Validasi Simple
        if (!$this->validate([
            'barcode'        => "required|is_unique[products.barcode,id,$id]",
            'name'           => 'required',
            'purchase_price' => 'required|numeric',
            'price'          => 'required|numeric',
        ])) {
            return redirect()->back()->with('error', 'Gagal Update: Cek inputan Anda.');
        }

        // UPDATE DATA (DENGAN FUNGSI ABSOLUTE)
        $this->productModel->update($id, [
            'barcode'        => $this->request->getPost('barcode'),
            'name'           => $this->request->getPost('name'),
            'category_id'    => $this->request->getPost('category_id'),
            
            // FUNGSI abs() = Otomatis ubah negatif jadi positif tanpa error
            'purchase_price' => abs($this->request->getPost('purchase_price')),
            'price'          => abs($this->request->getPost('price')),
            'stock'          => abs($this->request->getPost('stock')),
        ]);

        return redirect()->to('/products')->with('success', 'Data produk berhasil diperbarui.');
    }

    // --- 3. FUNGSI HAPUS (DELETE) ---
    public function delete($id)
    {
        $this->productModel->delete($id);
        return redirect()->to('/products')->with('success', 'Produk berhasil dihapus.');
    }
}