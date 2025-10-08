<?php
// FILE: views/admin_dashboard.php (KODE YANG DIPERBARUI TOTAL)

if (!defined('SISM_EXEC')) die('Direct access not allowed');
include_once __DIR__ . '/../config/database.php';
$db = getDbConnection();

// --- LOGIKA BARU UNTUK MENGAMBIL DAN MEMPROSES DATA ---

// 1. Ambil semua data dari semua tabel surat
$query = "
    (SELECT id, nama, 'Surat Pengantar' as jenis_surat, status, created_at, telp, 'surat_pengantar' as table_name FROM surat_pengantar)
    UNION ALL
    (SELECT id, nama, 'SKTM' as jenis_surat, status, created_at, telp, 'surat_sktm' as table_name FROM surat_sktm)
    UNION ALL
    (SELECT id, nama, 'Surat Domisili' as jenis_surat, status, created_at, telp, 'surat_domisili' as table_name FROM surat_domisili)
    UNION ALL
    (SELECT id, nama, 'Surat Usaha' as jenis_surat, status, created_at, telp, 'surat_usaha' as table_name FROM surat_usaha)
    UNION ALL
    (SELECT id, nama, 'Surat Penghasilan' as jenis_surat, status, created_at, telp, 'surat_penghasilan' as table_name FROM surat_penghasilan)
    UNION ALL
    (SELECT id, nama_lengkap as nama, CONCAT('Ket. ', jenis_keterangan) as jenis_surat, status, created_at, telp, 'surat_kelahiran_kematian' as table_name FROM surat_kelahiran_kematian)
    ORDER BY created_at DESC
";
$result_all = pg_query($db, $query);
if (!$result_all) {
    die("Error dalam query: " . pg_last_error($db));
}
$all_requests = pg_fetch_all($result_all);

// 2. Ambil data jumlah pengguna
$user_count_result = pg_query($db, 'SELECT COUNT(*) as total FROM "user"');
$user_count = pg_fetch_assoc($user_count_result)['total'];

// 3. Hitung statistik dari data yang sudah diambil
$stats = [
    'total' => count($all_requests),
    'menunggu' => 0,
    'selesai' => 0,
    'diproses' => 0,
];
foreach ($all_requests as $req) {
    if ($req['status'] == 'Menunggu') $stats['menunggu']++;
    if ($req['status'] == 'Selesai') $stats['selesai']++;
    if ($req['status'] == 'Diproses') $stats['diproses']++;
}

// 4. Logika untuk filter
$filter_status = $_GET['status'] ?? 'Semua';
$display_requests = $all_requests; // Tampilkan semua secara default

if ($filter_status !== 'Semua') {
    $display_requests = array_filter($all_requests, function($req) use ($filter_status) {
        return $req['status'] == $filter_status;
    });
}
?>

<!-- Tampilan HTML Baru -->
<h1 class="text-3xl font-bold leading-tight text-gray-900 font-poppins">Dashboard Admin</h1>
<p class="mt-2 text-md text-gray-600">Selamat datang kembali! Berikut adalah ringkasan aktivitas di sistem.</p>

<!-- Kartu Statistik Baru -->
<div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 truncate">Total Pengajuan</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo $stats['total']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 truncate">Menunggu Persetujuan</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo $stats['menunggu']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 truncate">Surat Selesai</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo $stats['selesai']; ?></p>
            </div>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <div class="flex items-center">
            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-500 truncate">Total Pengguna</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo $user_count; ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Tabel Pengajuan dengan Filter -->
<div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="p-4 border-b border-gray-200">
        <h2 class="text-xl font-bold text-gray-800">Daftar Pengajuan Surat</h2>
        <!-- Filter Buttons -->
        <div class="mt-4 flex space-x-2">
            <a href="dashboard.php" class="px-4 py-2 text-sm font-medium rounded-md <?php echo $filter_status == 'Semua' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">Semua</a>
            <a href="dashboard.php?status=Menunggu" class="px-4 py-2 text-sm font-medium rounded-md <?php echo $filter_status == 'Menunggu' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">Menunggu</a>
            <a href="dashboard.php?status=Diproses" class="px-4 py-2 text-sm font-medium rounded-md <?php echo $filter_status == 'Diproses' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">Diproses</a>
            <a href="dashboard.php?status=Selesai" class="px-4 py-2 text-sm font-medium rounded-md <?php echo $filter_status == 'Selesai' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">Selesai</a>
            <a href="dashboard.php?status=Ditolak" class="px-4 py-2 text-sm font-medium rounded-md <?php echo $filter_status == 'Ditolak' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'; ?>">Ditolak</a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemohon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Surat</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($display_requests && count($display_requests) > 0): ?>
                    <?php foreach ($display_requests as $req): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($req['nama']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($req['telp']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"><?php echo htmlspecialchars($req['jenis_surat']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center"><?php echo date('d M Y, H:i', strtotime($req['created_at'])); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="badge badge-<?php echo strtolower(str_replace(' ', '', $req['status'])); ?>"><?php echo htmlspecialchars($req['status']); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <a href="/sism-rt-rw/view_request.php?type=<?php echo $req['table_name']; ?>&id=<?php echo $req['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-10 text-gray-500">
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pengajuan dengan status "<?php echo $filter_status; ?>"</h3>
                            <p class="mt-1 text-sm text-gray-500">Coba pilih filter status yang lain.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
