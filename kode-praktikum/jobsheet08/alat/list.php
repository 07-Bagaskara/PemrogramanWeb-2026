<?php
session_start();
$page_title = "Inventaris Alat Kemah";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

// Fitur Pencarian dengan ILIKE (Case-Insensitive di PostgreSQL)
$keyword = $_GET['keyword'] ?? '';
try {
    if (!empty($keyword)) {
        $stmt = $pdo->prepare("SELECT * FROM alat_kemah WHERE nama_alat ILIKE :keyword OR merk ILIKE :keyword ORDER BY id DESC");
        $stmt->execute([':keyword' => "%$keyword%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM alat_kemah ORDER BY id DESC");
    }
    $alat_list = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data: " . $e->getMessage());
}
?>

<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <a href="tambah.php" class="btn">+ Tambah Alat</a>
        
        <form action="" method="GET" class="search-box">
            <input type="text" name="keyword" placeholder="Cari alat / merk..." value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Alat</th>
                    <th>Merk</th>
                    <th>Tahun</th>
                    <th>Kode Barang</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($alat_list)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: #A3AED0;">Belum ada data alat kemah di sistem.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($alat_list as $alat): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td style="font-weight: 700; color: #2B3674;"><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                        <td><?php echo htmlspecialchars($alat['merk']); ?></td>
                        <td><?php echo htmlspecialchars($alat['tahun_beli']); ?></td>
                        <td><span style="background: #F4F7FE; padding: 4px 8px; border-radius: 6px; font-family: monospace;"><?php echo htmlspecialchars($alat['kode_barang'] ?: '-'); ?></span></td>
                        <td><span class="text-orange" style="font-weight: 800;"><?php echo htmlspecialchars($alat['stok']); ?></span></td>
                        <td><?php echo htmlspecialchars($alat['kategori']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>