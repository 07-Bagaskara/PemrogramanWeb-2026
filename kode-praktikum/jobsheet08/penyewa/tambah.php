<?php
session_start();
$page_title = "Tambah Penyewa";
include __DIR__ . '/../includes/header.php';
?>

<section>
    <h2>Tambah Penyewa Baru</h2>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
        <p>
            <label for="nama">Nama Lengkap:</label>
            <input type="text" name="nama" id="nama" required>
        </p>
        <p>
            <label for="no_identitas">No. Identitas (KTP/SIM):</label>
            <input type="text" name="no_identitas" id="no_identitas" required>
        </p>
        <p>
            <label for="alamat">Alamat Domisili:</label>
            <textarea name="alamat" id="alamat" rows="3" required></textarea>
        </p>
        <p>
            <label for="no_hp">No. HP (Hanya Angka):</label>
            <input type="text" name="no_hp" id="no_hp" required>
        </p>
        <button type="submit">Simpan Data Penyewa</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>