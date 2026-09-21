<?php
session_start();
$page_title = "Tambah Alat Kemah";
include __DIR__ . '/../includes/header.php';
<?php if (isset($_SESSION['flash'])): ?>
    <div style="padding: 15px; margin-bottom: 20px; border-radius: 5px; 
         background-color: <?php echo ($_SESSION['flash']['type'] === 'error') ? '#ffebee' : '#e8f5e9'; ?>; 
         color: <?php echo ($_SESSION['flash']['type'] === 'error') ? '#c62828' : '#2e7d32'; ?>; 
         border: 1px solid <?php echo ($_SESSION['flash']['type'] === 'error') ? '#ef9a9a' : '#a5d6a7'; ?>;">
        <strong><?php echo $_SESSION['flash']['pesan']; ?></strong>
    </div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>

<section>
    <h2>Tambah Alat Kemah Baru</h2>
    
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="flash flash-<?php echo $_SESSION['flash']['type']; ?>">
            <?php echo $_SESSION['flash']['pesan']; ?>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <form action="proses_tambah.php" method="POST">
        <p>
            <label for="nama_alat">Nama Alat:</label>
            <input type="text" name="nama_alat" id="nama_alat" required>
        </p>
        <p>
            <label for="merk">Merk / Brand:</label>
            <input type="text" name="merk" id="merk" required>
        </p>
        <p>
            <label for="tahun_beli">Tahun Beli:</label>
            <input type="number" name="tahun_beli" id="tahun_beli" required>
        </p>
        <p>
            <label for="kode_barang">Kode Barang (Format: Angka & Strip):</label>
            <input type="text" name="kode_barang" id="kode_barang">
        </p>
        <p>
            <label for="stok">Stok (Jumlah):</label>
            <input type="number" name="stok" id="stok" value="0" min="0" required>
        </p>
        <p>
            <label for="kategori">Kategori:</label>
            <select name="kategori" id="kategori">
                <option value="Tenda">Tenda</option>
                <option value="Tas Carrier">Tas Carrier</option>
                <option value="Alat Masak">Alat Masak</option>
                <option value="Penerangan">Penerangan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </p>
        <button type="submit">Simpan Alat</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>