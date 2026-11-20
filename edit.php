<?php
include 'koneksi.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM komputer WHERE id = :id");
$stmt->execute(['id' => $id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $nama = $_POST['nama_komponen'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    $sql = "UPDATE komputer SET nama_komponen = :nama, kategori = :kategori, stok = :stok WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['nama' => $nama, 'kategori' => $kategori, 'stok' => $stok, 'id' => $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Komponen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-md p-6 rounded-3xl shadow-2xl">
        <h1 class="text-xl font-bold text-amber-400 mb-4">✏️ Edit Komponen</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Nama Komponen</label>
                <input type="text" name="nama_komponen" value="<?= htmlspecialchars($data['nama_komponen']); ?>" required class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Kategori</label>
                <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" required class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Jumlah Stok</label>
                <input type="number" name="stok" value="<?= $data['stok']; ?>" required class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" name="update" class="w-full bg-amber-600 hover:bg-amber-500 py-2.5 rounded-xl text-sm font-semibold transition">Perbarui</button>
                <a href="index.php" class="w-full text-center bg-slate-700 hover:bg-slate-600 py-2.5 rounded-xl text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>