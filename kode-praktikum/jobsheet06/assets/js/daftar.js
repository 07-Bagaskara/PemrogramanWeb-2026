// Mengambil & menampilkan data tabel secara asinkron dari file JSON.
// Satu fungsi generik untuk Daftar Buku dan Daftar Anggota (Latihan JB 6):
// nama file JSON, daftar nama kunci kolom, dan lama delay dikirim lewat parameter.
async function muatDaftar(sumber, kunci, delay) {
    const tbody = document.querySelector(".table-responsive table tbody");
    const loading = document.getElementById("loading-indicator");
    if (!tbody) return;

    loading.style.display = "block";
    tbody.innerHTML = "";

    try {
        // simulasi delay jaringan agar loading indicator terlihat
        await new Promise((resolve) => setTimeout(resolve, delay));

        const res = await fetch(sumber);
        if (!res.ok) {
            throw new Error("Gagal mengambil data (status " + res.status + ")");
        }
        const daftar = await res.json();

        daftar.forEach(function (item) {
            const tr = document.createElement("tr");
            let isi = "";
            // satu <td> untuk tiap nama kunci, urutannya mengikuti urutan kolom di tabel
            kunci.forEach(function (namaKunci) {
                isi += "<td>" + item[namaKunci] + "</td>";
            });
            isi +=
                "<td>" +
                "<button type=\"button\">Edit</button> " +
                "<button type=\"button\" class=\"btn-hapus\">Hapus</button>" +
                "</td>";
            tr.innerHTML = isi;
            tbody.appendChild(tr);
        });

        perbaruiCounter(); // fungsi dari app.js (hanya bekerja di halaman yang punya #table-counter)
    } catch (err) {
        // colspan = jumlah kolom data + 1 kolom Aksi
        tbody.innerHTML =
            "<tr><td colspan=\"" + (kunci.length + 1) + "\">Gagal memuat data: " + err.message + "</td></tr>";
    } finally {
        loading.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const tbody = document.querySelector(".table-responsive table tbody");
    if (!tbody) return;

    // pengaturan dibaca dari atribut data-* di <tbody> pada HTML
    const sumber = tbody.dataset.sumber;
    const kunci = tbody.dataset.kunci.split(",");
    const delay = Number(tbody.dataset.delay) || 0;

    muatDaftar(sumber, kunci, delay);

    // Fitur Muat Ulang (hanya ada di halaman Daftar Buku)
    const btnRefresh = document.getElementById("btn-refresh");
    if (btnRefresh) {
        btnRefresh.addEventListener("click", function () {
            muatDaftar(sumber, kunci, delay);
        });
    }
});
