<?php
// =================================================================
// PROSES_HAPUS.PHP
// Fungsi: Menerima id alat dari tombol "Hapus" di list.php,
// lalu menghapus data alat tersebut dari database (operasi DELETE).
// =================================================================
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Pastikan request datang lewat metode POST dan membawa id alat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    try {
        // Siapkan query DELETE dengan named placeholder :id
        $stmt = $pdo->prepare("DELETE FROM alat_kemah WHERE id = :id");
        $stmt->execute([':id' => $_POST['id']]);

        // Simpan pesan sukses ke session
        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Alat kemah berhasil dihapus!'
        ];

    } catch (PDOException $e) {
        // Tangkap error kalau penghapusan gagal
        // (misal data terkait tabel lain lewat foreign key)
        $_SESSION['flash'] = [
            'type'  => 'error',
            'pesan' => 'Gagal menghapus: ' . $e->getMessage()
        ];
    }
}

// Kembali ke halaman list setelah proses selesai
header("Location: list.php");
exit;