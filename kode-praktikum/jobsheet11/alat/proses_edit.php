<?php
// =================================================================
// PROSES_EDIT.PHP (alat)
// Fungsi: menerima data dari edit.php lalu UPDATE data alat di database.
// Urutan pengamanan: login (auth_guard) -> token CSRF -> validasi -> query.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
require __DIR__ . '/../includes/validasi.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

// id harus bilangan bulat; nilai lain langsung ditolak.
$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: list.php');
    exit;
}

// Validasi yang sama dengan proses_tambah.php (sebelumnya jalur edit tidak divalidasi).
$errors = validasi_alat($_POST);
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    // Prepared statement: nilai dikirim terpisah dari SQL, aman dari SQL Injection.
    $stmt = $pdo->prepare(
        "UPDATE alat_kemah
         SET nama_alat = :nama_alat, merk = :merk, tahun_beli = :tahun_beli,
             kode_barang = :kode_barang, stok = :stok, kategori = :kategori
         WHERE id = :id"
    );
    $stmt->execute([
        ':nama_alat'   => trim($_POST['nama_alat']),
        ':merk'        => trim($_POST['merk']),
        ':tahun_beli'  => (int) $_POST['tahun_beli'],
        ':kode_barang' => trim($_POST['kode_barang'] ?? ''),
        ':stok'        => (int) $_POST['stok'],
        ':kategori'    => $_POST['kategori'],
        ':id'          => $id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat kemah berhasil diperbarui!'];

} catch (PDOException $e) {
    error_log('alat/proses_edit: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data alat. Silakan coba lagi.'];
}

header('Location: list.php');
exit;
