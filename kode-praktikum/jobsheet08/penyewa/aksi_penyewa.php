<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

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
    
    // --- BLOK LOGIKA EDIT PENYEWA (BARU) ---
    elseif ($_POST['aksi'] === 'edit' && isset($_POST['id'])) {
        try {
            // Pastikan kolom DB (nama vs nama_lengkap) sesuai dengan query ini.
            // Jika Supabase Anda pakai 'nama_lengkap', ubah 'nama = :nama' menjadi 'nama_lengkap = :nama'
            $stmt = $pdo->prepare("UPDATE penyewa SET nama = :nama, no_identitas = :no_identitas, no_hp = :no_hp, alamat = :alamat WHERE id = :id");
            $stmt->execute([
                ':nama' => $_POST['nama'],
                ':no_identitas' => $_POST['no_identitas'],
                ':no_hp' => $_POST['no_hp'],
                ':alamat' => $_POST['alamat'],
                ':id' => $_POST['id']
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data penyewa berhasil diperbarui!'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()];
        }
    }
}

header("Location: list.php");
exit;
?>