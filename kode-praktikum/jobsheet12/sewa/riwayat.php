<?php
// =================================================================
// SEWA/RIWAYAT.PHP
// Riwayat sewa per penyewa: JOIN tabel sewa dengan alat_kemah.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
$page_title = "Riwayat Sewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$penyewaId = filter_var($_GET['penyewa_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$daftarPenyewa = $pdo->query("SELECT id, nama FROM penyewa ORDER BY nama")->fetchAll();

$riwayat = [];
$penyewaTerpilih = null;

if ($penyewaId !== false && $penyewaId !== null) {
    $stmtP = $pdo->prepare("SELECT id, nama, no_identitas FROM penyewa WHERE id = :id");
    $stmtP->execute([':id' => $penyewaId]);
    $penyewaTerpilih = $stmtP->fetch();

    if ($penyewaTerpilih) {
        $stmt = $pdo->prepare(
            "SELECT a.nama_alat, a.merk, s.jumlah, s.tanggal_sewa, s.tanggal_kembali, s.status
             FROM sewa s
             JOIN alat_kemah a ON a.id = s.alat_id
             WHERE s.penyewa_id = :id
             ORDER BY s.tanggal_sewa DESC, s.id DESC"
        );
        $stmt->execute([':id' => $penyewaId]);
        $riwayat = $stmt->fetchAll();
    }
}
?>

<section>
    <form action="" method="GET">
        <p>
            <label for="penyewa_id">Pilih Penyewa:</label>
            <select name="penyewa_id" id="penyewa_id">
                <option value="">-- Pilih Penyewa --</option>
                <?php foreach ($daftarPenyewa as $p): ?>
                <option value="<?= (int) $p['id'] ?>" <?= (string) $penyewaId === (string) $p['id'] ? 'selected' : '' ?>><?= e($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <button type="submit">Tampilkan</button>
    </form>

    <?php if ($penyewaTerpilih): ?>
    <h3 style="color: #2B3674; margin-top: 2rem;">Riwayat sewa &mdash; <?= e($penyewaTerpilih['nama']) ?></h3>
    <div class="table-responsive">
        <table style="text-align: left;">
            <thead>
                <tr>
                    <th style="padding: 12px 8px;">ALAT</th>
                    <th style="padding: 12px 8px;">JUMLAH</th>
                    <th style="padding: 12px 8px;">SEWA</th>
                    <th style="padding: 12px 8px;">KEMBALI</th>
                    <th style="padding: 12px 8px;">STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($riwayat)): ?>
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #A3AED0;">Belum ada riwayat sewa.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <tr style="border-bottom: 1px solid #EDF2F7;">
                        <td style="padding: 12px 8px; font-weight: 700; color: #2B3674;"><?= e($r['nama_alat']) ?> <span style="color:#A3AED0; font-weight:500;">(<?= e($r['merk']) ?>)</span></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= (int) $r['jumlah'] ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= e($r['tanggal_sewa']) ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?= e($r['tanggal_kembali'] ?? '-') ?></td>
                        <td style="padding: 12px 8px; font-weight: 700; color: <?= $r['status'] === 'disewa' ? '#DD6B20' : '#2F855A' ?>;">
                            <?= $r['status'] === 'disewa' ? 'Sedang disewa' : 'Selesai' ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
