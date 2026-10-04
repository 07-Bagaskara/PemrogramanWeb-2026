<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM alat_kemah WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $alat = $stmt->fetch();
    
    if (!$alat) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data alat tidak ditemukan.'];
        header("Location: list.php");
        exit;
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$page_title = "Edit Alat Kemah";
include __DIR__ . '/../includes/header.php';
?>

<section class="content-area">
    <div style="margin-bottom: 20px;">
        <a href="list.php" style="background-color: #718096; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">&larr; Kembali ke Inventaris</a>
    </div>

    <form action="aksi_alat.php" method="POST" style="max-width: 600px;">
        <!-- Input rahasia untuk Vercel Controller -->
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($alat['id']); ?>">
        
        <h3 style="color: #2B3674; margin-bottom: 1.5rem;">Edit Data: <?php echo htmlspecialchars($alat['nama_alat']); ?></h3>

        <label for="nama_alat">Nama Alat:</label>
        <input type="text" name="nama_alat" id="nama_alat" value="<?php echo htmlspecialchars($alat['nama_alat']); ?>" required>

        <label for="merk">Merk / Brand:</label>
        <input type="text" name="merk" id="merk" value="<?php echo htmlspecialchars($alat['merk']); ?>" required>

        <label for="tahun_beli">Tahun Beli:</label>
        <input type="number" name="tahun_beli" id="tahun_beli" value="<?php echo htmlspecialchars($alat['tahun_beli']); ?>" required>

        <label for="kode_barang">Kode Barang:</label>
        <input type="text" name="kode_barang" id="kode_barang" value="<?php echo htmlspecialchars($alat['kode_barang']); ?>">

        <label for="stok">Stok (Jumlah):</label>
        <input type="number" name="stok" id="stok" value="<?php echo htmlspecialchars($alat['stok']); ?>" min="0" required>

        <label for="kategori">Kategori:</label>
        <select name="kategori" id="kategori" required>
            <option value="Tenda" <?php echo ($alat['kategori'] == 'Tenda') ? 'selected' : ''; ?>>Tenda</option>
            <option value="Tas Carrier" <?php echo ($alat['kategori'] == 'Tas Carrier') ? 'selected' : ''; ?>>Tas Carrier</option>
            <option value="Alat Masak" <?php echo ($alat['kategori'] == 'Alat Masak') ? 'selected' : ''; ?>>Alat Masak</option>
            <option value="Penerangan" <?php echo ($alat['kategori'] == 'Penerangan') ? 'selected' : ''; ?>>Penerangan</option>
            <option value="Lainnya" <?php echo ($alat['kategori'] == 'Lainnya') ? 'selected' : ''; ?>>Lainnya</option>
        </select>

        <button type="submit" style="background-color: #ED8936; width: 100%; margin-top: 10px;">Update Alat</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>