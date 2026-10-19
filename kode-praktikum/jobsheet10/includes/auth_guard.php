<?php
// Guard: dipanggil di awal halaman yang butuh login (index.php, alat/list.php, dst).
session_start();   // ← baris baru, WAJIB sebelum cek $_SESSION

if (!isset($_SESSION['user_id'])) {
    preg_match('#^(.*?/jobsheet\d+)(?:/|$)#', $_SERVER['REQUEST_URI'], $m);
    $baseUrl = $m[1] ?? '';
    header("Location: $baseUrl/auth/login.php");
    exit;
}