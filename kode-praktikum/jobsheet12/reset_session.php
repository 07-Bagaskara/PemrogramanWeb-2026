<?php
session_start();
session_destroy(); // Menghapus seluruh data sementara di memori server
header("Location: index.php");
exit;
?>