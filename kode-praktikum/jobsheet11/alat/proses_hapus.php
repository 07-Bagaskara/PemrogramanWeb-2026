<?php
// =================================================================
// PROSES_HAPUS.PHP (alat)
// Fungsi: menghapus satu alat dari database (DELETE).
// Hanya menerima POST + token CSRF, dan hanya untuk pengguna yang sudah login.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

csrf_verify();

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id !== false && $id !== null) {
    try {
        $stmt = $pdo->prepare("DELETE FROM alat_kemah WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat kemah berhasil dihapus!'];
    } catch (PDOException $e) {
        error_log('alat/proses_hapus: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data alat. Silakan coba lagi.'];
    }
}

header('Location: list.php');
exit;
