# KasirTokoKu

KasirTokoKu adalah sistem kasir berbasis web yang dibuat menggunakan **PHP** dan **MySQL** untuk membantu pengelolaan penjualan, stok barang, serta data pelanggan di toko skala kecil hingga menengah. Dilengkapi dengan fitur login, transaksi, dan manajemen barang masuk.

![KasirTokoKu Banner](https://inspgr.id/app/uploads/2023/05/pixel-art-kirokaze-17.gif)

## Fitur Utama

#### 1. Autentikasi Pengguna 🔐

- Sistem login untuk admin
- Keamanan dasar melalui session

#### 2. Manajemen Produk 📦

- Tambah produk baru (nama, harga, stok)
- Edit dan hapus data produk
- Tampilkan seluruh daftar produk

#### 2. Barang Masuk 📥

- Menambahkan stok barang baru
- Histori barang masuk
- Edit dan hapus data barang masuk

#### 3. Transaksi Penjualan 🛒

- Menambahkan pesanan dari pelanggan
- Penghitungan total otomatis
- Tabel riwayat pesanan

#### 4. Kelola Pelanggan 👥

- Tambah dan edit data pelanggan
- Hapus pelanggan

#### 5. Antarmuka Web 💻

- Menggunakan Bootstrap 5
- Navigasi sidebar
- Tabel interaktif dengan DataTables
- Reponsive

## Kebutuhan Sistem

- PHP
- MySQL/MariaDB
- Web server (Apache/XAMPP)

## Cara Menjalankan

1. **Clone atau download repository ini.**
2. **Ekstrak** ke folder `htdocs` pada XAMPP:  
   `C:/xampp/htdocs/KasirTokoKu`
3. **Buat database** di phpMyAdmin, `kasirtokoku`.
4. **Import file database** `kasirtokoku.sql` ke database yang telah dibuat.
5. **Konfigurasi koneksi database** pada file konfigurasi (konfig ada di file `function.php`), sesuaikan username dan password database.
6. **Jalankan XAMPP** (Apache & MySQL).
7. **Akses aplikasi** melalui browser:  
   `http://localhost/KasirTokoKu`
8. **Login ke sistem** menggunakan akun berikut:
   - **Username:** `admin`
   - **Password:** `admin123`
