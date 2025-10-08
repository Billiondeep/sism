<?php
// FILE: verify.php
include_once __DIR__ . '/config/database.php';
$token = $_GET['token'] ?? '';
$surat_data = null;
$jenis_surat = '';

if (!empty($token)) {
    $db = getDbConnection();
    $token = pg_escape_string($db, $token);

    // Daftar semua tabel surat untuk dicari
    $tables = [
        'surat_pengantar' => 'Surat Pengantar',
        'surat_sktm' => 'SKTM',
        'surat_domisili' => 'Surat Domisili',
        'surat_usaha' => 'Surat Usaha',
        'surat_penghasilan' => 'Surat Penghasilan',
        'surat_kelahiran_kematian' => 'Ket. Kelahiran/Kematian'
    ];

    foreach ($tables as $table_name => $surat_title) {
        // Kolom nama bisa berbeda, jadi kita gunakan alias
        $nama_col = ($table_name == 'surat_kelahiran_kematian') ? 'nama_lengkap' : 'nama';
        
        $query = "SELECT id, '{$surat_title}' as jenis, {$nama_col} as nama_pemohon, status, created_at FROM \"{$table_name}\" WHERE verification_token = '$token'";
        $result = pg_query($db, $query);
        
        if ($result && pg_num_rows($result) > 0) {
            $surat_data = pg_fetch_assoc($result);
            break; // Hentikan pencarian jika sudah ketemu
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Dokumen SISM</title>
    <link href="/sism-rt-rw/assets/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-lg mx-auto p-4">
        <div class="text-center mb-6">
            <img src="/sism-rt-rw/assets/images/logo-sism.png" alt="Logo SISM" class="h-20 w-auto mx-auto">
            <h1 class="text-2xl font-bold text-gray-800 font-poppins mt-4">Verifikasi Keaslian Dokumen</h1>
        </div>

        <?php if ($surat_data): ?>
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg border-t-8 border-green-500">
                <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h2 class="text-2xl font-bold text-green-600 mt-4">Dokumen Terverifikasi</h2>
                    <p class="text-gray-600 mt-1">Dokumen ini adalah asli dan dikeluarkan secara sah oleh sistem SISM RT.06/RW.03.</p>
                </div>
                <div class="mt-6 border-t pt-4">
                    <dl>
                        <div class="py-2 flex justify-between"><dt class="text-gray-500">Jenis Surat</dt><dd class="font-semibold text-gray-900 text-right"><?php echo htmlspecialchars($surat_data['jenis']); ?></dd></div>
                        <div class="py-2 flex justify-between"><dt class="text-gray-500">Nama Pemohon</dt><dd class="font-semibold text-gray-900 text-right"><?php echo htmlspecialchars($surat_data['nama_pemohon']); ?></dd></div>
                        <div class="py-2 flex justify-between"><dt class="text-gray-500">Tanggal Surat</dt><dd class="font-semibold text-gray-900 text-right"><?php echo date('d F Y', strtotime($surat_data['created_at'])); ?></dd></div>
                        <div class="py-2 flex justify-between"><dt class="text-gray-500">Status</dt><dd class="font-semibold text-green-600 text-right">SAH</dd></div>
                    </dl>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg border-t-8 border-red-500">
                 <div class="text-center">
                    <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h2 class="text-2xl font-bold text-red-600 mt-4">Dokumen Tidak Valid</h2>
                    <p class="text-gray-600 mt-1">Maaf, token verifikasi tidak ditemukan di dalam sistem kami. Dokumen ini tidak dapat diverifikasi keasliannya.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>