# SIMPUS-Mini: Jobsheet 5 (JavaScript DOM & Interaktivitas)


## Deskripsi Praktikum
Pada Jobsheet 5 ini, antarmuka sistem perpustakaan (SIMPUS-Mini) yang sebelumnya bersifat statis telah diubah menjadi dinamis dan interaktif menggunakan **JavaScript murni (Vanilla JS)** untuk memanipulasi *Document Object Model* (DOM) di sisi klien (*client-side*).

## Fitur Interaktif yang Diimplementasikan
Berdasarkan file `assets/js/app.js`, terdapat 4 fitur utama yang berhasil diterapkan:

1. **Hamburger Menu Dinamis (`initNavToggle`)**
   Menggantikan teknik *checkbox hack* murni CSS dari jobsheet sebelumnya dengan *Event Listener* JavaScript. Saat tombol menu diklik, class `.nav-open` akan ditambahkan/dihapus secara otomatis untuk membuka/menutup navigasi.
2. **Konfirmasi Hapus (`initHapusConfirm`)**
   Memberikan lapisan keamanan UI dengan memunculkan *dialog box* (`confirm()`) saat tombol "Hapus" pada tabel diklik. Jika pengguna memilih "Batal", aksi pencegahan (`e.preventDefault()`) akan menahan penghapusan data.
3. **Pencarian Real-Time (`initTableFilter`)**
   Memanfaatkan *event* `keyup` pada input pencarian untuk mencocokkan kata kunci (*keyword*) dengan teks di setiap baris tabel (`tr`). Baris yang tidak cocok akan disembunyikan menggunakan manipulasi *inline style* `display: none`.
4. **Validasi Form Klien (`initValidasiForm`)**
   Mencegah pengiriman data (*submit*) jika ada kolom wajib (seperti Judul dan Pengarang) yang masih kosong, atau jika ada kesalahan format angka pada input Tahun dan Stok (mencegah nilai negatif). Sistem akan memunculkan pesan *error* dinamis tepat di bawah kolom yang bermasalah.