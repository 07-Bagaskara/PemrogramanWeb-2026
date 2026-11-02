<?php
// =================================================================
// PROSES_EDIT.PHP (penyewa)
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

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    header('Location: list.php');
    exit;
}

$errors = validasi_penyewa($_POST);
if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    $stmt = $pdo->prepare(
        "UPDATE penyewa
         SET nama = :nama, no_identitas = :no_identitas, no_hp = :no_hp, alamat = :alamat
         WHERE id = :id"
    );
    $stmt->execute([
        ':nama'         => trim($_POST['nama']),
        ':no_identitas' => trim($_POST['no_identitas']),
        ':no_hp'        => trim($_POST['no_hp'] ?? ''),
        ':alamat'       => trim($_POST['alamat'] ?? ''),
        ':id'           => $id,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil diperbarui!'];

} catch (PDOException $e) {
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal: No. Identitas tersebut sudah dipakai penyewa lain.'];
    } else {
        error_log('penyewa/proses_edit: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data penyewa. Silakan coba lagi.'];
    }
}

header('Location: list.php');
exit;
