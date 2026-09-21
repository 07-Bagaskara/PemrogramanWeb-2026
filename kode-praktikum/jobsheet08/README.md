# NatureRent: Jobsheet 8 (Koneksi PostgreSQL & Dashboard UI)

## Deskripsi Praktikum
Pada Jobsheet 8, aplikasi telah dirombak total dari Sistem Perpustakaan menjadi **NatureRent (Sistem Rental Alat Kemah)**. Perubahan ini mencakup dua aspek krusial: transisi dari penyimpanan sementara (`$_SESSION`) ke penyimpanan data permanen (Persisten) menggunakan basis data **PostgreSQL**, serta perombakan antarmuka menjadi *Dashboard* modern.

## Fitur Utama yang Diimplementasikan
1. **Skema Database Relasional (DDL):**
   Mencetak struktur tabel baru yaitu `alat_kemah` dan `penyewa` (lengkap dengan `PRIMARY KEY`, `UNIQUE`, dan `DEFAULT` constraint) ke dalam PostgreSQL.
2. **Koneksi Database dengan PDO:**
   Membuat jembatan koneksi yang aman antara aplikasi PHP dan server PostgreSQL menggunakan ekstensi PDO melalui file `includes/koneksi.php`.
3. **Migrasi CREATE & READ ke SQL:**
   - **Create:** Mengubah logika di `alat/proses_tambah.php` dan `penyewa/proses_tambah.php` menggunakan query `INSERT ... RETURNING id`.
   - **Read:** Mengubah logika di `index.php` dan `list.php` menggunakan query `SELECT` dan fungsi penghitung agregrasi `COUNT(*)`.
4. **Keamanan Prepared Statements:**
   Semua query manipulasi data diproses menggunakan *prepared statements* (parameter bind `:nama_kolom`) untuk mencegah celah keamanan *SQL Injection*.

## Penyelesaian Ide Latihan Ekstra
- **Ide Latihan 1 (Try-Catch):** Mengimplementasikan penanganan error kode `23505` (UNIQUE constraint violation) pada form penyewa agar PHP tidak *crash* saat ada duplikasi KTP.
- **Ide Latihan 2 (Tanggal Otomatis):** Memanfaatkan fitur `TIMESTAMP DEFAULT NOW()` di PostgreSQL agar tanggal pencatatan data masuk secara otomatis tanpa perlu dikirim lewat PHP.
- **Ide Latihan 3 (Pencarian ILIKE):** Membuat fitur pencarian *Server-Side* di tabel Alat Kemah yang bersifat *case-insensitive* menggunakan perintah `ILIKE '%keyword%'`.
- **Ide Latihan 4 (Migrasi Data):** Menolak melakukan migrasi dari `buku.json` dengan argumen kritis untuk menjaga integritas domain data (Atribut Buku tidak relevan disatukan dengan Alat Kemah).

## Rombak Total UI/UX (Dashboard Layout)
Seluruh desain antarmuka telah ditingkatkan meninggalkan desain kaku bawaan *jobsheet*:
- Mengimplementasikan arsitektur navigasi **Sidebar** (*Dashboard style*).
- Menggunakan tipografi modern **Plus Jakarta Sans**.
- Injeksi Regex dari tugas terdahulu (validasi angka/strip) tetap dipertahankan sebagai lapisan keamanan *Server-Side* sebelum data masuk ke database.