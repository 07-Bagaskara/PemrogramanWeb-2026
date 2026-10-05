<?php
// =================================================================
// PROSES_HAPUS.PHP
// Fungsi: Menerima id penyewa dari tombol "Hapus" di list.php,
// lalu menghapus data penyewa tersebut dari database (DELETE).
// =================================================================
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Pastikan request datang lewat metode POST dan membawa id penyewa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    try {
        $stmt = $pdo->prepare("DELETE FROM penyewa WHERE id = :id");
        $stmt->execute([':id' => $_POST['id']]);

        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Data penyewa berhasil dihapus!'
        ];

    } catch (PDOException $e) {
        // Tangkap error, misalnya kalau data penyewa masih terkait
        // dengan data peminjaman di tabel lain (foreign key constraint)
        $_SESSION['flash'] = [
            'type'  => 'error',
            'pesan' => 'Gagal menghapus: ' . $e->getMessage()
        ];
    }
}

header("Location: list.php");
exit;