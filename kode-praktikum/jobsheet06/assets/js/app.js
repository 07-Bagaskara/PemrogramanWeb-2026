/* =====================================================================
   app.js | Jobsheet 6  (dipakai di SEMUA halaman jobsheet 6)

   PETA FILE (urutan fungsi = urutan dari atas):
   1. initNavToggle      -> tombol hamburger buka/tutup menu
   2. initHapusConfirm   -> klik tombol Hapus: konfirmasi lalu hapus baris
   3. perbaruiCounter    -> menulis "Menampilkan X dari Y data"
      initCounter        -> memanggil perbaruiCounter saat halaman dibuka
   4. initTableFilter    -> kotak pencarian yang menyaring baris tabel
   5. tampilkanError / hapusError -> membuat dan menghapus pesan error merah
   6. initValidasiForm   -> pemeriksaan isian form saat tombol Simpan ditekan
   7. DOMContentLoaded   -> di paling bawah: menjalankan semua fungsi init

   ISTILAH:
   - document.getElementById("x")  = ambil elemen HTML ber-id "x"
   - document.querySelector("css") = ambil elemen PERTAMA yang cocok selector CSS
   - querySelectorAll("css")       = ambil SEMUA yang cocok (hasilnya daftar)
   - if (!x) return;               = kalau elemennya tidak ada di halaman ini,
                                     berhenti (supaya tidak error di halaman lain)
   ===================================================================== */

// ===== 1. Hamburger menu (JS-driven) =====
// Fungsi: saat tombol hamburger diklik, menu dibuka atau ditutup.
// Caranya: menambah / melepas class "nav-open" pada <nav>. CSS-nya ada di
// style.css (header nav.nav-open) dan hanya terlihat di layar <= 480px.
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn"); // tombol hamburger
    const nav = document.querySelector("header nav");            // menu di sidebar
    if (!toggleBtn || !nav) return;                              // tidak ada? berhenti

    toggleBtn.addEventListener("click", function () {
        // toggle = kalau class sudah ada dilepas, kalau belum ada ditambahkan
        nav.classList.toggle("nav-open");
    });
}

// ===== 2. Konfirmasi hapus (Event Delegation - Khusus JB 6) =====
// Fungsi: klik tombol Hapus -> muncul kotak konfirmasi -> kalau "OK",
// baris tabel dihapus dan counter diperbarui.
// Event delegation = SATU listener dipasang di seluruh halaman (document),
// bukan satu per tombol. Perlu begini karena baris tabel jobsheet 6 dibuat
// belakangan oleh daftar.js (fetch), jadi tombolnya belum ada saat halaman
// pertama dibuka. Klik apa pun di halaman akan lewat sini, lalu kita cek
// apakah yang diklik itu tombol Hapus.
function initHapusConfirm() {
    document.addEventListener("click", function (e) {
        // e.target = elemen yang benar-benar diklik. Latihan JB6: ditulis ke Console (F12)
        console.log("Elemen yang diklik:", e.target);

        // closest(".btn-hapus") = naik dari elemen yang diklik sampai ketemu
        // elemen ber-class btn-hapus. Kalau tidak ketemu (klik di tempat lain) -> null
        const btn = e.target.closest(".btn-hapus");
        if (!btn) return; // bukan tombol Hapus, abaikan

        const row = btn.closest("tr"); // baris <tr> tempat tombol itu berada
        // nama = isi sel pertama baris (nama alat / no. identitas) untuk ditampilkan di konfirmasi
        const nama = row ? row.querySelector("td")?.textContent : "data ini";
        const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?"); // true bila klik OK
        if (yakin && row) {
            row.remove();        // hapus baris dari tabel
            perbaruiCounter();   // hitung ulang "Menampilkan X dari Y data"
        }
    });
}

// ===== 3. Counter jumlah baris (Latihan JB 5) =====
// Fungsi: menulis di <p id="table-counter"> berapa baris yang tampil dan
// berapa total barisnya. Dipanggil setelah filter, setelah hapus, dan
// setelah data selesai dimuat (dari daftar.js).
function perbaruiCounter() {
    const counter = document.getElementById("table-counter");
    const table = document.querySelector(".table-responsive table");
    if (!counter || !table) return; // halaman tanpa counter/tabel (mis. halaman form): berhenti

    const rows = table.querySelectorAll("tbody tr"); // semua baris isi (bukan baris judul)
    let visibleCount = 0;                            // jumlah baris yang sedang tampil
    rows.forEach(function (row) {
        // baris yang disembunyikan filter bernilai display = "none", jadi tidak dihitung
        if (row.style.display !== "none") visibleCount++;
    });
    // `...${x}...` = template string: nilai x disisipkan ke dalam teks
    counter.textContent = `Menampilkan ${visibleCount} dari ${rows.length} data`;
}

// Fungsi: mengisi counter saat halaman dibuka, tetapi hanya kalau tabelnya
// sudah berisi baris (tabel statis jobsheet 5). Di jobsheet 6 barisnya belum
// ada saat halaman dibuka, jadi counter diisi oleh daftar.js setelah fetch selesai.
function initCounter() {
    if (document.querySelector(".table-responsive tbody tr")) perbaruiCounter();
}

// ===== 4. Filter 1 Kolom & Counter (Latihan JB 5) =====
// Fungsi: saat mengetik di kotak pencarian, baris yang tidak mengandung kata
// itu disembunyikan (style.display = "none"). Kolom yang dicari ditentukan
// atribut data-kolom pada <input id="search-input"> di HTML:
// alat = 1 (Nama Alat), penyewa = 2 (Nama).
function initTableFilter() {
    const input = document.getElementById("search-input");
    // nomor kolom yang dicari dibaca dari atribut data-kolom di HTML (alat = 1, penyewa = 2)
    // input.dataset.kolom = nilai atribut data-kolom. Kalau tidak ada, pakai 1
    const nomorKolom = input ? (input.dataset.kolom || 1) : 1;
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    // "keyup" = terjadi tiap kali sebuah tombol keyboard dilepas
    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase(); // kata yang diketik, huruf kecil semua
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            // "td:nth-child(n)" = sel ke-n di baris itu (kolom yang dicari)
            const kolomTarget = row.querySelector("td:nth-child(" + nomorKolom + ")");
            const teks = kolomTarget ? kolomTarget.textContent.toLowerCase() : "";

            if (teks.includes(keyword)) {   // teks sel mengandung kata yang diketik?
                row.style.display = "";     // ya -> tampilkan baris (kembali ke bawaan)
            } else {
                row.style.display = "none"; // tidak -> sembunyikan baris
            }
        });

        perbaruiCounter(); // perbarui "Menampilkan X dari Y data"
    });
}

// ===== 5. Pesan error validasi =====
// tampilkanError: membuat <span class="error">pesan</span> tepat di bawah
// kotak isian yang salah (gaya merah ada di style.css, .error).
function tampilkanError(input, pesan) {
    hapusError(input); // hapus pesan lama dulu supaya tidak menumpuk
    const span = document.createElement("span"); // buat elemen <span> baru
    span.className = "error";                    // beri class "error"
    span.textContent = pesan;                    // isi teks pesannya
    input.insertAdjacentElement("afterend", span); // sisipkan tepat setelah <input>
}

// hapusError: menghapus pesan error yang menempel tepat di bawah sebuah isian.
function hapusError(input) {
    const next = input.nextElementSibling; // elemen tepat setelah <input>
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

// ===== 6. Refaktor Array & Validasi Kode Barang (Latihan JB 5) =====
// Fungsi: dipasang di form (id="form-tambah"). Saat tombol Simpan ditekan
// (event "submit"), semua isian diperiksa. Kalau ada yang salah, pengiriman
// form dibatalkan dengan e.preventDefault() dan pesan merah ditampilkan.
// Variabel "valid" awalnya true; menjadi false bila ada satu saja yang salah.
function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return; // halaman ini bukan halaman form

    form.addEventListener("submit", function (e) {
        let valid = true;

        // (a) Isian wajib: array nama field, diperiksa satu per satu dengan forEach.
        // Isian yang tidak ada di halaman ini (mis. 'nama_alat' di form penyewa) dilewati.
        const fieldWajib = ['nama_alat', 'nama', 'merk'];
        fieldWajib.forEach(function(namaField) {
            // [name='nama_alat'] = selector atribut: cari isian ber-name="nama_alat"
            const input = form.querySelector(`[name='${namaField}']`);
            if (input && input.value.trim() === "") { // trim() membuang spasi di ujung
                tampilkanError(input, "Field ini wajib diisi.");
                valid = false;
            } else if (input) {
                hapusError(input); // sudah benar -> hapus pesan lama
            }
        });

        // (b) Kode Barang (boleh kosong): kalau diisi hanya boleh angka dan tanda hubung.
        const kodeBarang = form.querySelector("[name='kode_barang']");
        if (kodeBarang && kodeBarang.value.trim() !== "") {
            // regex /^[0-9-]+$/ = dari awal sampai akhir hanya berisi 0-9 dan "-"
            const regex = /^[0-9-]+$/;
            if (!regex.test(kodeBarang.value)) {
                tampilkanError(kodeBarang, "Kode Barang hanya boleh angka dan tanda hubung (-).");
                valid = false;
            } else {
                hapusError(kodeBarang);
            }
        }

        // (c) Tahun beli: harus angka antara 1900 dan 2026.
        const tahun = form.querySelector("[name='tahun_beli']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10); // ubah teks jadi bilangan bulat
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) { // isNaN = bukan angka
                tampilkanError(tahun, "Tahun beli harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

        // (d) Stok: harus angka dan tidak boleh negatif.
        const stok = form.querySelector("[name='stok']");
        if (stok) {
            const nilai = parseInt(stok.value, 10);
            if (isNaN(nilai) || nilai < 0) {
                tampilkanError(stok, "Stok tidak boleh negatif.");
                valid = false;
            } else {
                hapusError(stok);
            }
        }

        // ada yang salah? batalkan pengiriman form
        if (!valid) e.preventDefault();
    });
}

// ===== 7. Titik masuk =====
// "DOMContentLoaded" = terjadi setelah seluruh HTML selesai dibaca browser,
// jadi semua elemen sudah ada. Di sinilah semua fungsi di atas dijalankan.
// Fungsi yang elemennya tidak ada di halaman itu akan berhenti sendiri (if ... return).
document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initCounter();
    initValidasiForm();
});
