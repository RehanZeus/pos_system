<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RestoreDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Matikan cek Foreign Key agar bisa truncate tanpa error
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // 2. Kosongkan Tabel (Reset)
        $this->db->table('sale_items')->truncate();
        $this->db->table('sales')->truncate();
        $this->db->table('products')->truncate();
        $this->db->table('categories')->truncate();

        // 3. Masukkan Kategori
        $categories = [
            ['id' => 7, 'name' => 'Sembako', 'deleted_at' => null],
            ['id' => 8, 'name' => 'Minuman Kemasan', 'deleted_at' => null],
            ['id' => 9, 'name' => 'Makanan Ringan', 'deleted_at' => null],
            ['id' => 10, 'name' => 'Bumbu & Bahan Masak', 'deleted_at' => null],
            ['id' => 11, 'name' => 'Perawatan Tubuh', 'deleted_at' => null],
            ['id' => 12, 'name' => 'Kebersihan Rumah', 'deleted_at' => null],
            ['id' => 13, 'name' => 'ATK', 'deleted_at' => null],
            ['id' => 14, 'name' => 'Rokok', 'deleted_at' => null],
            ['id' => 15, 'name' => 'Susu & Olahan', 'deleted_at' => null],
            ['id' => 16, 'name' => 'Frozen Food', 'deleted_at' => null],
            ['id' => 17, 'name' => 'Mie Instan', 'deleted_at' => null],
            ['id' => 18, 'name' => 'Produk Grosir (Dus)', 'deleted_at' => null],
        ];
        $this->db->table('categories')->insertBatch($categories);

        // 4. Masukkan Produk
        $products = [
            ['id' => 14, 'category_id' => 7, 'barcode' => '899111001', 'name' => 'Beras Ramos 5kg - Topi Koki', 'description' => 'Beras premium 5kg', 'price' => 13000.00, 'stock' => 60, 'created_at' => '2026-01-12 15:33:37'],
            ['id' => 15, 'category_id' => 7, 'barcode' => '899111002', 'name' => 'Gula Pasir 1kg - Gulaku', 'description' => 'Gula pasir kristal', 'price' => 14500.00, 'stock' => 80, 'created_at' => '2026-01-12 15:33:37'],
            ['id' => 16, 'category_id' => 7, 'barcode' => '899111003', 'name' => 'Minyak Goreng 1L - Bimoli', 'description' => 'Minyak goreng sawit', 'price' => 16500.00, 'stock' => 50, 'created_at' => '2026-01-12 15:33:37'],
            ['id' => 17, 'category_id' => 8, 'barcode' => '899111004', 'name' => 'Aqua Botol 600ml', 'description' => 'Air mineral', 'price' => 4500.00, 'stock' => 200, 'created_at' => '2026-01-12 15:34:31'],
            ['id' => 18, 'category_id' => 8, 'barcode' => '899111005', 'name' => 'Le Minerale 600ml', 'description' => 'Air mineral', 'price' => 5000.00, 'stock' => 180, 'created_at' => '2026-01-12 15:34:31'],
            ['id' => 19, 'category_id' => 8, 'barcode' => '899111006', 'name' => 'Teh Pucuk Harum 350ml', 'description' => 'Minuman teh', 'price' => 7000.00, 'stock' => 150, 'created_at' => '2026-01-12 15:34:31'],
            ['id' => 20, 'category_id' => 9, 'barcode' => '899111008', 'name' => 'Chitato Sapi Panggang', 'description' => 'Snack kentang', 'price' => 4000.00, 'stock' => 138, 'created_at' => '2026-01-12 15:34:46'],
            ['id' => 21, 'category_id' => 9, 'barcode' => '899111009', 'name' => 'Taro Net Seaweed', 'description' => 'Snack jagung', 'price' => 3500.00, 'stock' => 160, 'created_at' => '2026-01-12 15:34:46'],
            ['id' => 22, 'category_id' => 9, 'barcode' => '899111010', 'name' => 'Qtela Balado', 'description' => 'Keripik singkong', 'price' => 3000.00, 'stock' => 200, 'created_at' => '2026-01-12 15:34:46'],
            ['id' => 23, 'category_id' => 10, 'barcode' => '899111011', 'name' => 'Royco Ayam 8gr', 'description' => 'Kaldu ayam', 'price' => 5000.00, 'stock' => 180, 'created_at' => '2026-01-12 15:35:03'],
            ['id' => 24, 'category_id' => 10, 'barcode' => '899111012', 'name' => 'Masako Sapi 11gr', 'description' => 'Kaldu sapi', 'price' => 5500.00, 'stock' => 159, 'created_at' => '2026-01-12 15:35:03'],
            ['id' => 25, 'category_id' => 10, 'barcode' => '899111013', 'name' => 'Kecap Manis ABC 135ml', 'description' => 'Kecap manis', 'price' => 9000.00, 'stock' => 120, 'created_at' => '2026-01-12 15:35:03'],
            ['id' => 26, 'category_id' => 11, 'barcode' => '899111014', 'name' => 'Sabun Lifebuoy Merah', 'description' => 'Sabun mandi', 'price' => 6500.00, 'stock' => 100, 'created_at' => '2026-01-12 15:35:17'],
            ['id' => 27, 'category_id' => 11, 'barcode' => '899111015', 'name' => 'Shampoo Pantene 70ml', 'description' => 'Shampoo sachet', 'price' => 8500.00, 'stock' => 88, 'created_at' => '2026-01-12 15:35:17'],
            ['id' => 28, 'category_id' => 13, 'barcode' => '899111020', 'name' => 'Pulpen Standard AE7', 'description' => 'Pulpen hitam', 'price' => 3500.00, 'stock' => 200, 'created_at' => '2026-01-12 15:35:50'],
            ['id' => 29, 'category_id' => 13, 'barcode' => '899111021', 'name' => 'Pensil Faber Castell 2B', 'description' => 'Pensil tulis', 'price' => 4000.00, 'stock' => 219, 'created_at' => '2026-01-12 15:35:50'],
            ['id' => 30, 'category_id' => 15, 'barcode' => '899700900001', 'name' => 'Ultra Milk Coklat 250ml', 'description' => 'Susu UHT', 'price' => 8000.00, 'stock' => 90, 'created_at' => '2026-01-13 12:17:33'],
            ['id' => 31, 'category_id' => 15, 'barcode' => '899700900002', 'name' => 'Indomilk Plain', 'description' => 'Susu UHT', 'price' => 8500.00, 'stock' => 85, 'created_at' => '2026-01-13 12:17:33'],
            ['id' => 32, 'category_id' => 16, 'barcode' => '899701000001', 'name' => 'Nugget Kanzler', 'description' => 'Nugget ayam', 'price' => 22000.00, 'stock' => 30, 'created_at' => '2026-01-13 12:17:55'],
            ['id' => 33, 'category_id' => 16, 'barcode' => '899701000002', 'name' => 'Sosis So Nice', 'description' => 'Sosis ayam', 'price' => 19500.00, 'stock' => 35, 'created_at' => '2026-01-13 12:17:55'],
            ['id' => 34, 'category_id' => 17, 'barcode' => '899701100001', 'name' => 'Indomie Goreng', 'description' => 'Mie instan', 'price' => 3500.00, 'stock' => 200, 'created_at' => '2026-01-13 12:18:13'],
            ['id' => 35, 'category_id' => 17, 'barcode' => '899701100002', 'name' => 'Mie Sedaap Soto', 'description' => 'Mie instan', 'price' => 3800.00, 'stock' => 180, 'created_at' => '2026-01-13 12:18:13'],
            ['id' => 36, 'category_id' => 18, 'barcode' => '899701200001', 'name' => 'Indomie Goreng Dus (40)', 'description' => 'Grosir mie instan', 'price' => 350000.00, 'stock' => 9, 'created_at' => '2026-01-13 12:18:37'],
            ['id' => 37, 'category_id' => 18, 'barcode' => '899701200002', 'name' => 'Aqua 600ml Dus', 'description' => 'Grosir air mineral', 'price' => 320000.00, 'stock' => 12, 'created_at' => '2026-01-13 12:18:37'],
            ['id' => 40, 'category_id' => 14, 'barcode' => '899700800001', 'name' => 'Gudang Garam Surya', 'description' => 'Rokok kretek', 'price' => 29000.00, 'stock' => 39, 'created_at' => '2026-01-13 12:20:08'],
            ['id' => 41, 'category_id' => 14, 'barcode' => '899700800002', 'name' => 'Djarum Super', 'description' => 'Rokok filter', 'price' => 27000.00, 'stock' => 34, 'created_at' => '2026-01-13 12:20:08'],
        ];
        $this->db->table('products')->insertBatch($products);

        // 5. Masukkan Penjualan (Sales)
        $sales = [
            ['id' => 34, 'invoice_no' => 'INV-20260112153838-567', 'user_id' => 2, 'total_price' => 16500.00, 'pay_amount' => 20000.00, 'payment_method' => 'CASH', 'created_at' => '2026-01-12 15:38:38'],
            ['id' => 35, 'invoice_no' => 'INV-20260112160950-651', 'user_id' => 2, 'total_price' => 18000.00, 'pay_amount' => 20000.00, 'payment_method' => 'CASH', 'created_at' => '2026-01-12 16:09:50'],
            ['id' => 36, 'invoice_no' => 'INV-20260113122152-127', 'user_id' => 2, 'total_price' => 406000.00, 'pay_amount' => 410000.00, 'payment_method' => 'CASH', 'created_at' => '2026-01-13 12:21:52'],
        ];
        $this->db->table('sales')->insertBatch($sales);

        // 6. Masukkan Detail Item Penjualan
        $saleItems = [
            ['sale_id' => 34, 'product_id' => 27, 'price_at_time' => 8500.00, 'qty' => 1, 'subtotal' => 8500.00],
            ['sale_id' => 34, 'product_id' => 20, 'price_at_time' => 4000.00, 'qty' => 1, 'subtotal' => 4000.00],
            ['sale_id' => 34, 'product_id' => 29, 'price_at_time' => 4000.00, 'qty' => 1, 'subtotal' => 4000.00],
            ['sale_id' => 35, 'product_id' => 24, 'price_at_time' => 5500.00, 'qty' => 1, 'subtotal' => 5500.00],
            ['sale_id' => 35, 'product_id' => 20, 'price_at_time' => 4000.00, 'qty' => 1, 'subtotal' => 4000.00],
            ['sale_id' => 35, 'product_id' => 27, 'price_at_time' => 8500.00, 'qty' => 1, 'subtotal' => 8500.00],
            ['sale_id' => 36, 'product_id' => 41, 'price_at_time' => 27000.00, 'qty' => 1, 'subtotal' => 27000.00],
            ['sale_id' => 36, 'product_id' => 40, 'price_at_time' => 29000.00, 'qty' => 1, 'subtotal' => 29000.00],
            ['sale_id' => 36, 'product_id' => 36, 'price_at_time' => 350000.00, 'qty' => 1, 'subtotal' => 350000.00],
        ];
        $this->db->table('sale_items')->insertBatch($saleItems);

        // 7. Hidupkan kembali cek Foreign Key
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
    }
}