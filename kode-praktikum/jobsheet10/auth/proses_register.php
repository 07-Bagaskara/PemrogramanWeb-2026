<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama     = trim($_POST['nama_lengkap'] ?? '');

    // password_hash() mengubah password jadi hash satu arah,
    // password asli tidak pernah disimpan di database
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
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        if ($e->getCode() == '23505') {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username sudah terdaftar.'];
        } else {
            $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mendaftar: ' . $e->getMessage()];
        }
        header("Location: register.php");
        exit;
    }
}