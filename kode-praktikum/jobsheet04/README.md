# SIMPUS-Mini: Jobsheet 4 (UI/UX & Wireframe Design)

## Deskripsi Praktikum
Jobsheet keempat ini berfokus pada tahapan perencanaan *UI/UX Design* sebelum memulai penulisan kode fungsional yang kompleks. Tahap ini bertujuan untuk merancang alur navigasi (*user flow*) serta struktur antarmuka (*wireframe*) dari fitur-fitur baru yang akan diimplementasikan pada tahap pengembangan berikutnya.

## Perubahan dari Jobsheet 3
* Seluruh halaman HTML dan `assets/css/style.css` dari Jobsheet 3 dipakai kembali tanpa perubahan struktur.
* **Latihan opsional (bab 6.4 dokumentasi):** wireframe halaman Login diimplementasikan sebagai HTML statis di `login.html` (tanpa logika login sungguhan). Halaman ini memakai pola `<label>` + `<input>` seperti form Tambah Buku, ditambah satu `<input type="password">` untuk field Password.
* Menu **Login** ditambahkan di navbar semua halaman Jobsheet 4 supaya halaman login mudah dibuka.

## Perancangan Wireframe (ASCII Art)
Berikut adalah rancangan antarmuka untuk fitur **Registrasi Anggota Baru** yang ditujukan bagi aktor Tamu:

```text
+---------------------------------------------------+
| SIMPUS-Mini                                 Login |
+---------------------------------------------------+
|                                                   |
|            [ Registrasi Anggota Baru ]            |
|                                                   |
|  Nama Lengkap:                                    |
|  [_____________________________________________]  |
|                                                   |
|  Alamat:                                          |
|  [_____________________________________________]  |
|                                                   |
|  No. Telepon / HP:                                |
|  [_____________________________________________]  |
|                                                   |
|               ( DAFTAR SEKARANG )                 |
|                                                   |
+---------------------------------------------------+
```

Berikut wireframe halaman **Login Petugas** yang diimplementasikan di `login.html`:

```text
+--------------------------------------+
|              SIMPUS-Mini             |
|--------------------------------------|
|                                      |
|           [ Login Petugas ]          |
|                                      |
|   Username : [______________]        |
|   Password : [______________]        |
|                                      |
|            [   Masuk   ]             |
|                                      |
|   Belum punya akun? Daftar di sini   |
+--------------------------------------+
```

## Latihan Opsional: User Flow Baru
Skenario yang belum digambarkan di dokumentasi: **Petugas mencari anggota yang tunggakannya sudah lewat jatuh tempo.**

```text
[Petugas Login] -> [Dashboard] -> [Menu "Daftar Anggota"]
        -> [Pilih filter "Tunggakan lewat jatuh tempo"]
        -> [Sistem menampilkan anggota yang punya peminjaman belum kembali
            dan tanggal jatuh tempo lebih kecil dari hari ini]
        -> [Pilih anggota] -> [Lihat riwayat peminjaman anggota]
        -> [Tandai "Dikembalikan" atau catat denda]
        -> [Kembali ke Dashboard]
```

Aturan bisnis yang dicatat:
* Jatuh tempo = tanggal pinjam + 7 hari (asumsi).
* Anggota tanpa tunggakan tidak muncul di hasil filter.
* Kalau hasil filter kosong, tampilkan pesan "Tidak ada anggota yang menunggak".

## Latihan Opsional: Edge Case Tambahan
1. **Buku yang sama dipinjamkan dua kali berturut-turut ke anggota yang sama:** sistem memeriksa transaksi yang masih aktif dan menolak dengan pesan "Buku ini sedang dipinjam anggota tersebut". Stok tidak boleh berkurang dua kali.
2. **Stok tinggal 1, dua Petugas memproses hampir bersamaan:** hanya satu transaksi yang boleh berhasil, yang kedua ditolak karena stok sudah 0.
3. **Anggota yang masih menunggak mencoba meminjam lagi:** ditolak sampai bukunya dikembalikan.
4. **Tombol "Kembalikan" ditekan dua kali:** pengembalian kedua diabaikan, stok tidak bertambah dua kali.
5. **Buku dihapus dari katalog padahal masih ada transaksi aktif:** penghapusan ditolak.
6. **Login dengan username atau password salah:** tampilkan satu pesan umum ("Username atau password salah") tanpa membocorkan mana yang salah.

## Cara menjalankan
Buka `index.html` langsung di browser (belum butuh server). Halaman login ada di `login.html`.
