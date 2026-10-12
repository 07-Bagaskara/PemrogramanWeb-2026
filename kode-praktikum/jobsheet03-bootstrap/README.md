# Jobsheet 3 (Versi Bootstrap) — Responsive Design dengan Framework

Sub-CPMK: Membangun tampilan responsif memakai framework CSS (Bootstrap 5).

Versi ini adalah alternatif dari [jobsheet03](../jobsheet03/README.md)
(CSS murni) — halaman dan fungsionalitasnya identik, tapi seluruh tata
letak dibangun memakai Bootstrap 5 (dimuat via CDN) alih-alih menulis
CSS dari nol.

## Perubahan dari Jobsheet 3 (CSS Murni)
- Bootstrap 5.3 dimuat via CDN (`bootstrap.min.css` + `bootstrap.bundle.min.js`).
- Navbar: hamburger memakai komponen `.navbar`/`.navbar-toggler`/`.collapse` bawaan Bootstrap (butuh JavaScript), menggantikan checkbox hack murni CSS.
- Kartu statistik: grid CSS manual diganti sistem grid 12 kolom Bootstrap (`.row`/`.col-*`).
- Section dibungkus komponen `.card` menggantikan styling `<section>` custom.
- Tabel & form memakai utility class Bootstrap (`.table-striped`, `.table-hover`, `.form-control`, `.btn-warning`, dst).
- `assets/css/style.css` hanya berisi override kecil (warna indigo) di atas Bootstrap.

## Tampilan (desain sendiri)
Tema indigo dan tata letak sidebar, sama dengan jobsheet 2–6 buatan sendiri, tanpa atribut `style="..."` sama sekali di HTML:

| Bagian | Cara |
|---|---|
| Latar halaman abu muda | `body { background-color: #f1f5f9 }` di `style.css` |
| Sidebar di kiri (layar ≥ 768px) | `@media (min-width: 768px)` di `style.css`: `body` jadi `display: grid` 2 kolom (`240px 1fr`), `header` memakai `grid-row: 1 / 3`, menu `flex-direction: column`. Di bawah 768px tetap navbar atas + hamburger Bootstrap |
| Sidebar/navbar gelap indigo | `.navbar-dark` + `.navbar { background-color: #1e1b4b }` di `style.css` |
| Menu aktif berbentuk pil | `.nav-link.active` diberi `background-color` dan `border-radius` di `style.css` |
| Kartu putih tanpa garis tepi | `.card .border-0 .shadow-sm` |
| Judul bagian & angka berwarna indigo | `.text-primary` (warna `primary` Bootstrap diganti jadi indigo di `style.css`) |
| Kotak statistik | `.bg-light .rounded-3 .p-3` di dalam `.col-*` |
| Kepala tabel gelap | `<thead class="table-dark">` |
| Tombol Simpan indigo | `.btn .btn-primary` + variabel `--bs-btn-*` di `style.css` |

## Latihan Opsional (Bab 6.4) — semuanya dikerjakan

1. **Ganti warna brand ke tema bawaan Bootstrap.** Semua `style="background-color:#1d5b8a;"` / `style="color:#1d5b8a;"` (21 atribut `style`) dihapus dan diganti class bawaan: `.text-primary`, `.bg-light`, `.table-dark`, `.btn-primary`. Hasilnya `style.css` tidak lagi butuh `!important` sama sekali (sebelumnya 3 buah) dan tidak perlu aturan warna `.navbar-brand`/`.nav-link`, karena `.navbar-dark` sudah membuat teks navbar putih. Yang tersisa hanya 4 aturan untuk mengganti warna tema dari biru Bootstrap ke indigo.
2. **Breakpoint ketiga di grid kartu statistik.** Class kolom menjadi `col-12 col-sm-6 col-md-4`. Hasil pengukuran: lebar < 576px = 1 kolom, 576–767px = 2 kolom, ≥ 768px = 3 kolom.
3. **`.navbar-expand-lg` diganti `.navbar-expand-md`.** Navbar sekarang berubah jadi hamburger di lebar < 768px (sebelumnya < 992px). Titik lipat hamburger berubah hanya dengan mengganti nama class. (Karena sidebar ditulis manual, `@media (min-width: 768px)` di `style.css` dibuat sama dengan breakpoint `md` supaya keduanya berganti bersamaan.) Teruji: di 767px hamburger tampil, di 768px menu terbuka penuh.
4. **Komponen Bootstrap baru.**
   * `.badge` pada kolom Stok di `alat/list.html`: stok > 0 → `Tersedia` (hijau, `text-bg-success`), stok 0 → `Kosong` (merah, `text-bg-danger`).
   * `.alert` setelah form disimpan di `alat/tambah.html` dan `penyewa/tambah.html` (`alert-success alert-dismissible`). Memakai `assets/js/form.js` (±10 baris): saat `submit`, halaman tidak di-reload, pesan "… berhasil disimpan." ditampilkan, lalu form dikosongkan. Pesan tidak muncul kalau isian wajib masih kosong (validasi `required` bawaan browser jalan lebih dulu).
5. **Perbandingan ukuran file** (diukur dari paket Bootstrap 5.3.3 yang sama dengan CDN; boleh dicocokkan dengan tab Network di DevTools):

   | | CSS murni (jobsheet03) | Bootstrap (jobsheet03-bootstrap) |
   |---|---|---|
   | File yang diunduh untuk `index.html` | `index.html` + `style.css` | `index.html` + `style.css` + `bootstrap.min.css` + `bootstrap.bundle.min.js` |
   | Ukuran mentah | ± 8,9 KB | ± 318 KB (4,1 KB milik sendiri + 232,8 KB CSS + 80,7 KB JS Bootstrap) |
   | Ukuran dikompres (gzip) | ± 2,8 KB | ± 56 KB |
   | Jumlah request | 2 | 4 (dua dari CDN) |

   Trade-off: Bootstrap mengunduh ±20x lebih banyak data, padahal sebagian besar class-nya tidak terpakai. Imbalannya, pengerjaan lebih cepat, hamburger dan alert jalan tanpa menulis JavaScript sendiri, dan tampil konsisten di semua browser. Kalau CDN-nya tidak bisa diakses (offline), halaman tampil tanpa gaya sama sekali, sedangkan CSS murni tetap jalan.

## Cara menjalankan
Buka `index.html` di browser (butuh koneksi internet karena Bootstrap dimuat dari CDN), uji dengan DevTools responsive mode pada breakpoint Bootstrap (mobile <576px, 576–767px, tablet/desktop ≥768px).

## Catatan
- Warna indigo (`#4c51bf`, `#1e1b4b`) bukan bagian tema bawaan Bootstrap, jadi diatur lewat `assets/css/style.css`: variabel `--bs-primary` untuk class `.text-primary`, variabel `--bs-btn-*` untuk tombol, dan selector biasa untuk navbar.
