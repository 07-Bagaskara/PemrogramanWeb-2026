<?php
// =================================================================
// SEWA/TAMBAH.PHP
// Form transaksi sewa baru: pilih penyewa, pilih alat (hanya yang stoknya
// masih ada), dan isi jumlah. Prosesnya ada di proses_tambah.php.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
$page_title = "Sewa Baru";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

// Data untuk dropdown. Alat dengan stok 0 sengaja tidak ditampilkan.
$daftarPenyewa = $pdo->query("SELECT id, nama, no_identitas FROM penyewa ORDER BY nama")->fetchAll();
$daftarAlat = $pdo->query("SELECT id, nama_alat, merk, stok FROM alat_kemah WHERE stok > 0 ORDER BY nama_alat")->fetchAll();
?>

<section>
    <h2>Transaksi Sewa Baru</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?= e($_SESSION['flash']['type']) ?>">
            <?= e($_SESSION['flash']['pesan']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <?php if (empty($daftarPenyewa)): ?>
        <div class="flash flash-error">Belum ada data penyewa. Tambahkan penyewa terlebih dahulu.</div>
    <?php elseif (empty($daftarAlat)): ?>
        <div class="flash flash-error">Tidak ada alat dengan stok tersedia saat ini.</div>
    <?php else: ?>
    <form action="proses_tambah.php" method="POST">
        <?= csrf_field() ?>
        <p>
            <label for="penyewa_id">Penyewa:</label>
            <select name="penyewa_id" id="penyewa_id" required>
                <option value="">-- Pilih Penyewa --</option>
                <?php foreach ($daftarPenyewa as $p): ?>
                <option value="<?= (int) $p['id'] ?>"><?= e($p['nama']) ?> (<?= e($p['no_identitas']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="alat_id">Alat (hanya yang stoknya tersedia):</label>
            <select name="alat_id" id="alat_id" required>
                <option value="">-- Pilih Alat --</option>
                <?php foreach ($daftarAlat as $a): ?>
                <option value="<?= (int) $a['id'] ?>"><?= e($a['nama_alat']) ?> - <?= e($a['merk']) ?> (stok: <?= (int) $a['stok'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="jumlah">Jumlah disewa:</label>
            <input type="number" name="jumlah" id="jumlah" value="1" min="1" required>
        </p>
        <p>Tanggal sewa otomatis diisi hari ini.</p>
        <button type="submit">Simpan Transaksi Sewa</button>
    </form>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
