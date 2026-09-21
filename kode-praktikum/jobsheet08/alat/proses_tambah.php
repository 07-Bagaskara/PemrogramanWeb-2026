<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama_alat = trim($_POST['nama_alat'] ?? '');
$merk = trim($_POST['merk'] ?? '');
$tahun_beli = $_POST['tahun_beli'] ?? '';
$kode_barang = trim($_POST['kode_barang'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');

$errors = [];
if ($nama_alat === '') $errors[] = "Nama Alat wajib diisi.";
if ($merk === '') $errors[] = "Merk wajib diisi.";
if (!is_numeric($tahun_beli) || $tahun_beli < 2000) $errors[] = "Tahun beli tidak valid.";
if (!is_numeric($stok) || $stok < 0) $errors[] = "Stok tidak boleh negatif.";

// Validasi Regex
if ($kode_barang !== '' && !preg_match('/^[0-9-]+$/', $kode_barang)) {
    $errors[] = "Kode Barang hanya boleh berisi angka dan tanda hubung (-).";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Kolom tanggal_ditambahkan otomatis diisi oleh NOW() di database
$stmt = $pdo->prepare(
    "INSERT INTO alat_kemah (nama_alat, merk, tahun_beli, kode_barang, stok, kategori)
     VALUES (:nama_alat, :merk, :tahun_beli, :kode_barang, :stok, :kategori)
     RETURNING id"
);
$stmt->execute([
    'nama_alat' => $nama_alat,
    'merk' => $merk,
    'tahun_beli' => (int) $tahun_beli,
    'kode_barang' => $kode_barang,
    'stok' => (int) $stok,
    'kategori' => $kategori,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Data Alat Kemah berhasil ditambahkan.'];
header('Location: list.php');
exit;