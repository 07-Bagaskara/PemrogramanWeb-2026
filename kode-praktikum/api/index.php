<?php
// Router untuk jobsheet07 & jobsheet08 di Vercel.
// - File .php dijalankan
// - File statis (css/js/gambar) disajikan apa adanya
// - Folder includes/ dan sql/ tidak bisa diakses langsung dari browser

$root = dirname(__DIR__);
$uri  = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$path = realpath($root . $uri);

// Folder tanpa nama file -> index.php
if ($path && is_dir($path)) {
    $path = realpath($path . '/index.php');
}

// Hanya boleh mengakses jobsheet07 & jobsheet08
$ok = false;
foreach (['jobsheet07', 'jobsheet08'] as $dir) {
    $base = realpath("$root/$dir");
    if ($base && $path && strpos($path, $base . DIRECTORY_SEPARATOR) === 0) {
        $ok = true;
    }
}

// Blokir akses langsung ke folder sensitif
$norm = str_replace('\\', '/', (string) $path);
if ($ok && preg_match('#/(includes|sql)/#', $norm)) {
    $ok = false;
}

if (!$ok || !is_file($path)) {
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

$ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

if ($ext === 'php') {
    // Filesystem Vercel read-only kecuali /tmp
    session_save_path('/tmp');
    chdir(dirname($path));
    require $path;
    exit;
}

$mime = [
    'css' => 'text/css', 'js' => 'application/javascript',
    'png' => 'image/png', 'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg',
    'gif' => 'image/gif', 'svg' => 'image/svg+xml', 'ico' => 'image/x-icon',
    'webp' => 'image/webp', 'woff' => 'font/woff', 'woff2' => 'font/woff2',
];
header('Content-Type: ' . ($mime[$ext] ?? 'application/octet-stream'));
readfile($path);