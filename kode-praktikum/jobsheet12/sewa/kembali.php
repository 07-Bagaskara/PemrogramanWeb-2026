<?php
// =================================================================
// SEWA/KEMBALI.PHP
// Daftar sewa yang masih aktif (status 'disewa'), dengan pencarian.
// Tombol "Kembalikan" mengirim id ke proses_kembali.php.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
$page_title = "Pengembalian Alat";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$keyword = trim($_GET['q'] ?? '');

// JOIN tiga tabel: sewa (transaksi) + alat_kemah (nama alat) + penyewa (nama & no HP).
$sqlDasar = "SELECT s.id, a.nama_alat, pn.nama, pn.no_hp, s.jumlah, s.tanggal_sewa,
                    (CURRENT_DATE - s.tanggal_sewa) AS lama_hari
             FROM sewa s
             JOIN alat_kemah a ON a.id = s.alat_id
             JOIN penyewa pn ON pn.id = s.penyewa_id
             WHERE s.status = 'disewa'";

if ($keyword !== '') {
    $stmt = $pdo->prepare($sqlDasar . " AND (a.nama_alat ILIKE :kw OR pn.nama ILIKE :kw) ORDER BY s.tanggal_sewa");
    $stmt->execute([':kw' => '%' . $keyword . '%']);
} else {
    $stmt = $pdo->query($sqlDasar . " ORDER BY s.tanggal_sewa");
}
$daftarAktif = $stmt->fetchAll();
?>

<section>
    <div style="display: flex; justify-content: flex-end; margin-bottom: 1.5rem;">
        <form action="" method="GET" class="search-box">
            <input type="text" name="q" placeholder="Cari penyewa / alat..." value="<?= e($keyword) ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?= e($_SESSION['flash']['type']) ?>">
            <?= e($_SESSION['flash']['pesan']) ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table style="text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 12px 8px;">PENYEWA</th>
                    <th style="padding: 12px 8px;">NO. HP</th>
                    <th style="padding: 12px 8px;">ALAT</th>
                    <th style="padding: 12px 8px;">JUMLAH</th>
                    <th style="padding: 12px 8px;">TGL SEWA</th>
                    <th style="padding: 12px 8px;">LAMA</th>
                    <th style="padding: 12px 8px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAktif)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 20px; color: #A3AED0;">Tidak ada sewa yang sedang berjalan.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarAktif as $trx): ?>
                    <tr style="border-bottom: 1px solid #EDF2F7;">
                        <td style="padding: 12px 8px; font-weight: 700; color: #2B3674;"><?= e($trx['nama']) ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= e($trx['no_hp']) ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= e($trx['nama_alat']) ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= (int) $trx['jumlah'] ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= e($trx['tanggal_sewa']) ?></td>
                        <td style="padding: 12px 8px; color: <?= $trx['lama_hari'] > 14 ? '#E53E3E' : '#4A5568' ?>; font-weight: <?= $trx['lama_hari'] > 14 ? '800' : '500' ?>;">
                            <?= (int) $trx['lama_hari'] ?> hari<?= $trx['lama_hari'] > 14 ? ' (terlambat)' : '' ?>
                        </td>
                        <td style="padding: 12px 8px;">
                            <form action="proses_kembali.php" method="POST" style="margin: 0; padding: 0; background: transparent; box-shadow: none;" onsubmit="return confirm('Tandai alat ini sudah dikembalikan?');">
                                <?= csrf_field() ?>
                                <input type="hidden" name="id" value="<?= (int) $trx['id'] ?>">
                                <button type="submit" style="background-color: #38A169; color: white; padding: 6px 12px; border-radius: 4px; border: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit;">Kembalikan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
