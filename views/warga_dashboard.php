<?php
// FILE: views/warga_dashboard.php
if (!defined('SISM_EXEC')) die('Direct access not allowed');
include_once __DIR__ . '/../config/database.php';
$db = getDbConnection();
$user_id = $_SESSION['user_id'];

// --- Query 1: Mengambil 3 pengajuan terakhir untuk Riwayat ---
$history_query = "(SELECT id, 'Surat Pengantar' as jenis_surat, status, created_at, 'surat_pengantar' as table_name FROM surat_pengantar WHERE user_id = $1)
    UNION ALL (SELECT id, 'SKTM' as jenis_surat, status, created_at, 'surat_sktm' as table_name FROM surat_sktm WHERE user_id = $1)
    UNION ALL (SELECT id, 'Surat Domisili' as jenis_surat, status, created_at, 'surat_domisili' as table_name FROM surat_domisili WHERE user_id = $1)
    UNION ALL (SELECT id, 'Surat Usaha' as jenis_surat, status, created_at, 'surat_usaha' as table_name FROM surat_usaha WHERE user_id = $1)
    UNION ALL (SELECT id, 'Surat Penghasilan' as jenis_surat, status, created_at, 'surat_penghasilan' as table_name FROM surat_penghasilan WHERE user_id = $1)
    UNION ALL (SELECT id, CONCAT('Ket. ', jenis_keterangan) as jenis_surat, status, created_at, 'surat_kelahiran_kematian' as table_name FROM surat_kelahiran_kematian WHERE user_id = $1)
    ORDER BY created_at DESC LIMIT 3";
$history_result = pg_query_params($db, $history_query, array($user_id));
$requests = pg_fetch_all($history_result);


// --- Query 2: Mengambil notifikasi surat yang ditolak ---
$notif_query = "
    (SELECT 'Surat Pengantar' as jenis_surat, catatan_penolakan FROM surat_pengantar WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
    UNION ALL
    (SELECT 'SKTM' as jenis_surat, catatan_penolakan FROM surat_sktm WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
    UNION ALL
    (SELECT 'Surat Domisili' as jenis_surat, catatan_penolakan FROM surat_domisili WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
    UNION ALL
    (SELECT 'Surat Usaha' as jenis_surat, catatan_penolakan FROM surat_usaha WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
    UNION ALL
    (SELECT 'Surat Penghasilan' as jenis_surat, catatan_penolakan FROM surat_penghasilan WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
    UNION ALL
    (SELECT CONCAT('Ket. ', jenis_keterangan) as jenis_surat, catatan_penolakan FROM surat_kelahiran_kematian WHERE user_id = $1 AND status = 'Ditolak' AND catatan_penolakan IS NOT NULL AND catatan_penolakan <> '')
";
$notif_result = pg_query_params($db, $notif_query, array($user_id));
$notifications = pg_fetch_all($notif_result);
?>
<h1 class="text-2xl font-bold text-gray-800 font-poppins">🏠 Dashboard Warga</h1>
<p class="mt-1 text-gray-600">Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>!.</p>

<?php
if (isset($_SESSION['flash_message'])) {
    $flash = $_SESSION['flash_message'];
    $alert_type = $flash['type'] === 'success' ? 'green' : 'red';
    echo "<div class='bg-{$alert_type}-100 border-l-4 border-{$alert_type}-500 text-{$alert_type}-700 p-4 my-6 rounded-md' role='alert'>";
    echo "<p class='font-bold'>" . ($flash['type'] === 'success' ? 'Berhasil!' : 'Terjadi Kesalahan!') . "</p>";
    echo "<p>{$flash['message']}</p>";
    echo "</div>";
    unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
}
?>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-8">
        <?php if ($notifications && count($notifications) > 0): ?>
        <div class="bg-yellow-100 border-l-4 border-yellow-500 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-yellow-800 font-poppins mb-4">📬 Notifikasi Penting</h2>
            <ul class="space-y-3">
                <?php foreach($notifications as $notif): ?>
                <li class="flex items-start">
                    <span class="text-yellow-600 mr-2 mt-1">🔔</span> 
                    <span class="text-yellow-800">
                        Pengajuan <strong><?php echo htmlspecialchars($notif['jenis_surat']); ?></strong> Anda ditolak.
                        <br>
                        <small class="text-yellow-700"><strong>Alasan:</strong> <?php echo htmlspecialchars($notif['catatan_penolakan']); ?></small>
                    </span>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700 font-poppins mb-4">📄 Riwayat Pengajuan Terakhir</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Jenis Surat</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if ($requests && count($requests) > 0): ?>
                            <?php foreach ($requests as $req): 
                                $status_text = ($req['status'] == 'Selesai') ? 'Disetujui' : $req['status'];
                            ?>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($req['jenis_surat']); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center"><?php echo date('d M Y', strtotime($req['created_at'])); ?></td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <span class="badge badge-<?php echo strtolower($status_text); ?>"><?php echo htmlspecialchars($status_text); ?></span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm">
                                        <?php if ($req['status'] === 'Selesai'): ?>
                                            <a href="/sism-rt-rw/generate_pdf.php?type=<?php echo $req['table_name']; ?>&id=<?php echo $req['id']; ?>" target="_blank" class="text-indigo-600 hover:underline">🔽 Lihat/Unduh</a>
                                        <?php else: ?>
                                            <span class="text-gray-400">Lihat</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center py-6 text-gray-500">Anda belum memiliki riwayat pengajuan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700 font-poppins mb-4">➕ Buat Pengajuan Surat Baru</h2>
            <p class="text-gray-600 mb-4">📌 Perlu mengurus surat? Klik tombol di bawah untuk melihat semua jenis surat yang tersedia dan mulai pengajuan Anda.</p>
            <div class="text-center">
                <a href="/sism-rt-rw/info_surat.php" class="inline-block px-8 py-3 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition-colors">
                    Pilih & Ajukan Surat
                </a>
            </div>
        </div>
    </div>

    <div class="space-y-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700 font-poppins mb-4">👤 Profil Anda</h2>
            <div class="space-y-2 text-gray-700">
                <p><strong>Nama:</strong> <?php echo htmlspecialchars($_SESSION['nama']); ?></p>
                <p><strong>No. HP:</strong> <?php echo htmlspecialchars($_SESSION['telp']); ?></p>
            </div>
            <div class="mt-4 pt-4 border-t border-gray-200">
                 <a href="/sism-rt-rw/profil.php" class="text-indigo-600 hover:underline font-semibold">🔧 Edit Profil & Lihat Detail</a>
            </div>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-bold text-gray-700 font-poppins mb-4">❓ Bantuan & Informasi</h2>
             <div class="space-y-2 text-gray-700">
                <p>📘 <a href="/sism-rt-rw/info_surat.php" class="text-indigo-600 hover:underline">Panduan Pengajuan Surat</a></p>
                <p>📞 <strong>Kontak RT/RW:</strong> 0812-3456-7890</p>
            </div>
        </div>
    </div>
</div>