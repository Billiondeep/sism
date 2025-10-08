<?php
// FILE: form_surat.php

// Langkah 1: Jalankan semua logika PHP terlebih dahulu
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('warga');

// --- SEMUA LOGIKA DILAKUKAN SEBELUM HTML DICETAK ---
$type = $_GET['type'] ?? 'pengantar';
$form_map = [
    'pengantar' => ['title' => 'Surat Pengantar RT/RW', 'file' => 'pengantar_form.php', 'emoji' => '📄'],
    'sktm' => ['title' => 'Surat Keterangan Tidak Mampu', 'file' => 'sktm_form.php', 'emoji' => '🔖'],
    'domisili' => ['title' => 'Surat Keterangan Domisili', 'file' => 'domisili_form.php', 'emoji' => '🏠'],
    'usaha' => ['title' => 'Surat Keterangan Usaha', 'file' => 'usaha_form.php', 'emoji' => '🏪'],
    'penghasilan' => ['title' => 'Surat Keterangan Penghasilan', 'file' => 'penghasilan_form.php', 'emoji' => '💰'],
    'kelahiran_kematian' => ['title' => 'Surat Keterangan Kelahiran / Kematian', 'file' => 'kelahiran_kematian_form.php', 'emoji' => '👶⚱️'],
];

// Validasi tipe, jika tidak valid, redirect SEKARANG
if (!array_key_exists($type, $form_map)) {
    header('Location: dashboard.php?error=invalid_type');
    exit();
}

$form_info = $form_map[$type];
$form_file = __DIR__ . "/views/forms/{$form_info['file']}";

// --- SETELAH SEMUA LOGIKA SELESAI, BARU MULAI CETAK HTML ---
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
?>

<!-- Konten Utama -->
<div class="max-w-3xl mx-auto">
    <div class="text-center mb-8">
        <span class="text-6xl"><?php echo $form_info['emoji']; ?></span>
        <h1 class="text-3xl font-bold leading-tight text-gray-900 font-poppins mt-4">
            <?php echo htmlspecialchars($form_info['title']); ?>
        </h1>
        <p class="mt-2 text-md text-gray-600">Isi semua data yang diperlukan dengan benar.</p>
    </div>
    <div class="bg-white p-8 shadow-xl rounded-lg">
        <?php
        if (file_exists($form_file)) {
            include_once $form_file;
        } else {
            echo "<div class='bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md' role='alert'>";
            echo "<h3 class='font-bold'>Error Kritis</h3>";
            echo "<p>File form '<code>" . htmlspecialchars($form_info['file']) . "</code>' tidak dapat ditemukan.</p>";
            echo "<p class='mt-2 text-sm'>Pastikan struktur folder Anda sudah benar: <code>/views/forms/" . htmlspecialchars($form_info['file']) . "</code></p>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php
include_once __DIR__ . '/includes/footer.php';
?>