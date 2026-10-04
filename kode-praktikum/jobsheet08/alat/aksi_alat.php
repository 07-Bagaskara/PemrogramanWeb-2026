<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Memastikan ada aksi yang dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi'])) {
    
    // --- BLOK LOGIKA HAPUS ---
    if ($_POST['aksi'] === 'hapus' && isset($_POST['id'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM alat_kemah WHERE id = :id");
            $stmt->execute([':id' => $_POST['id']]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat kemah berhasil dihapus!'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menghapus: ' . $e->getMessage()];
        }
    }
    
    // --- BLOK LOGIKA EDIT ---
    elseif ($_POST['aksi'] === 'edit' && isset($_POST['id'])) {
        try {
            $stmt = $pdo->prepare("UPDATE alat_kemah SET nama_alat = :nama_alat, merk = :merk, tahun_beli = :tahun_beli, kode_barang = :kode_barang, stok = :stok, kategori = :kategori WHERE id = :id");
            $stmt->execute([
                ':nama_alat' => $_POST['nama_alat'],
                ':merk' => $_POST['merk'],
                ':tahun_beli' => $_POST['tahun_beli'],
                ':kode_barang' => $_POST['kode_barang'],
                ':stok' => $_POST['stok'],
                ':kategori' => $_POST['kategori'],
                ':id' => $_POST['id']
            ]);
            $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data alat kemah berhasil diperbarui!'];
        } catch (PDOException $e) {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memperbarui alat: ' . $e->getMessage()];
        }
    }
    
}

header("Location: list.php");
exit;
?>