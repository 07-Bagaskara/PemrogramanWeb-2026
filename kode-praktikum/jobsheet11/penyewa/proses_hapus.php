<?php
// =================================================================
// PROSES_HAPUS.PHP (penyewa)
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
        $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil dihapus!'];
    } catch (PDOException $e) {
        error_log('penyewa/proses_hapus: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus data penyewa. Silakan coba lagi.'];
    }
}

header('Location: list.php');
exit;
