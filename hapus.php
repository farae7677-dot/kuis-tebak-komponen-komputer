<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM komputer WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: index.php");
exit;
?>