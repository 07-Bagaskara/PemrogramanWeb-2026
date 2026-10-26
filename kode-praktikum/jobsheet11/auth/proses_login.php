<?php
// =================================================================
// PROSES_LOGIN.PHP
// Memverifikasi username & password, lalu membuat sesi login.
// Proteksi: token CSRF, prepared statement (anti SQL Injection),
// password_verify (hash), dan session_regenerate_id (anti Session Fixation).
// =================================================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../includes/helpers.php';
require __DIR__ . '/../includes/csrf.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

csrf_verify();

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    // password_verify() membandingkan input dengan hash tersimpan
    if ($user && password_verify($password, $user['password_hash'])) {
        // Ganti ID sesi SETELAH login berhasil, supaya ID sesi lama (yang mungkin
        // sudah diketahui penyerang) tidak bisa dipakai lagi -> mencegah session fixation.
        // Parameter true = hapus data sesi lama.
        session_regenerate_id(true);

        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../index.php');
        exit;
    }

    // Pesan sengaja sama untuk "username tidak ada" dan "password salah".
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
    header('Location: login.php');
    exit;

} catch (PDOException $e) {
    error_log('auth/proses_login: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem.'];
    header('Location: login.php');
    exit;
}
