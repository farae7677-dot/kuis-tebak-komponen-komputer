<?php
include 'koneksi.php';
session_start();

// Inisialisasi game jika baru mulai
if (!isset($_SESSION['nomor_soal'])) {
    $_SESSION['nomor_soal'] = 1;
    $_SESSION['skor'] = 0;
    $_SESSION['soal_terjawab'] = [];
    $_SESSION['sudah_jawab'] = false;
    $_SESSION['pesan_feedback'] = "";
}

$total_maksimal_soal = 30;

// Jika sudah mencapai lebih dari 30 soal, langsung lempar ke hasil.php
if ($_SESSION['nomor_soal'] > $total_maksimal_soal) {
    header("Location: hasil.php");
    exit;
}

$sudah_jawab_sesi = $_SESSION['sudah_jawab'] ?? false;

// 1. Cek saat pemain mengklik pilihan jawaban
if (isset($_POST['jawab']) && !$sudah_jawab_sesi) {
    $jawaban_user = trim($_POST['jawab']);
    $jawaban_benar = trim($_SESSION['jawaban_benar'] ?? '');
    
    $_SESSION['sudah_jawab'] = true;

    // Membandingkan jawaban (aman dari beda huruf besar/kecil atau spasi)
    if (strcasecmp($jawaban_user, $jawaban_benar) == 0) {
        $_SESSION['pesan_feedback'] = "<div class='bg-emerald-500/20 text-emerald-400 p-4 rounded-xl text-center text-sm font-bold mb-4'>🎉 Benar! Jawaban kamu tepat sekali!</div>";
        $_SESSION['skor'] += 1; // <-- INI YANG MENAMBAH SKOR KAMU
    } else {
        $_SESSION['pesan_feedback'] = "<div class='bg-red-500/20 text-red-400 p-4 rounded-xl text-center text-sm font-bold mb-4'>❌ Kurang tepat!</div>";
    }
}

// 2. Cek saat pemain mengklik tombol "Lanjut"
if (isset($_POST['lanjut'])) {
    $_SESSION['nomor_soal'] += 1;
    $_SESSION['sudah_jawab'] = false;
    $_SESSION['pesan_feedback'] = ""; 
    unset($_SESSION['current_soal']); 
    
    header("Location: kuis.php");
    exit;
}

$sudah_jawab_sesi = $_SESSION['sudah_jawab'] ?? false;

// Ambil soal baru dari database
if (!isset($_SESSION['current_soal']) || !$sudah_jawab_sesi) {
    $ids_terjawab = !empty($_SESSION['soal_terjawab']) ? implode(',', array_map('intval', $_SESSION['soal_terjawab'])) : '0';
    
    if (!$sudah_jawab_sesi) {
        $stmt = $pdo->query("SELECT * FROM komputer WHERE id NOT IN ($ids_terjawab) ORDER BY RAND() LIMIT 1");
        $soal = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$soal) {
            $_SESSION['soal_terjawab'] = [];
            $stmt = $pdo->query("SELECT * FROM komputer ORDER BY RAND() LIMIT 1");
            $soal = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        $_SESSION['current_soal'] = $soal;
        $_SESSION['soal_terjawab'][] = $soal['id'];
        $_SESSION['jawaban_benar'] = $soal['nama_komponen'];

        // Acak pilihan ganda
        $stmt_opsi = $pdo->prepare("SELECT DISTINCT nama_komponen FROM komputer WHERE nama_komponen != ? ORDER BY RAND() LIMIT 3");
        $stmt_opsi->execute([$soal['nama_komponen']]);
        $pilihan_lain = $stmt_opsi->fetchAll(PDO::FETCH_COLUMN);

        $pilihan_ganda = array_merge([$soal['nama_komponen']], $pilihan_lain);
        shuffle($pilihan_ganda);
        $_SESSION['pilihan_ganda'] = $pilihan_ganda;
    }
}

$soal = $_SESSION['current_soal'] ?? null;
$pilihan_ganda = $_SESSION['pilihan_ganda'] ?? [];
$status_jawaban = $_SESSION['pesan_feedback'] ?? "";
$sudah_jawab = $_SESSION['sudah_jawab'] ?? false;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuis Tebak Komponen (Soal <?= $_SESSION['nomor_soal']; ?>/<?= $total_maksimal_soal; ?>)</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-slate-800 border border-slate-700 w-full max-w-lg p-6 rounded-3xl shadow-2xl">
        
        <!-- Header Info -->
        <div class="flex justify-between items-center mb-4">
            <span class="text-xs font-bold bg-indigo-600/20 text-indigo-400 px-3 py-1.5 rounded-xl border border-indigo-500/30">
                Soal <?= $_SESSION['nomor_soal']; ?> / <?= $total_maksimal_soal; ?>
            </span>
            <span class="text-xs font-bold bg-emerald-600/20 text-emerald-400 px-3 py-1.5 rounded-xl border border-emerald-500/30">
                Skor: <?= $_SESSION['skor']; ?>
            </span>
            <a href="reset.php" onclick="return confirm('Ulangi permainan dari awal?')" class="text-xs bg-slate-700 hover:bg-slate-600 px-3 py-1.5 rounded-xl transition">🔄 Reset</a>
        </div>

        <!-- Status Feedback -->
        <?= $status_jawaban; ?>

        <?php if ($soal): ?>
            <?php if (!$sudah_jawab): ?>
                <!-- Kotak Soal -->
                <div class="bg-slate-900 border border-slate-700 p-6 rounded-2xl text-center mb-6">
                    <p class="text-xs text-slate-400 uppercase tracking-wider mb-2">Kategori: <span class="text-indigo-300 font-semibold"><?= htmlspecialchars($soal['kategori']); ?></span></p>
                    <h2 class="text-sm font-medium text-slate-300 mb-2">Ciri-ciri / Deskripsi:</h2>
                    <p class="text-base font-bold text-amber-300 bg-slate-800 p-3 rounded-xl border border-slate-700">"<?= htmlspecialchars($soal['deskripsi']); ?>"</p>
                </div>

                <!-- Pilihan Ganda -->
                <form method="POST" class="space-y-3">
                    <?php foreach ($pilihan_ganda as $opsi): ?>
                        <button type="submit" name="jawab" value="<?= htmlspecialchars($opsi); ?>" class="w-full text-left bg-slate-900 hover:bg-indigo-600/30 border border-slate-700 hover:border-indigo-500 p-3 rounded-xl text-sm font-medium transition flex items-center justify-between">
                            <span><?= htmlspecialchars($opsi); ?></span>
                            <span class="text-xs text-slate-500">Pilih ➡</span>
                        </button>
                    <?php endforeach; ?>
                </form>
            
            <?php else: ?>
                <!-- Tombol Lanjut (Soal di atas otomatis hilang) -->
                <form method="POST">
                    <button type="submit" name="lanjut" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3.5 rounded-xl text-sm transition shadow-lg shadow-indigo-600/30 flex items-center justify-center space-x-2">
                        <span>Lanjut ke Soal Berikutnya</span>
                        <span>➡</span>
                    </button>
                </form>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</body>
</html>