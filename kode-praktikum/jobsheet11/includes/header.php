<?php
// Helper keamanan: e() untuk anti-XSS, csrf_field() untuk anti-CSRF.
// require_once = aman walau sudah dimuat oleh auth_guard.php.
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/csrf.php';

// Mendeteksi base URL folder jobsheet secara otomatis,
// berlaku untuk jobsheet07 dst.
// Lokal  : /PemrogramanWeb-2026/kode-praktikum/jobsheet11
// Vercel : /jobsheet11
preg_match('#^(.*?/jobsheet\d+)(?:/|$)#', $_SERVER['REQUEST_URI'], $m);
$baseUrl = $m[1] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($page_title ?? 'NatureRent') ?> - Admin Panel</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <!-- Memaksa browser membaca versi CSS terbaru -->
    <link rel="stylesheet" href="<?= $baseUrl ?>/assets/css/style.css?v=<?= time() ?>">
</head>
<body>
    <div class="dashboard-layout">
        
        <!-- SIDEBAR KIRI -->
        <aside class="sidebar">
            <div class="brand">
                <span class="logo-icon">🏕️</span>
                <h2>NatureRent</h2>
            </div>
            <nav class="side-nav">
                <p class="nav-label">MENU UTAMA</p>
                <a href="<?= $baseUrl ?>/index.php" class="nav-item">📊 Dashboard</a>
                <a href="<?= $baseUrl ?>/alat/list.php" class="nav-item">🎒 Inventaris Alat</a>
                <a href="<?= $baseUrl ?>/penyewa/list.php" class="nav-item">🏕️ Data Member</a>
                <a href="<?= $baseUrl ?>/auth/logout.php" class="nav-item">🚪 Logout</a>
            </nav>
            <div class="sidebar-footer">
                <p>SIMPUS-Mini</p>
                <p>Jobsheet 11 Edition</p>
            </div>
        </aside>

        <!-- AREA KONTEN KANAN -->
        <div class="main-wrapper">
            <header class="top-bar">
                <h1 class="page-title"><?= e($page_title ?? 'Dashboard') ?></h1>
                <div class="user-profile" style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-weight: 700; color: #2B3674; font-size: 0.95rem;">Halo, <?= e($_SESSION['username'] ?? 'Ranger') ?>! 👋</span>
                    <span class="admin-badge" style="background-color: #FFB547; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 800; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(255, 181, 71, 0.3);">🏕️ Basecamp</span>
                </div>
            </header>
            
            <main class="content-area">