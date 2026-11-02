<?php
// Proteksi CSRF (Cross-Site Request Forgery) berbasis token per-session.
// Membutuhkan session yang sudah dimulai (lihat auth_guard.php / halaman auth).

// Membuat token acak 64 karakter (sekali per session), lalu mengembalikannya.
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// HTML input tersembunyi yang disisipkan di dalam setiap <form method="POST">.
function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

// Dipanggil di awal setiap proses_*.php: menolak request tanpa token valid.
// hash_equals() membandingkan dengan waktu konstan (tahan timing attack).
function csrf_verify()
{
    $token = $_POST['csrf_token'] ?? '';
    if ($token === '' || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(403);
        die('Permintaan ditolak: token CSRF tidak valid atau kedaluwarsa.');
    }
}
