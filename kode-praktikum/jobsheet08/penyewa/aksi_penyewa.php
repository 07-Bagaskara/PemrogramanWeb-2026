<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Memastikan ada aksi yang dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    
    // --- BLOK LOGIKA HAPUS PENYEWA ---
    if ($_POST['aksi'] === 'hapus' && isset($_POST['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
            $stmt->execute([':id' => $_POST['id']]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil dihapus!'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus: ' . $e->getMessage()];
        }
    }
    
}
header("Location: list.php");
exit;
?>