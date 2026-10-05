<?php
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/koneksi.php';

$totalAlat = $pdo->query("SELECT COUNT(*) FROM alat_kemah")->fetchColumn();
$totalPenyewa = $pdo->query("SELECT COUNT(*) FROM penyewa")->fetchColumn();
?>

<section class="hero-section" style="margin-bottom: 3rem;">
    <h2 style="color: #2B3674; margin-bottom: 0.5rem; font-weight: 800; font-size: 1.8rem;">Selamat Datang di NatureRent 🏕️</h2>
    <p style="color: #A3AED0; font-size: 1.05rem; max-width: 800px; line-height: 1.8; font-weight: 500;">
        Kelola inventaris peralatan pendakian dan data penyewa dengan lebih cepat, rapi, dan terorganisir. Pantau ketersediaan tenda, perlengkapan masak, hingga detail penyewa dalam satu pusat kendali.
    </p>
</section>

<section class="stats-section">
    <h2 class="section-title" style="color: #2B3674; font-size: 1.2rem; font-weight: 700; margin-bottom: 1rem;">Overview Inventaris</h2>
    <div class="stat-grid">
        <article class="stat-card">
            <h3>Total Alat Kemah</h3>
            <p class="stat-number"><?php echo $totalAlat; ?></p>
        </article>
        
        <article class="stat-card accent-orange">
            <h3>Total Penyewa (Member)</h3>
            <p class="stat-number"><?php echo $totalPenyewa; ?></p>
        </article>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>