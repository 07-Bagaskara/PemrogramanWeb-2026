# SIMPUS-Mini: Jobsheet 7 (PHP Dasar & Form Handling)



## Deskripsi Praktikum
Jobsheet 7 merupakan titik balik terbesar dalam pengembangan SIMPUS-Mini. Arsitektur aplikasi resmi berpindah dari *Client-Side* murni (HTML statis, JavaScript, Fetch API) menjadi **Server-Side** menggunakan **PHP**. Pemrosesan data, validasi form, dan rendering halaman kini dieksekusi di sisi server sebelum dikirimkan ke browser.

## Fitur Utama yang Diimplementasikan
1. **Sistem Template (PHP Includes)**
   Kode HTML yang berulang (seperti navbar dan footer) telah dipisahkan ke dalam folder `includes/` (`header.php` dan `footer.php`). File utama (seperti `list.php` atau `tambah.php`) kini cukup menggunakan perintah `include` dengan variabel path `$base` dinamis agar kode lebih *DRY (Don't Repeat Yourself)*.
2. **State Management Sementara (`$_SESSION`)**
   Pengambilan data via `fetch()` dan file `.json` dari Jobsheet 6 telah dihapus. Sebagai gantinya, data buku dan anggota kini ditampung sementara di memori server menggunakan Array di dalam `$_SESSION`.
3. **Penanganan Form (POST Method)**
   Formulir Tambah Buku dan Tambah Anggota kini benar-benar mengirimkan datanya ke server melalui metode `POST` menuju file `proses_tambah.php`.
4. **Flash Message Terintegrasi**
   Menambahkan logika pesan kilat (*Flash Message*) menggunakan *Session*. Ketika form berhasil disimpan (hijau) atau gagal divalidasi (merah), server akan melempar pesan yang hanya muncul sekali saat halaman dimuat ulang. Desain CSS warna hijau custom dari Jobsheet sebelumnya tetap dipertahankan dan disinkronkan dengan desain `.flash`.

## Penyelesaian Ide Latihan Tambahan
Pada jobsheet ini, seluruh (4) tantangan **Ide Latihan Tambahan** telah berhasil diselesaikan:
1. **Validasi Regex Server-Side:** 
   - Di `buku/proses_tambah.php`: Menambahkan validasi `preg_match` untuk memastikan field **ISBN** hanya berisi angka dan tanda hubung (-).
   - Di `anggota/proses_tambah.php`: Menambahkan validasi `preg_match` memastikan **No. HP** hanya berisi karakter angka.
2. **Flash Message Anggota:** Mengamankan file `anggota/proses_tambah.php` dengan mekanisme *Flash Message* yang setara dengan modul Buku (menangani field kosong dan error Regex).
3. **Fitur Debug Session:** Membuat file mandiri `debug_session.php` di *root* folder. Halaman ini berfungsi untuk melihat secara langsung dan mentah struktur data Array yang sedang tersimpan di memori `$_SESSION` server.
4. **Fitur Reset Data:** Membuat file `reset_session.php` yang menjalankan perintah `session_destroy()`. Fitur ini ditautkan sebagai tombol khusus **"Reset Data"** di bagian ujung navigasi menu (`header.php`), memungkinkan *reset* aplikasi secara praktis tanpa perlu merestart browser atau server.