<?php
// =================================================================
// PROSES_TAMBAH.PHP (penyewa)
// Urutan pengamanan: login (auth_guard) -> token CSRF -> validasi -> query.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
require __DIR__ . '/../includes/validasi_penyewa.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

$errors = validasi_penyewa($_POST);
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

try {
    $stmt = $pdo->prepare(
        "INSERT INTO penyewa (nama, no_identitas, alamat, no_hp)
         VALUES (:nama, :no_identitas, :alamat, :no_hp)
         RETURNING id"
    );
    $stmt->execute([
        'nama'         => trim($_POST['nama']),
        'no_identitas' => trim($_POST['no_identitas']),
        'alamat'       => trim($_POST['alamat'] ?? ''),
        'no_hp'        => trim($_POST['no_hp'] ?? ''),
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Penyewa berhasil ditambahkan.'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    // 23505 = kode standar PostgreSQL untuk pelanggaran UNIQUE constraint
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal: No. Identitas tersebut sudah terdaftar di sistem!'];
    } else {
        error_log('penyewa/proses_tambah: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem. Silakan coba lagi.'];
    }
    header('Location: tambah.php');
    exit;
}
