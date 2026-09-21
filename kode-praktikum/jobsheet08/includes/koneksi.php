<?php
$host = '127.0.0.1';
$port = '5432';
$db   = 'simpus_mini';
$user = 'postgres';

//password dibiarkan kosong karena aku memakai 'trust', di pg_hba.conf
$pass = ''; 

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode ke exception agar lebih mudah melacak error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set default fetch mode ke array asosiatif
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
?>