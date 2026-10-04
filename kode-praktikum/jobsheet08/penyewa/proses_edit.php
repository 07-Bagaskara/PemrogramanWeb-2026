<?php
// =================================================================
// PROSES_EDIT.PHP
// Fungsi: Menerima data dari form edit.php, lalu meng-update
// data penyewa yang sudah ada di database (operasi UPDATE).
// =================================================================

session_start();
require __DIR__ . '/../includes/koneksi.php';

// Pastikan request datang lewat metode POST dan membawa id penyewa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    try {
        // Query UPDATE dengan named placeholder, aman dari SQL Injection.
        // Nama kolom 'nama' disesuaikan dengan struktur tabel penyewa.
        $stmt = $pdo->prepare(
            "UPDATE penyewa 
             SET nama = :nama, 
                 no_identitas = :no_identitas, 
                 no_hp = :no_hp, 
                 alamat = :alamat 
             WHERE id = :id"
        );

        $stmt->execute([
            ':nama'         => $_POST['nama'],
            ':no_identitas' => $_POST['no_identitas'],
            ':no_hp'        => $_POST['no_hp'],
            ':alamat'       => $_POST['alamat'],
            ':id'           => $_POST['id'],
        ]);

        // Simpan pesan sukses ke session untuk ditampilkan di list.php
        $_SESSION['flash'] = [
            'type'  => 'success',
            'pesan' => 'Data penyewa berhasil diperbarui!'
        ];

    } catch (PDOException $e) {
        // Tangkap error kalau update gagal, misalnya duplikasi no_identitas
        $_SESSION['flash'] = [
            'type'  => 'error',
            'pesan' => 'Gagal memperbarui data: ' . $e->getMessage()
        ];
    }
}

// Kembali ke halaman daftar penyewa setelah proses selesai
header("Location: list.php");
exit;