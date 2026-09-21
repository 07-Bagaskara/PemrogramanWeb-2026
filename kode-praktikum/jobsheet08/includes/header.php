<?php
$base = '/PemrogramanWeb-2026/kode-praktikum/jobsheet08'; 
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
                
                <!-- Mengubah Badge Admin Menjadi Profil Sapaan Tematik -->
                <div class="user-profile" style="display: flex; align-items: center; gap: 15px;">
                    <span style="font-weight: 700; color: #2B3674; font-size: 0.95rem;">Halo, Ranger! 👋</span>
                    <span class="admin-badge" style="background-color: #FFB547; color: white; padding: 0.5rem 1rem; border-radius: 20px; font-weight: 800; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(255, 181, 71, 0.3);">⛺ Basecamp</span>
                </div>
            </header>
            
            <main class="content-area">