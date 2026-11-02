<?php
// =================================================================
// SEWA/PROSES_KEMBALI.PHP
// Kebalikan dari proses_tambah.php: menandai sewa selesai DAN menambah
// stok alat kembali, dalam SATU transaction.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kembali.php');
    exit;
}

csrf_verify();

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if ($id === false) {
    header('Location: kembali.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // Kunci baris transaksi supaya tidak bisa "dikembalikan" dua kali secara bersamaan
    // (mis. tombol diklik ganda) -> stok tidak akan bertambah dua kali.
    $stmt = $pdo->prepare("SELECT alat_id, jumlah, status FROM sewa WHERE id = :id FOR UPDATE");
    $stmt->execute([':id' => $id]);
    $trx = $stmt->fetch();

    if (!$trx || $trx['status'] !== 'disewa') {
        throw new DomainException('Transaksi tidak ditemukan atau sudah dikembalikan.');
    }

    $updateSewa = $pdo->prepare(
        "UPDATE sewa SET status = 'dikembalikan', tanggal_kembali = CURRENT_DATE WHERE id = :id"
    );
    $updateSewa->execute([':id' => $id]);

    $updateAlat = $pdo->prepare("UPDATE alat_kemah SET stok = stok + :jumlah WHERE id = :alat_id");
    $updateAlat->execute([':jumlah' => $trx['jumlah'], ':alat_id' => $trx['alat_id']]);

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Alat berhasil dikembalikan dan stok diperbarui.'];

} catch (DomainException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => $e->getMessage()];

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('sewa/proses_kembali: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal memproses pengembalian. Silakan coba lagi.'];
}

header('Location: kembali.php');
exit;
