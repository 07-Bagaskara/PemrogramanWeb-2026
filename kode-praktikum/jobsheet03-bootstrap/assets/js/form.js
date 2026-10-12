// Menampilkan komponen .alert Bootstrap setelah form disimpan (Latihan 4).
// Form tidak dikirim ke mana-mana (belum ada backend), jadi cukup menampilkan pesan.
const form = document.querySelector("form");
const area = document.getElementById("alert-area");

form.addEventListener("submit", function (e) {
    e.preventDefault(); // cegah halaman reload
    area.innerHTML =
        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
        form.dataset.pesan +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>' +
        "</div>";
    form.reset(); // kosongkan isian
});
