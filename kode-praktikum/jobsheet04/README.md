# NatureRent: Jobsheet 4 (UI/UX & Wireframe Design)

## Deskripsi Praktikum
Jobsheet keempat ini berfokus pada tahapan perencanaan *UI/UX Design* sebelum memulai penulisan kode fungsional yang kompleks. Tahap ini bertujuan untuk merancang alur navigasi (*user flow*) serta struktur antarmuka (*wireframe*) dari fitur-fitur baru yang akan diimplementasikan pada tahap pengembangan berikutnya.

## Perubahan dari Jobsheet 3
* Seluruh halaman HTML dan `assets/css/style.css` dari Jobsheet 3 dipakai kembali tanpa perubahan struktur.
* **Latihan opsional (bab 6.4 dokumentasi):** wireframe halaman Login diimplementasikan sebagai HTML statis di `login.html` (tanpa logika login sungguhan). Halaman ini memakai pola `<label>` + `<input>` seperti form Tambah Alat, ditambah satu `<input type="password">` untuk field Password.
* Menu **Login** ditambahkan di navbar semua halaman Jobsheet 4 supaya halaman login mudah dibuka.

## Perancangan Wireframe (ASCII Art)
Berikut adalah rancangan antarmuka untuk fitur **Registrasi Penyewa Baru** yang ditujukan bagi aktor Tamu:

```text
+---------------------------------------------------+
| NatureRent                                  Login |
+---------------------------------------------------+
|                                                   |
|            [ Registrasi Penyewa Baru ]            |
|                                                   |
|  Nama Lengkap:                                    |
|  [_____________________________________________]  |
|                                                   |
|  No. Identitas (KTP/SIM):                         |
|  [_____________________________________________]  |
|                                                   |
|  Alamat:                                          |
|  [_____________________________________________]  |
|                                                   |
|  No. HP:                                          |
|  [_____________________________________________]  |
|                                                   |
|                ( DAFTAR SEKARANG )                |
|                                                   |
+---------------------------------------------------+
```

Berikut wireframe halaman **Login Petugas** yang diimplementasikan di `login.html`:

```text
+--------------------------------------+
|              NatureRent              |
+--------------------------------------+
|                                      |
|          [ Login Petugas ]           |
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
Skenario yang belum digambarkan di dokumentasi: **Petugas mencari penyewa yang terlambat mengembalikan alat kemah.**

```text
[Petugas Login] -> [Dashboard] -> [Menu "Daftar Penyewa"]
        -> [Pilih filter "Sewa lewat jatuh tempo"]
        -> [Sistem menampilkan penyewa yang punya sewa belum kembali
            dan tanggal kembali lebih kecil dari hari ini]
        -> [Pilih penyewa] -> [Lihat riwayat sewa penyewa]
        -> [Tandai "Dikembalikan" atau catat denda]
        -> [Kembali ke Dashboard]
```

Aturan bisnis yang dicatat:
* Jatuh tempo = tanggal sewa + lama sewa (asumsi 3 hari).
* Penyewa tanpa sewa yang terlambat tidak muncul di hasil filter.
* Kalau hasil filter kosong, tampilkan pesan "Tidak ada penyewa yang terlambat".

## Latihan Opsional: Edge Case Tambahan
1. **Alat yang sama disewa dua kali berturut-turut oleh penyewa yang sama:** sistem memeriksa transaksi sewa yang masih aktif dan menolak dengan pesan "Alat ini sedang disewa penyewa tersebut". Stok tidak boleh berkurang dua kali.
2. **Stok tinggal 1, dua Petugas memproses hampir bersamaan:** hanya satu transaksi yang boleh berhasil, yang kedua ditolak karena stok sudah 0.
3. **Penyewa yang masih terlambat mencoba menyewa lagi:** ditolak sampai alat yang disewa sebelumnya dikembalikan.
4. **Tombol "Kembalikan" ditekan dua kali:** pengembalian kedua diabaikan, stok tidak bertambah dua kali.
5. **Alat dihapus dari inventaris padahal masih ada sewa aktif:** penghapusan ditolak.
6. **Login dengan username atau password salah:** tampilkan satu pesan umum ("Username atau password salah") tanpa membocorkan mana yang salah.

## Cara menjalankan
Buka `index.html` langsung di browser (belum butuh server). Halaman login ada di `login.html`.
