# NatureRent: Jobsheet 5 (JavaScript DOM & Interaktivitas)


## Deskripsi Praktikum
Pada Jobsheet 5 ini, antarmuka sistem rental alat kemah (NatureRent) yang sebelumnya bersifat statis telah diubah menjadi dinamis dan interaktif menggunakan **JavaScript murni (Vanilla JS)** untuk memanipulasi *Document Object Model* (DOM) di sisi klien (*client-side*).

## Fitur Interaktif yang Diimplementasikan
Berdasarkan file `assets/js/app.js`, terdapat 4 fitur utama yang berhasil diterapkan:

1. **Hamburger Menu Dinamis (`initNavToggle`)**
   Menggantikan teknik *checkbox hack* murni CSS dari jobsheet sebelumnya dengan *Event Listener* JavaScript. Saat tombol menu diklik, class `.nav-open` akan ditambahkan/dihapus secara otomatis untuk membuka/menutup navigasi.
2. **Konfirmasi Hapus (`initHapusConfirm`)**
   Memberikan lapisan keamanan UI dengan memunculkan *dialog box* (`confirm()`) saat tombol "Hapus" pada tabel diklik. Jika pengguna memilih "Batal", aksi pencegahan (`e.preventDefault()`) akan menahan penghapusan data.
3. **Pencarian Real-Time (`initTableFilter`)**
   Memanfaatkan *event* `keyup` pada input pencarian untuk mencocokkan kata kunci (*keyword*) dengan teks di setiap baris tabel (`tr`). Baris yang tidak cocok akan disembunyikan menggunakan manipulasi *inline style* `display: none`.
4. **Validasi Form Klien (`initValidasiForm`)**
   Mencegah pengiriman data (*submit*) jika ada kolom wajib (seperti Nama Alat dan Merk) yang masih kosong, atau jika ada kesalahan format angka pada input Tahun Beli dan Stok (mencegah nilai negatif). Sistem akan memunculkan pesan *error* dinamis tepat di bawah kolom yang bermasalah.

## Ide Latihan Tambahan (Opsional)
1. **Validasi Kode Barang:** `initValidasiForm` memakai regex `/^[0-9-]+$/`, hanya angka dan tanda hubung.
2. **Animasi menu hamburger:** `header nav` diberi `transition: max-height 0.3s ease-in-out, opacity 0.3s ease`. Supaya animasinya benar-benar terlihat, menu dilipat dengan `max-height: 0` + `opacity: 0` (bukan `display: none`, karena `transition` tidak bisa menganimasikan perpindahan `display`), lalu class `nav-open` mengubahnya menjadi `max-height: 400px` + `opacity: 1`.
3. **Filter satu kolom:** kolom yang dicari ditentukan atribut `data-kolom` pada input pencarian (alat = kolom 1 Nama Alat, penyewa = kolom 2 Nama), dibaca JavaScript lewat `input.dataset.kolom`.
4. **Counter jumlah baris:** fungsi `perbaruiCounter()` menampilkan "Menampilkan X dari Y data" dan dipanggil setelah filter, setelah baris dihapus, dan saat halaman dibuka.
5. **Refactor validasi:** nama field wajib disimpan di array `fieldWajib` lalu diperiksa dengan `forEach`.
