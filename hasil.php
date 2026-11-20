<?php
session_start();

// Ambil skor benar dari session dengan aman
$skor_benar = $_SESSION['skor'] ?? 0;
$total_soal = 30;

// Otomatis menghitung jawaban salah dari total soal dikurangi skor benar
$jawaban_salah = $total_soal - $skor_benar;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Kuis Komponen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-lg p-6 rounded-3xl shadow-2xl text-center">
        
        <h1 class="text-xl font-bold mb-2">🎉 Permainan Selesai!</h1>
        <p class="text-xs text-slate-400 mb-6">Berikut adalah rekap nilai kamu dari <?= $total_soal; ?> soal kuis:</p>

        <!-- Kotak Skor Akhir (Menampilkan nilai asli misal 14) -->
        <div class="bg-slate-900 border border-slate-700 p-6 rounded-2xl mb-6">
            <p class="text-xs uppercase tracking-wider text-slate-400 mb-2">SKOR AKHIR KAMU</p>
            <h2 class="text-6xl font-extrabold text-indigo-400 mb-2"><?= $skor_benar; ?></h2>
            <p class="text-xs text-amber-300 font-medium">
                <?php if ($skor_benar >= 15): ?>
                    🌟 Luar Biasa! Pertahankan Prestasi Kamu!
                <?php else: ?>
                    ⚠️ Perlu Belajar Lagi! Semangat Coba Lagi Ya!
                <?php endif; ?>
            </p>
        </div>

        <!-- Statistik Benar & Salah yang Otomatis Sinkron -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-xl">
                <p class="text-xs text-emerald-400 font-semibold mb-1">Jawaban Benar</p>
                <p class="text-2xl font-bold text-emerald-400"><?= $skor_benar; ?></p>
            </div>
            <div class="bg-red-500/10 border border-red-500/20 p-4 rounded-xl">
                <p class="text-xs text-red-400 font-semibold mb-1">Jawaban Salah</p>
                <!-- Menampilkan sisa jawaban salah secara otomatis -->
                <p class="text-2xl font-bold text-red-400"><?= $jawaban_salah; ?></p>
            </div>
        </div>

        <!-- Tombol Main Lagi (Mengarahkan ke reset.php) -->
        <a href="reset.php" class="block w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-lg shadow-indigo-600/30">
            🎮 Main Lagi Dari Awal
        </a>

    </div>
</body>
</html>