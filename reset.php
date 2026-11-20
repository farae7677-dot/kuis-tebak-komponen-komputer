<?php
session_start();

// Hapus semua session permainan
session_unset();
session_destroy();

// Arahkan kembali ke halaman utama (index.php)
header("Location: index.php");
exit;
?>