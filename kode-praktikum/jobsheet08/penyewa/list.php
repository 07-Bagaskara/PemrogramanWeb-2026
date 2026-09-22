<?php
session_start();
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$keyword = $_GET['keyword'] ?? '';
try {
    if (!empty($keyword)) {
        $stmt = $pdo->prepare("SELECT * FROM penyewa WHERE nama ILIKE :keyword OR no_identitas ILIKE :keyword ORDER BY id DESC");
        $stmt->execute([':keyword' => "%$keyword%"]);
    } else {
        $stmt = $pdo->query("SELECT * FROM penyewa ORDER BY id DESC");
    }
    $penyewa_list = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error mengambil data: " . $e->getMessage());
}
?>

<section>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <a href="tambah.php" class="btn" style="background-color: #4C51BF; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold;">+ Tambah Penyewa</a>
        
        <form action="" method="GET" class="search-box">
            <input type="text" name="keyword" placeholder="Cari nama / identitas..." value="<?php echo htmlspecialchars($keyword); ?>" style="padding: 8px; border-radius: 8px; border: 1px solid #ccc;">
            <button type="submit" style="background-color: #4C51BF; color: white; padding: 8px 16px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer;">Cari</button>
        </form>
    </div>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>" style="padding: 12px; margin-bottom: 15px; border-radius: 6px; background-color: <?php echo ($_SESSION['flash']['type'] === 'error') ? '#ffebee' : '#e8f5e9'; ?>; color: <?php echo ($_SESSION['flash']['type'] === 'error') ? '#c62828' : '#2e7d32'; ?>; border: 1px solid <?php echo ($_SESSION['flash']['type'] === 'error') ? '#ef9a9a' : '#a5d6a7'; ?>;">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="table-responsive" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 2px solid #E2E8F0; color: #A0AEC0; font-size: 0.85rem; letter-spacing: 1px;">
                    <th style="padding: 12px 8px;">NO</th>
                    <th style="padding: 12px 8px;">NAMA LENGKAP</th>
                    <th style="padding: 12px 8px;">NO. IDENTITAS</th>
                    <th style="padding: 12px 8px;">ALAMAT</th>
                    <th style="padding: 12px 8px;">NO. HP</th>
                    <th style="padding: 12px 8px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($penyewa_list)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px; color: #A3AED0;">Belum ada data penyewa terdaftar.</td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach ($penyewa_list as $member): ?>
                    <tr style="border-bottom: 1px solid #EDF2F7;">
                        <td style="padding: 12px 8px; color: #4A5568;"><?php echo $no++; ?></td>
                        
                        <td style="padding: 12px 8px; font-weight: 700; color: #2B3674;"><?php echo htmlspecialchars($member['nama'] ?? $member['nama_penyewa'] ?? '-'); ?></td>
                        
                        <td style="padding: 12px 8px; color: #4A5568; font-family: monospace;"><?php echo htmlspecialchars($member['no_identitas']); ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?php echo htmlspecialchars($member['alamat']); ?></td>
                        <td style="padding: 12px 8px; color: #4A5568;"><?php echo htmlspecialchars($member['no_hp']); ?></td>
                        
                        <!-- Kolom Aksi dengan Form Hapus Anti-Blokir -->
                        <td style="padding: 12px 8px; display: flex; gap: 6px; align-items: center;">
                            <a href="edit.php?id=<?php echo $member['id']; ?>" style="display: inline-block; background-color: #ED8936; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.85rem; font-weight: 600;">Edit</a>
                            
                            <form action="aksi_penyewa.php" method="POST" style="margin: 0;" onsubmit="return confirm('Yakin ingin menghapus data member ini?');">
                                <input type="hidden" name="aksi" value="hapus"> 
                                <input type="hidden" name="id" value="<?php echo $member['id']; ?>">
                                <button type="submit" style="background-color: #E53E3E; color: white; padding: 6px 12px; border-radius: 4px; border: none; font-size: 0.85rem; font-weight: 600; cursor: pointer; font-family: inherit;">Hapus</button>
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