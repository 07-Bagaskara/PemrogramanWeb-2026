<?php
// =================================================================
// PROSES_TAMBAH.PHP (alat)
// Fungsi: menerima data dari tambah.php lalu INSERT ke database.
// Urutan pengamanan: login (auth_guard) -> token CSRF -> validasi -> query.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';   // cek login dulu + session + helper
require __DIR__ . '/../includes/validasi.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();   // tolak request tanpa token CSRF yang valid (HTTP 403)

$errors = validasi_alat($_POST);
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO alat_kemah (nama_alat, merk, tahun_beli, kode_barang, stok, kategori)
         VALUES (:nama_alat, :merk, :tahun_beli, :kode_barang, :stok, :kategori)"
    );
    $stmt->execute([
        ':nama_alat'   => trim($_POST['nama_alat']),
        ':merk'        => trim($_POST['merk']),
        ':tahun_beli'  => (int) $_POST['tahun_beli'],
        ':kode_barang' => trim($_POST['kode_barang'] ?? ''),
        ':stok'        => (int) $_POST['stok'],
        ':kategori'    => $_POST['kategori'],
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat kemah berhasil ditambahkan!'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    // Detail error hanya ke log server, pengguna cukup melihat pesan umum.
    error_log('alat/proses_tambah: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan data alat. Silakan coba lagi.'];
    header('Location: tambah.php');
    exit;
}
