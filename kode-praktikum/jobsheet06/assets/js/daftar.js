/* =====================================================================
   daftar.js | Jobsheet 6  (dipakai di alat/list.html dan penyewa/list.html)

   ALUR KERJA (dari halaman dibuka sampai tabel terisi):
   1. Halaman selesai dibaca -> DOMContentLoaded (paling bawah file ini).
   2. Pengaturan dibaca dari atribut data-* pada <tbody> di HTML:
        data-sumber = alamat file JSON       (mis. ../data/alat.json)
        data-kunci  = nama field, urutannya = urutan kolom tabel
        data-delay  = lama jeda buatan (milidetik)
   3. muatDaftar() dipanggil: tampilkan "Memuat data..." -> tunggu delay ->
      fetch file JSON -> untuk tiap data buat satu baris <tr> -> sembunyikan
      "Memuat data...". Kalau gagal, tampilkan pesan error di tabel.
   ===================================================================== */

// Mengambil & menampilkan data tabel secara asinkron dari file JSON.
// Satu fungsi generik untuk Daftar Alat dan Daftar Penyewa (Latihan JB 6):
// nama file JSON, daftar nama kunci kolom, dan lama delay dikirim lewat parameter.
//   sumber = alamat file JSON, kunci = daftar nama field, delay = jeda (ms)
// "async" = fungsi ini boleh memakai "await" (menunggu proses yang butuh waktu)
async function muatDaftar(sumber, kunci, delay) {
    const tbody = document.querySelector(".table-responsive table tbody"); // bagian isi tabel
    const loading = document.getElementById("loading-indicator");          // tulisan "Memuat data..."
    if (!tbody) return;

    loading.style.display = "block"; // tampilkan "Memuat data..."
    tbody.innerHTML = "";            // kosongkan tabel (penting untuk tombol Muat Ulang)

    // try ... catch ... finally:
    //   try     = coba jalankan kode ini
    //   catch   = kalau ada error di dalam try, lompat ke sini
    //   finally = SELALU dijalankan di akhir, berhasil maupun gagal
    try {
        // simulasi delay jaringan agar loading indicator terlihat
        // (menunggu "delay" milidetik; await = tunggu sampai selesai)
        await new Promise((resolve) => setTimeout(resolve, delay));

        // fetch = minta file JSON. Hasilnya "res" (response / jawaban server)
        const res = await fetch(sumber);
        // res.ok bernilai false bila statusnya error (mis. 404 file tidak ada).
        // fetch tidak error sendiri untuk 404, jadi kita lempar error manual.
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftar = await res.json(); // ubah isi JSON menjadi array JavaScript

        // Untuk setiap data (satu alat / satu penyewa) buat satu baris tabel.
        daftar.forEach(function (item) {
            const tr = document.createElement("tr"); // buat elemen <tr> baru (belum masuk halaman)
            let isi = "";
            // satu <td> untuk tiap nama kunci, urutannya mengikuti urutan kolom di tabel
            // contoh: item["nama_alat"] -> "Tenda Dome 4 Orang"
            kunci.forEach(function (namaKunci) {
                isi += "<td>" + item[namaKunci] + "</td>";
            });
            // sel terakhir: kolom Aksi berisi tombol Edit dan Hapus.
            // class "btn-hapus" dipakai app.js (initHapusConfirm) untuk mengenali tombol Hapus
            isi +=
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tr.innerHTML = isi;      // isi baris dengan HTML yang sudah dirakit
            tbody.appendChild(tr);   // masukkan baris ke tabel (baru tampil di sini)
        });

        perbaruiCounter(); // fungsi dari app.js (hanya bekerja di halaman yang punya #table-counter)
    } catch (err) {
        // Gagal (mis. file tidak ketemu): tampilkan pesan satu baris di tabel.
        // colspan = jumlah kolom data + 1 kolom Aksi (sel melebar selebar tabel)
        tbody.innerHTML =
            "<tr><td colspan=\"" + (kunci.length + 1) + "\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none"; // sembunyikan "Memuat data..." apa pun hasilnya
    }
}

// Titik masuk: dijalankan setelah seluruh HTML selesai dibaca browser.
document.addEventListener("DOMContentLoaded", function () {
    const tbody = document.querySelector(".table-responsive table tbody");
    if (!tbody) return; // halaman ini tidak punya tabel

    // pengaturan dibaca dari atribut data-* di <tbody> pada HTML
    // tbody.dataset.sumber = nilai atribut data-sumber, dst.
    const sumber = tbody.dataset.sumber;
    const kunci = tbody.dataset.kunci.split(","); // "a,b,c" dipecah jadi array ["a","b","c"]
    const delay = Number(tbody.dataset.delay) || 0; // ubah teks jadi angka; kosong -> 0

    muatDaftar(sumber, kunci, delay); // muat data pertama kali

    // Fitur Muat Ulang (hanya ada di halaman Daftar Alat)
    const btnRefresh = document.getElementById("btn-refresh");
    if (btnRefresh) {
        btnRefresh.addEventListener("click", function () {
            muatDaftar(sumber, kunci, delay); // ambil ulang data dari awal
        });
    }
});
