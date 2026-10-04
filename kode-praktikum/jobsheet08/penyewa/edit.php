<?php
session_start();
require __DIR__ . '/../includes/koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT * FROM penyewa WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $member = $stmt->fetch();
    
    if (!$member) {
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data penyewa tidak ditemukan.'];
        header("Location: list.php");
        exit;
    }
    
    // Fallback jika nama kolom di DB adalah 'nama' atau 'nama_penyewa'
    $nama_member = $member['nama_lengkap'] ?? $member['nama'] ?? $member['nama_penyewa'] ?? '';
    
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$page_title = "Edit Data Penyewa";
include __DIR__ . '/../includes/header.php';
?>

<section class="content-area">
    <div style="margin-bottom: 20px;">
        <a href="list.php" style="background-color: #718096; color: white; padding: 8px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 0.9rem;">&larr; Kembali ke Daftar Penyewa</a>
    </div>

    <form action="aksi_penyewa.php" method="POST" style="max-width: 600px;">
        <!-- Input rahasia untuk Vercel Controller -->
        <input type="hidden" name="aksi" value="edit">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($member['id']); ?>">
        
        <h3 style="color: #2B3674; margin-bottom: 1.5rem;">Edit Data: <?php echo htmlspecialchars($nama_member); ?></h3>

        <label for="nama">Nama Lengkap:</label>
        <!-- name diset ke 'nama' sesuai error kita sebelumnya, sesuaikan jika DB Anda beda -->
        <input type="text" name="nama" id="nama" value="<?php echo htmlspecialchars($nama_member); ?>" required>

        <label for="no_identitas">No. Identitas (KTP/SIM):</label>
        <input type="text" name="no_identitas" id="no_identitas" value="<?php echo htmlspecialchars($member['no_identitas'] ?? ''); ?>" required>

        <label for="no_hp">No. Handphone:</label>
        <input type="text" name="no_hp" id="no_hp" value="<?php echo htmlspecialchars($member['no_hp'] ?? ''); ?>" required>

        <label for="alamat">Alamat Lengkap:</label>
        <textarea name="alamat" id="alamat" rows="3" required style="width: 100%; padding: 1rem; border: 1px solid #E2E8F0; border-radius: 12px; background: #F4F7FE; font-family: inherit; margin-bottom: 1.5rem; outline: none;"><?php echo htmlspecialchars($member['alamat'] ?? ''); ?></textarea>

        <button type="submit" style="background-color: #ED8936; width: 100%;">Update Data Penyewa</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>