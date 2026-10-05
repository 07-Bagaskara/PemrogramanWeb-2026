<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        // password_verify() membandingkan input dengan hash tersimpan,
        // tanpa pernah tahu password asli
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: ../index.php");
            exit;
        }

        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Username atau password salah.'];
        header("Location: login.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Terjadi kesalahan sistem.'];
        header("Location: login.php");
        exit;
    }
}