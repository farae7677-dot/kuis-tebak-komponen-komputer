<?php
session_start();
// Hapus session lama saat pertama kali membuka halaman utama agar game baru mulai bersih
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - Kuis Tebak Komponen Komputer</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-md p-8 rounded-3xl shadow-2xl text-center">
        
        <!-- Badge / Hiasan Atas -->
        <div class="inline-block bg-pink-500/20 text-pink-400 text-xs font-bold px-3 py-1.5 rounded-full border border-pink-500/30 mb-4">
            ✨ RPL Project Game
        </div>

        <!-- Judul Utama -->
        <h1 class="text-2xl font-extrabold text-white mb-2">
            Selamat Datang di <span class="text-pink-400">Kuis Tebak Komponen Komputer</span>! 🖥️
        </h1>
        
        <!-- Deskripsi Singkat -->
        <p class="text-xs text-slate-400 mb-8 leading-relaxed">
            Uji pengetahuanmu seputar hardware dan komponen komputer, taklukkan 30 soal acak, dan raih skor tertinggimu di sini!
        </p>

        <!-- Tombol Mulai Kuis (Warna Pink) -->
        <a href="kuis.php" class="block w-full bg-pink-600 hover:bg-pink-500 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-lg shadow-pink-600/30 flex items-center justify-center space-x-2">
            <span>🚀 Mulai Kuis Sekarang</span>
        </a>

    </div>
</body>
</html>