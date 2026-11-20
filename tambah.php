<?php
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_komponen'];
    $kategori = $_POST['kategori'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($nama) && !empty($kategori) && !empty($deskripsi)) {
        $stmt = $pdo->prepare("INSERT INTO komputer (nama_komponen, kategori, deskripsi) VALUES (?, ?, ?)");
        $stmt->execute([$nama, $kategori, $deskripsi]);
        header("Location: index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-md p-6 rounded-3xl shadow-2xl">
        <h1 class="text-xl font-bold text-indigo-400 mb-4">➕ Tambah Soal Kuis</h1>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-xs text-slate-400 mb-1">Nama Komponen (Jawaban)</label>
                <input type="text" name="nama_komponen" required placeholder="Cth: Processor Intel Core i5" class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-indigo-400">
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Kategori</label>
                <input type="text" name="kategori" required placeholder="Cth: Processing Unit" class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-indigo-400">
            </div>
            <div>
                <label class="block text-xs text-slate-400 mb-1">Deskripsi / Ciri-Ciri Soal</label>
                <textarea name="deskripsi" required rows="3" placeholder="Cth: Dikenal sebagai otak utama komputer..." class="w-full bg-slate-900 border border-slate-700 px-3 py-2 rounded-xl text-sm focus:outline-none focus:border-indigo-400"></textarea>
            </div>
            <div class="flex gap-2 pt-2">
                <button type="submit" name="tambah" class="w-full bg-indigo-600 hover:bg-indigo-500 py-2.5 rounded-xl text-sm font-semibold transition">Simpan Soal</button>
                <a href="index.php" class="w-full text-center bg-slate-700 hover:bg-slate-600 py-2.5 rounded-xl text-sm font-semibold transition">Menu Utama</a>
            </div>
        </form>
    </div>
</body>
</html>