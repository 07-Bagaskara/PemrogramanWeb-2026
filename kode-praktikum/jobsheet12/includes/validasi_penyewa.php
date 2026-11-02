<?php
// Validasi input form Penyewa di sisi server.
// Dipakai bersama oleh penyewa/proses_tambah.php dan penyewa/proses_edit.php.
function validasi_penyewa(array $in): array
{
    $errors = [];

    if (trim($in['nama'] ?? '') === '') {
        $errors[] = 'Nama wajib diisi.';
    }
    if (trim($in['no_identitas'] ?? '') === '') {
        $errors[] = 'No. Identitas wajib diisi.';
    }
    // Validasi regex dari Jobsheet 7
    $hp = trim($in['no_hp'] ?? '');
    if ($hp !== '' && !preg_match('/^[0-9]+$/', $hp)) {
        $errors[] = 'No. HP hanya boleh berisi angka.';
    }

    return $errors;
}
