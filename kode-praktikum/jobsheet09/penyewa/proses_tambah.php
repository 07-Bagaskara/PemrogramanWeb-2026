<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

$nama = trim($_POST['nama'] ?? '');
$no_identitas = trim($_POST['no_identitas'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');

$errors = [];
if ($nama === '') $errors[] = "Nama wajib diisi.";
if ($no_identitas === '') $errors[] = "No. Identitas wajib diisi.";

// Validasi Regex dari Jobsheet 7
if ($no_hp !== '' && !preg_match('/^[0-9]+$/', $no_hp)) {
    $errors[] = "No. HP hanya boleh berisi angka.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

// Ide Latihan 1: Menggunakan Try-Catch untuk menangani duplikasi No Identitas (UNIQUE)
try {
    $stmt = $pdo->prepare(
        "INSERT INTO penyewa (nama, no_identitas, alamat, no_hp)
         VALUES (:nama, :no_identitas, :alamat, :no_hp)
         RETURNING id"
    );
    $stmt->execute([
        'nama' => $nama,
        'no_identitas' => $no_identitas,
        'alamat' => $alamat,
        'no_hp' => $no_hp,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Penyewa berhasil ditambahkan.'];
    header('Location: list.php');
    exit;

} catch (PDOException $e) {
    // Error Code 23505 adalah kode standar PostgreSQL untuk pelanggaran UNIQUE constraint
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal: No. Identitas tersebut sudah terdaftar di sistem!'];
    } else {
        // Jika error lain, tampilkan pesan default
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem: ' . $e->getMessage()];
    }
    header('Location: tambah.php');
    exit;
}