# SIMPUS-Mini: Jobsheet 8 (Koneksi PostgreSQL)


## Deskripsi Praktikum
Pada Jobsheet 8, SIMPUS-Mini mengalami peningkatan arsitektur yang sangat krusial: transisi dari penyimpanan sementara (menggunakan `$_SESSION`) ke penyimpanan data permanen (Persisten) menggunakan basis data relasional **PostgreSQL**.

## Fitur Utama yang Diimplementasikan
1. **Skema Database Relasional (DDL):**
   Menerapkan file `sql/01_buku_anggota.sql` untuk mencetak struktur tabel `buku` dan `anggota` (lengkap dengan `PRIMARY KEY`, `NOT NULL`, dan constraint dasar lainnya) ke dalam PostgreSQL.
2. **Koneksi Database dengan PDO:**
   Membuat jembatan koneksi yang aman antara aplikasi PHP dan server PostgreSQL menggunakan ekstensi PDO melalui file `includes/koneksi.php`.
3. **Migrasi CREATE & READ ke SQL:**
   - **Create:** Mengubah logika di `buku/proses_tambah.php` dan `anggota/proses_tambah.php` menggunakan query `INSERT ... RETURNING id`.
   - **Read:** Mengubah logika di `index.php` dan `list.php` menggunakan query `SELECT` dan fungsi penghitung agregrasi `COUNT(*)`.
4. **Keamanan Prepared Statements:**
   Semua query *Insert* data pengguna diproses menggunakan *prepared statements* (parameter bind `:nama_kolom`) untuk mencegah celah keamanan *SQL Injection*.

## Integrasi Modifikasi Kustom (Keberlanjutan Jobsheet 1-7)
Pada fase *commit* ini, seluruh identitas desain dan fitur keamanan ekstra dari tugas terdahulu telah berhasil digabungkan ke dalam kerangka Jobsheet 8:
- **Tema Visual:** Mempertahankan tema warna hijau kustom, transisi menu hamburger responsif, dan styling Flash Message dari file `style.css` bawaan Jobsheet sebelumnya.
- **Injeksi Validasi Lanjutan:** Validasi **Regex ISBN** (hanya angka dan strip) serta **Regex No. HP** (hanya angka) dari Ide Latihan Jobsheet 7 telah diselipkan secara aman ke dalam file `proses_tambah.php` Jobsheet 8, tepat sebelum query PDO dieksekusi.
