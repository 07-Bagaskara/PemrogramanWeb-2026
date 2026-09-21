<?php
$base = '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'NatureRent'; ?> - Admin Panel</title>
    <!-- Menggunakan font Plus Jakarta Sans yang sangat modern -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <!-- Memaksa browser membaca versi CSS terbaru -->
    <link rel="stylesheet" href="<?php echo $base; ?>/assets/css/style.css?v=<?php echo time(); ?>">
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
                <a href="<?php echo $base; ?>/index.php" class="nav-item">📊 Dashboard</a>
                <a href="<?php echo $base; ?>/alat/list.php" class="nav-item">🎒 Inventaris Alat</a>
                <a href="<?php echo $base; ?>/penyewa/list.php" class="nav-item">⛺ Data Member</a>
            </nav>
            <div class="sidebar-footer">
                <p>SIMPUS-Mini</p>
                <p>Jobsheet 8 Edition</p>
            </div>
        </aside>

        <!-- AREA KONTEN KANAN -->
        <div class="main-wrapper">
            <header class="top-bar">
                <h1 class="page-title"><?php echo $page_title ?? 'Dashboard'; ?></h1>
                <div class="user-profile">
                    <span class="admin-badge">Admin</span>
                </div>
            </header>
            
            <main class="content-area">