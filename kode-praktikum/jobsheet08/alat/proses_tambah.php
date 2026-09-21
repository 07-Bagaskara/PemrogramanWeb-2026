<?php
ob_start(); // JURUS AMPUH: Menahan semua error spasi agar redirect tetap jalan
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_alat = trim($_POST['nama_alat']);
    $merk = trim($_POST['merk']);
    $tahun_beli = $_POST['tahun_beli'];
    $kode_barang = trim($_POST['kode_barang']);
    $stok = (int)$_POST['stok'];
    $kategori = $_POST['kategori'];

    if (!empty($kode_barang) && !preg_match('/^[0-9-]+$/', $kode_barang)) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal: Kode Barang hanya boleh angka dan strip.'];
        header("Location: tambah.php");
        exit;
    }

    try {
        $sql = "INSERT INTO alat_kemah (nama_alat, merk, tahun_beli, kode_barang, stok, kategori) 
                VALUES (:nama_alat, :merk, :tahun_beli, :kode_barang, :stok, :kategori)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama_alat' => $nama_alat,
            ':merk' => $merk,
            ':tahun_beli' => $tahun_beli,
            ':kode_barang' => $kode_barang,
            ':stok' => $stok,
            ':kategori' => $kategori
        ]);

        $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat kemah berhasil ditambahkan!'];
        header("Location: list.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal menyimpan: ' . $e->getMessage()];
        header("Location: tambah.php");
        exit;
    }
} else {
    header("Location: list.php");
    exit;
}
ob_end_flush();
?>