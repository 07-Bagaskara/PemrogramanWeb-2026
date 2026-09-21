<?php
session_start();
$page_title = "Daftar Penyewa";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$stmt = $pdo->query("SELECT * FROM penyewa ORDER BY id DESC");
$penyewa_list = $stmt->fetchAll();
?>

<section>
    <h2>Daftar Penyewa</h2>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div style="margin-bottom: 1rem;">
        <a href="tambah.php"><button style="background-color: #4e8274; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">+ Tambah Penyewa</button></a>
    </div>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>No. Identitas</th>
                    <th>Alamat</th>
                    <th>No. HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($penyewa_list)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem;">Tidak ada data penyewa.</td>
                    </tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($penyewa_list as $p): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($p['nama']); ?></td>
                            <td><?php echo htmlspecialchars($p['no_identitas']); ?></td>
                            <td><?php echo htmlspecialchars($p['alamat']); ?></td>
                            <td><?php echo htmlspecialchars($p['no_hp']); ?></td>
                            <td>
                                <button style="background-color: #f0ad4e; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer;">Edit</button>
                                <button style="background-color: #d9534f; color: white; border: none; padding: 0.3rem 0.6rem; border-radius: 3px; cursor: pointer;">Hapus</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>