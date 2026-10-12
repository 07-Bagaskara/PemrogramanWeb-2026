// ===== Hamburger menu (JS-driven, menggantikan checkbox hack) =====
function initNavToggle() {
    const toggleBtn = document.getElementById("nav-toggle-btn");
    const nav = document.querySelector("header nav");
    if (!toggleBtn || !nav) return;

    toggleBtn.addEventListener("click", function () {
        nav.classList.toggle("nav-open");
    });
}

// ===== Konfirmasi hapus (front-end only, belum ke server) =====
function initHapusConfirm() {
    document.querySelectorAll(".btn-hapus").forEach(function (btn) {
        btn.addEventListener("click", function () {
            const row = btn.closest("tr");
            const nama = row ? row.querySelector("td")?.textContent : "data ini";
            const yakin = confirm("Yakin ingin menghapus \"" + nama + "\"?");
            if (yakin && row) {
                row.remove();
                perbaruiCounter();
            }
        });
    });
}

// ===== Counter jumlah baris (Latihan JB 5) =====
// Dipanggil setelah filter, setelah hapus, dan setelah data selesai dimuat.
function perbaruiCounter() {
    const counter = document.getElementById("table-counter");
    const table = document.querySelector(".table-responsive table");
    if (!counter || !table) return;

    const rows = table.querySelectorAll("tbody tr");
    let visibleCount = 0;
    rows.forEach(function (row) {
        if (row.style.display !== "none") visibleCount++;
    });
    counter.textContent = `Menampilkan ${visibleCount} dari ${rows.length} data`;
}

// Isi counter saat halaman dibuka, hanya kalau tabel sudah berisi baris (tabel statis JB5)
function initCounter() {
    if (document.querySelector(".table-responsive tbody tr")) perbaruiCounter();
}

// ===== Filter 1 Kolom & Counter =====
function initTableFilter() {
    const input = document.getElementById("search-input");
    // nomor kolom yang dicari dibaca dari atribut data-kolom di HTML (alat = 1, penyewa = 2)
    const nomorKolom = input ? (input.dataset.kolom || 1) : 1;
    const table = document.querySelector(".table-responsive table");
    if (!input || !table) return;

    input.addEventListener("keyup", function () {
        const keyword = input.value.toLowerCase();
        const rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            // Hanya mencari di kolom yang ditentukan data-kolom (alat = Nama Alat, penyewa = Nama)
            const kolomTarget = row.querySelector("td:nth-child(" + nomorKolom + ")");
            const teks = kolomTarget ? kolomTarget.textContent.toLowerCase() : "";
            
            if (teks.includes(keyword)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
        
        perbaruiCounter();
    });
}

// ===== Validasi form (client-side) =====
function tampilkanError(input, pesan) {
    hapusError(input);
    const span = document.createElement("span");
    span.className = "error";
    span.textContent = pesan;
    input.insertAdjacentElement("afterend", span);
}

function hapusError(input) {
    const next = input.nextElementSibling;
    if (next && next.classList.contains("error")) {
        next.remove();
    }
}

function initValidasiForm() {
    const form = document.getElementById("form-tambah");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        let valid = true;

        // 1. Refactor mengecek field wajib pakai Array & forEach
        const fieldWajib = ['nama_alat', 'nama', 'merk'];
        fieldWajib.forEach(function(namaField) {
            const input = form.querySelector(`[name='${namaField}']`);
            if (input && input.value.trim() === "") {
                tampilkanError(input, "Field ini wajib diisi.");
                valid = false;
            } else if (input) {
                hapusError(input);
            }
        });

        // 2. Validasi field baru (Regex Kode Barang)
        const kodeBarang = form.querySelector("[name='kode_barang']");
        if (kodeBarang && kodeBarang.value.trim() !== "") {
            const regex = /^[0-9-]+$/; // Hanya boleh angka dan tanda hubung
            if (!regex.test(kodeBarang.value)) {
                tampilkanError(kodeBarang, "Kode Barang hanya boleh angka dan tanda hubung (-).");
                valid = false;
            } else {
                hapusError(kodeBarang);
            }
        }

        const tahun = form.querySelector("[name='tahun_beli']");
        if (tahun) {
            const nilai = parseInt(tahun.value, 10);
            if (isNaN(nilai) || nilai < 1900 || nilai > 2026) {
                tampilkanError(tahun, "Tahun beli harus di antara 1900-2026.");
                valid = false;
            } else {
                hapusError(tahun);
            }
        }

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

        if (!valid) {
            e.preventDefault();
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    initNavToggle();
    initHapusConfirm();
    initTableFilter();
    initCounter();
    initValidasiForm();
});
