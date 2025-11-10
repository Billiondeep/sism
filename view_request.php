<?php
// FILE: view_request.php

define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

$db = getDbConnection();
$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

$allowed_tables = [
    'surat_pengantar', 'surat_sktm', 'surat_domisili', 'surat_usaha',
    'surat_penghasilan', 'surat_kelahiran_kematian'
];
if (!in_array($type, $allowed_tables) || $id <= 0) {
    die("Permintaan tidak valid.");
}

$query = "SELECT * FROM \"$type\" WHERE id = $1";
$result = pg_query_params($db, $query, array($id));
if ($result === false) die("Error dalam menjalankan query: " . pg_last_error($db));

$data = pg_fetch_assoc($result);
if ($data === false) die("Data pengajuan tidak ditemukan.");
?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'resent'): ?>
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
    <p class="font-bold">Berhasil!</p>
    <p>Notifikasi dan PDF telah dikirim ulang ke WhatsApp pemohon.</p>
</div>
<?php endif; ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900 font-poppins">Detail Pengajuan Surat</h1>
    <a href="/sism-rt-rw/edit_request.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">Edit Data</a>
</div>

<div class="mt-6 bg-white shadow-xl rounded-lg overflow-hidden">
    <div class="px-4 py-5 sm:px-6 bg-gray-50 border-b">
        <h3 class="text-lg leading-6 font-medium text-gray-900">Informasi Pemohon</h3>
    </div>
    <div class="border-t border-gray-200">
        <dl>
            <?php foreach ($data as $key => $value):
                if (in_array($key, ['id', 'user_id', 'created_at'])) continue;
            ?>
            <div class="bg-gray-50 px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500"><?php echo ucwords(str_replace('_', ' ', $key)); ?></dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    <?php if ($key == 'dokumen_pendukung' && !empty($value)): ?>
                        <a href="/sism-rt-rw/uploads/<?php echo htmlspecialchars($value); ?>" target="_blank" class="text-indigo-600 hover:underline">Lihat/Unduh Dokumen</a>
                    <?php else: ?>
                        <?php echo htmlspecialchars((string)$value); ?>
                    <?php endif; ?>
                </dd>
            </div>
            <?php endforeach; ?>
        </dl>
    </div>
</div>

<?php if (isset($data['status']) && $data['status'] !== 'Selesai' && $data['status'] !== 'Ditolak'): ?>
    <!-- Form persetujuan jika status belum final -->
    <div class="mt-8 bg-white shadow-xl rounded-lg p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Persetujuan</h3>
        <form action="/sism-rt-rw/update_status.php" method="POST" class="space-y-4">
             <input type="hidden" name="type" value="<?php echo $type; ?>">
             <input type="hidden" name="id" value="<?php echo $id; ?>">
             <input type="hidden" name="telp" value="<?php echo htmlspecialchars($data['telp']); ?>">
             <input type="hidden" name="nama" value="<?php echo htmlspecialchars($data['nama'] ?? $data['nama_lengkap']); ?>">
             <div>
                 <label for="status" class="block text-sm font-medium text-gray-700">Pilih Aksi</label>
                 <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                     <option value="Diproses">Tandai sebagai "Diproses"</option>
                     <option value="Selesai">Setujui & Buat Surat (Selesai)</option>
                     <option value="Ditolak">Tolak Pengajuan</option>
                 </select>
             </div>
             <div>
                 <label for="catatan_penolakan" class="block text-sm font-medium text-gray-700">Alasan Penolakan (Wajib diisi jika menolak)</label>
                 <textarea name="catatan_penolakan" id="catatan_penolakan" rows="3" placeholder="Contoh: Scan KTP tidak jelas, harap upload ulang." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
             </div>
             <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Update Status</button>
             </div>
        </form>
    </div>
<?php else: ?>
    <!-- Aksi lanjutan jika status sudah final -->
    <div class="mt-8 bg-white shadow-xl rounded-lg p-6">
        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Aksi Lanjutan</h3>
        <?php if ($data['status'] === 'Selesai'): ?>
            <p class="text-sm text-gray-600 mb-4">Pengajuan ini telah disetujui. Anda dapat melihat PDF surat yang telah dibuat.</p>
            <div class="flex items-center space-x-4">
                <a href="/sism-rt-rw/generate_pdf.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat PDF
                </a>
            </div>
        <?php else: // Status Ditolak ?>
             <p class="text-gray-500">Tidak ada aksi lanjutan untuk surat yang ditolak.</p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
