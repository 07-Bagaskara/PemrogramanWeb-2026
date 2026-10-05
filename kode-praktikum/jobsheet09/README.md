# NatureRent: Jobsheet 9 (Koneksi PostgreSQL & Dashboard UI)

## Deskripsi Praktikum
Pada Jobsheet 9, aplikasi telah dirombak total dari Sistem Perpustakaan menjadi **NatureRent (Sistem Rental Alat Kemah)**. Perubahan ini mencakup dua aspek krusial: transisi dari penyimpanan sementara (`$_SESSION`) ke penyimpanan data permanen (Persisten) menggunakan basis data **PostgreSQL**, serta perombakan antarmuka menjadi *Dashboard* modern.

## Fitur Utama yang Diimplementasikan
1. **Skema Database Relasional (DDL):**
   Mencetak struktur tabel baru yaitu `alat_kemah` dan `penyewa` (lengkap dengan `PRIMARY KEY`, `UNIQUE`, dan `DEFAULT` constraint) ke dalam PostgreSQL.
2. **Koneksi Database dengan PDO:**
   Membuat jembatan koneksi yang aman antara aplikasi PHP dan server PostgreSQL menggunakan ekstensi PDO melalui file `includes/koneksi.php`. Kredensial database dibaca dari Environment Variables, tidak ditulis langsung di kode.
3. **CRUD Lengkap (Create, Read, Update, Delete):**
   - **Create:** Mengubah logika di `alat/proses_tambah.php` dan `penyewa/proses_tambah.php` menggunakan query `INSERT ... RETURNING id`.
   - **Read:** Mengubah logika di `index.php` dan `list.php` menggunakan query `SELECT` dan fungsi penghitung agregasi `COUNT(*)`.
   - **Update:** Membangun form `edit.php` dan logika pembaruan data menggunakan query `UPDATE`, diproses lewat file terpisah `proses_edit.php` di masing-masing modul (alat & penyewa).
   - **Delete:** Menerapkan fitur hapus data menggunakan query `DELETE`, diproses lewat file terpisah `proses_hapus.php` di masing-masing modul, agar struktur CRUD konsisten (satu file proses untuk satu aksi).
4. **Keamanan Prepared Statements:**
   Semua query manipulasi data diproses menggunakan *prepared statements* (parameter bind `:nama_kolom`) untuk mencegah celah keamanan *SQL Injection*.

## Penyelesaian Ide Latihan Ekstra
- masih dalam proses

## Rombak Total UI/UX (Dashboard Layout)
Seluruh halaman antarmuka telah ditingkatkan meninggalkan desain kaku bawaan *jobsheet*:
- Mengimplementasikan arsitektur navigasi **Sidebar** (*Dashboard style*).
- Menggunakan tipografi modern **Plus Jakarta Sans**.
- Injeksi Regex dari tugas terdahulu (validasi angka/strip) tetap dipertahankan sebagai lapisan keamanan *Server-Side* sebelum data masuk ke database.

## Deployment
Aplikasi dideploy ke Vercel menggunakan runtime komunitas `vercel-php`, karena Vercel tidak mendukung PHP secara native. Routing PHP diatur lewat `vercel.json` dan `api/index.php` di level folder `kode-praktikum`, sehingga jobsheet HTML (01-06) dan jobsheet PHP (07-09) bisa tampil bersamaan dalam satu deployment.