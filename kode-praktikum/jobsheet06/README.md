# NatureRent: Jobsheet 6 (Fetch API & JSON)


## Deskripsi Praktikum
Jobsheet 6 berfokus pada integrasi data asinkron (*Asynchronous*). Baris data HTML yang sebelumnya diketik secara manual (*hardcoded*) telah dihapus sepenuhnya dan digantikan oleh aliran data yang ditarik secara langsung dari *database* statis (file JSON) menggunakan antarmuka **Fetch API**.

## Arsitektur Data yang Diimplementasikan
1. **Pemisahan Sumber Data (JSON)**
   Data alat dan penyewa kini disimpan dalam format *Array of Objects* di dalam folder terpisah (`data/alat.json` dan `data/penyewa.json`). Hal ini membuat struktur data lebih rapi dan merepresentasikan respons dari *backend server* sungguhan.
2. **Rendering Data Asinkron (`daftar.js`)**
   Memanfaatkan fungsi asinkron `async/await` dan `fetch()` untuk membaca file JSON. Data yang berhasil diambil kemudian di-*looping* menggunakan `.forEach()` untuk merakit elemen `<tr>` dan `<td>`, lalu disuntikkan (*append*) ke dalam `<tbody>` tabel yang kosong.
3. **Simulasi Loading Indicator**
   Mengimplementasikan `setTimeout()` untuk menunda pemuatan data (600ms untuk penyewa, 3000ms untuk alat). Selama proses tunggu ini, *Loading Indicator* ditampilkan ke layar untuk memberikan *feedback* visual kepada pengguna (UI/UX yang baik untuk koneksi lambat).
4. **Event Delegation (Penanganan Tombol Dinamis)**
   Fungsi tombol "Hapus" pada `app.js` direfaktor menggunakan teknik *Event Delegation* pada level `document`. Karena baris tabel tidak ada saat halaman pertama kali dimuat (menunggu proses *Fetch* selesai), penambahan *event listener* langsung ke tombol tidak akan bekerja. Sistem kini "mendengarkan" seluruh klik pada halaman dan menyaringnya menggunakan metode `e.target.closest('.btn-hapus')`.

## Ide Latihan Tambahan (Opsional)
1. **Tombol "Muat Ulang Data"** di Daftar Alat memanggil ulang `muatDaftar(...)`.
2. **`alat.js` dan `penyewa.js` disatukan** menjadi satu fungsi generik `muatDaftar(sumber, kunci, delay)` di `assets/js/daftar.js`. Pengaturan tiap halaman dibaca dari atribut `data-sumber`, `data-kunci`, dan `data-delay` pada `<tbody>` di HTML. `colspan` pesan error dihitung otomatis dari jumlah kunci + 1 kolom Aksi.
3. **Kolom `kategori`** ditambahkan di `data/alat.json`, di `<th>` pada `alat/list.html`, dan pada daftar kunci di `data-kunci`.
4. **`console.log(e.target)`** ada di awal `initHapusConfirm` untuk melihat bagaimana `document` menerima semua klik, lalu disaring dengan `e.target.closest(".btn-hapus")`.
5. **Delay simulasi** Daftar Alat diubah dari 600 menjadi 3000 ms agar loading indicator terlihat jelas (`data-delay="3000"`).
