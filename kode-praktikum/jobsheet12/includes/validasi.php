<?php
// Validasi input form Alat Kemah di sisi server.
// Dipakai bersama oleh alat/proses_tambah.php dan alat/proses_edit.php,
// supaya aturan validasinya SAMA di kedua jalur (tambah & edit).
// Mengembalikan array pesan error (kosong = input valid).

const KATEGORI_ALAT = ['Tenda', 'Tas Carrier', 'Alat Masak', 'Penerangan', 'Lainnya'];

function validasi_alat(array $in): array
{
    $errors = [];

    if (trim($in['nama_alat'] ?? '') === '') {
        $errors[] = 'Nama alat wajib diisi.';
    }
    if (trim($in['merk'] ?? '') === '') {
        $errors[] = 'Merk wajib diisi.';
    }

    $tahun = $in['tahun_beli'] ?? '';
    if (!ctype_digit((string) $tahun) || (int) $tahun < 1900 || (int) $tahun > (int) date('Y')) {
        $errors[] = 'Tahun beli harus berupa angka antara 1900 dan ' . date('Y') . '.';
    }

    $stok = $in['stok'] ?? '';
    if (!ctype_digit((string) $stok)) {
        $errors[] = 'Stok harus berupa angka bulat, minimal 0.';
    }

    $kode = trim($in['kode_barang'] ?? '');
    if ($kode !== '' && !preg_match('/^[0-9-]+$/', $kode)) {
        $errors[] = 'Kode Barang hanya boleh angka dan strip.';
    }

    if (!in_array($in['kategori'] ?? '', KATEGORI_ALAT, true)) {
        $errors[] = 'Kategori tidak valid.';
    }

    return $errors;
}
