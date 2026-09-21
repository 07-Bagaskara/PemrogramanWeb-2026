<?php
session_start();
$page_title = "Daftar Alat Kemah";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

// Menangani pencarian Server-Side (Ide Latihan 3)
$keyword = trim($_GET['q'] ?? '');

if ($keyword !== '') {
    // Gunakan ILIKE untuk pencarian teks yang mengabaikan huruf besar/kecil (Case-Insensitive)
    $stmt = $pdo->prepare("SELECT * FROM alat_kemah WHERE nama_alat ILIKE :keyword OR merk ILIKE :keyword ORDER BY id DESC");
    // Tambahkan % di depan dan belakang agar mencari kata di tengah kalimat
    $stmt->execute(['keyword' => "%$keyword%"]);
    $alat_list = $stmt->fetchAll();
} else {
    // Jika tidak ada pencarian, tampilkan semua data
    $stmt = $pdo->query("SELECT * FROM alat_kemah ORDER BY id DESC");
    $alat_list = $stmt->fetchAll();
}
?>

<section>
    <h2>Daftar Alat Kemah</h2>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div style="margin-bottom: 1rem; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="tambah.php"><button style="background-color: #4e8274; color: white; padding: 0.5rem 1rem; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">+ Tambah Alat</button></a>
        
        <!-- Form Pencarian Server-Side -->
        <form action="" method="GET" class="search-box" style="display: flex; gap: 0.5rem;">
            <input type="text" name="q" placeholder="Cari nama alat / merk..." value="<?php echo htmlspecialchars($keyword); ?>" style="padding: 0.4rem; border: 1px solid #ccc; border-radius: 4px;">
            <button type="submit" style="background-color: #55677a; color: white; padding: 0.4rem 1rem; border: none; border-radius: 4px; cursor: pointer;">Cari</button>
        </form>
    </div>

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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($alat_list)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem;">Tidak ada data alat kemah.</td>
                    </tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($alat_list as $alat): ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($alat['nama_alat']); ?></td>
                            <td><?php echo htmlspecialchars($alat['merk']); ?></td>
                            <td><?php echo $alat['tahun_beli']; ?></td>
                            <td><?php echo htmlspecialchars($alat['kode_barang']); ?></td>
                            <td><?php echo $alat['stok']; ?></td>
                            <td><?php echo htmlspecialchars($alat['kategori']); ?></td>
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