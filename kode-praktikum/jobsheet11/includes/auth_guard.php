<?php
// Guard: dipanggil di baris paling atas halaman yang butuh login
// (sebelum header.php mengeluarkan output apa pun, supaya header('Location') masih bisa jalan).
// Sekaligus memuat helper keamanan e() dan csrf_*().
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

if (!isset($_SESSION['user_id'])) {
    preg_match('#^(.*?/jobsheet\d+)(?:/|$)#', $_SERVER['REQUEST_URI'], $m);
    $baseUrl = $m[1] ?? '';
    header("Location: $baseUrl/auth/login.php");
    exit;
}
