<?php
// =================================================================
// PROSES_EDIT.PHP
// Fungsi: Menerima data dari form edit.php, lalu meng-update
// data alat kemah yang sudah ada di database (operasi UPDATE).
// =================================================================
session_start();
require __DIR__ . '/../includes/koneksi.php';

// Pastikan request datang lewat metode POST dan membawa id alat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    try {
        // Siapkan query UPDATE dengan named placeholder (:nama_alat, dst) agar aman dari SQL Injection
        $stmt = $pdo->prepare(
            "UPDATE alat_kemah 
             SET nama_alat = :nama_alat, 
                 merk = :merk, 
                 tahun_beli = :tahun_beli, 
                 kode_barang = :kode_barang, 
                 stok = :stok, 
                 kategori = :kategori 
             WHERE id = :id"
        );

        // Jalankan query dengan data dari form, lalu kirim ke database
        $stmt->execute([
            ':nama_alat'   => $_POST['nama_alat'],
            ':merk'        => $_POST['merk'],
            ':tahun_beli'  => $_POST['tahun_beli'],
            ':kode_barang' => $_POST['kode_barang'],
            ':stok'        => $_POST['stok'],
            ':kategori'    => $_POST['kategori'],
            ':id'          => $_POST['id'],
        ]);

        // Simpan pesan sukses ke session, untuk ditampilkan di list.php
        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Data alat kemah berhasil diperbarui!'
        ];

    } catch (PDOException $e) {
        // Kalau query gagal (misal tipe data salah), tangkap errornya dan simpan pesan error ke session
        $_SESSION['flash'] = [
            'type'  => 'error',
            'pesan' => 'Gagal memperbarui alat: ' . $e->getMessage()
        ];
    }
}

// Setelah proses selesai (berhasil atau gagal), kembali ke halaman list
header("Location: list.php");
exit;