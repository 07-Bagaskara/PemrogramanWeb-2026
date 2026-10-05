<?php
// Guard: dipanggil di awal halaman yang butuh login (index.php, alat/list.php, dst).
// Kalau user belum login, redirect ke halaman login sebelum ada output HTML apa pun.
if (!isset($_SESSION['user_id'])) {
    // $baseUrl sudah dihitung di header.php, tapi guard dipanggil SEBELUM header.php,
    // jadi hitung ulang di sini supaya tidak bergantung urutan include
    preg_match('#^(.*?/jobsheet\d+)(?:/|$)#', $_SERVER['REQUEST_URI'], $m);
    $baseUrl = $m[1] ?? '';
    header("Location: $baseUrl/auth/login.php");
    exit;
}