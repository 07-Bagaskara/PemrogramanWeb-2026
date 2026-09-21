<?php
// Host IPv4 Pooler khusus untuk region Singapore
$host = 'aws-0-ap-southeast-1.pooler.supabase.com';
$port = '6543'; 
$db   = 'postgres';

// Username pooler = postgres.[ID Project Anda yang baru]
$user = 'postgres.fffavqcdyrvkkffgwnfe'; 

// Password asli Anda
$pass = 'Bagasgemuk12'; 

$dsn = "pgsql:host=$host;port=$port;dbname=$db";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi Supabase gagal: " . $e->getMessage());
}
?>