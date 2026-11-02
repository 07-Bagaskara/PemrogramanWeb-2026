<?php
// =================================================================
// PROSES_REGISTER.PHP
// Mendaftarkan akun baru. Password disimpan sebagai hash, bukan teks asli.
// Proteksi: token CSRF + validasi input + prepared statement.
// =================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/helpers.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registrasi.php');
    exit;
}

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$nama     = trim($_POST['nama_lengkap'] ?? '');

if ($username === '' || $password === '' || $nama === '') {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Nama lengkap, username, dan password wajib diisi.'];
    header('Location: registrasi.php');
    exit;
}

// password_hash() = hash satu arah; password asli tidak pernah disimpan.
$hash = password_hash($password, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, password_hash, nama_lengkap)
         VALUES (:username, :hash, :nama)"
    );
    $stmt->execute([
        ':username' => $username,
        ':hash'     => $hash,
        ':nama'     => $nama,
    ]);

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Registrasi berhasil, silakan login.'];
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    if ($e->getCode() == '23505') {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah terdaftar.'];
    } else {
        error_log('auth/proses_register: ' . $e->getMessage());
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mendaftar. Silakan coba lagi.'];
    }
    header('Location: registrasi.php');
    exit;
}
