<?php
// =================================================================
// SEWA/PROSES_TAMBAH.PHP
// Mencatat transaksi sewa DAN mengurangi stok alat dalam SATU transaction:
// kedua langkah berhasil bersama-sama, atau dibatalkan bersama-sama.
// Urutan pengamanan: login -> token CSRF -> validasi -> transaction.
// =================================================================
require __DIR__ . '/../includes/auth_guard.php';
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: tambah.php');
    exit;
}

csrf_verify();

// Semua id dan jumlah harus bilangan bulat positif.
$penyewaId = filter_var($_POST['penyewa_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$alatId    = filter_var($_POST['alat_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
$jumlah    = filter_var($_POST['jumlah'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if ($penyewaId === false || $alatId === false || $jumlah === false) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Penyewa, alat, dan jumlah (angka minimal 1) wajib diisi dengan benar.'];
    header('Location: tambah.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // 1) Pastikan penyewa ada.
    $cekPenyewa = $pdo->prepare("SELECT id FROM penyewa WHERE id = :id");
    $cekPenyewa->execute([':id' => $penyewaId]);
    if (!$cekPenyewa->fetch()) {
        throw new DomainException('Data penyewa tidak ditemukan.');
    }

    // 2) Aturan bisnis (latihan jobsheet): penyewa yang masih membawa alat
    //    lebih dari 14 hari belum boleh menyewa lagi.
    $cekTelat = $pdo->prepare(
        "SELECT COUNT(*) FROM sewa
         WHERE penyewa_id = :id AND status = 'disewa' AND tanggal_sewa < CURRENT_DATE - 14"
    );
    $cekTelat->execute([':id' => $penyewaId]);
    if ($cekTelat->fetchColumn() > 0) {
        throw new DomainException('Penyewa ini masih memiliki sewa yang terlambat lebih dari 14 hari. Selesaikan pengembalian dulu.');
    }

    // 3) Kunci baris alat (FOR UPDATE) supaya stok tidak bisa diubah transaksi lain
    //    selama proses ini berjalan -> mencegah stok minus akibat race condition.
    $cekAlat = $pdo->prepare("SELECT stok FROM alat_kemah WHERE id = :id FOR UPDATE");
    $cekAlat->execute([':id' => $alatId]);
    $alat = $cekAlat->fetch();

    if (!$alat) {
        throw new DomainException('Data alat tidak ditemukan.');
    }
    if ($alat['stok'] < $jumlah) {
        throw new DomainException('Stok tidak mencukupi. Stok tersedia: ' . (int) $alat['stok'] . '.');
    }

    // 4) Catat transaksi sewa (tanggal_sewa otomatis CURRENT_DATE).
    $insert = $pdo->prepare(
        "INSERT INTO sewa (alat_id, penyewa_id, jumlah, tanggal_sewa, status)
         VALUES (:alat_id, :penyewa_id, :jumlah, CURRENT_DATE, 'disewa')"
    );
    $insert->execute([':alat_id' => $alatId, ':penyewa_id' => $penyewaId, ':jumlah' => $jumlah]);

    // 5) Kurangi stok alat.
    $update = $pdo->prepare("UPDATE alat_kemah SET stok = stok - :jumlah WHERE id = :id");
    $update->execute([':jumlah' => $jumlah, ':id' => $alatId]);

    $pdo->commit();   // semua langkah berhasil -> simpan permanen

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Transaksi sewa berhasil dicatat.'];
    header('Location: ../index.php');
    exit;

} catch (DomainException $e) {
    // Penolakan aturan bisnis: pesannya aman dan memang ditujukan untuk pengguna.
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => $e->getMessage()];
    header('Location: tambah.php');
    exit;

} catch (PDOException $e) {
    // Error database: batalkan semua, detail hanya ke log server.
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('sewa/proses_tambah: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Gagal mencatat transaksi sewa. Silakan coba lagi.'];
    header('Location: tambah.php');
    exit;
}
