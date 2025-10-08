<?php
// FILE: edit_request.php 

// Langkah 1: Jalankan semua logika PHP terlebih dahulu, sebelum mencetak HTML
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

// --- SEMUA LOGIKA & FETCH DATA DILAKUKAN DI ATAS ---
$db = getDbConnection();
$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

$allowed_tables = [
    'surat_pengantar', 'surat_sktm', 'surat_domisili', 'surat_usaha',
    'surat_penghasilan', 'surat_kelahiran_kematian'
];

// Validasi yang lebih ketat, lalu redirect dengan pesan error jika gagal
if (!in_array($type, $allowed_tables) || $id <= 0) {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Permintaan untuk mengedit surat tidak valid.'];
    header('Location: /sism-rt-rw/dashboard.php');
    exit();
}

$query = "SELECT * FROM \"$type\" WHERE id = $1";
$result = pg_query_params($db, $query, array($id));
if ($result === false) {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Terjadi kesalahan pada database.'];
    header('Location: /sism-rt-rw/dashboard.php');
    exit();
}

$data = pg_fetch_assoc($result);
if ($data === false) {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Data pengajuan tidak ditemukan.'];
    header('Location: /sism-rt-rw/dashboard.php');
    exit();
}

// --- SETELAH SEMUA LOGIKA SELESAI DAN DATA VALID, BARU MULAI CETAK HTML ---
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
?>
<h1 class="text-2xl md:text-3xl font-bold text-gray-800 font-poppins">Edit Pengajuan Surat</h1>
<p class="mt-1 text-gray-600">Anda sedang mengubah data untuk: <strong><?php echo htmlspecialchars($data['nama'] ?? $data['nama_lengkap']); ?></strong></p>

<div class="mt-8 bg-white p-6 md:p-8 shadow-xl rounded-lg">
    <form action="/sism-rt-rw/update_request.php" method="POST" class="space-y-6">
        <input type="hidden" name="type" value="<?php echo $type; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <?php foreach ($data as $key => $value): 
            // Kolom yang tidak boleh diedit oleh admin
            if (in_array($key, ['id', 'user_id', 'created_at', 'status', 'dokumen_pendukung', 'catatan_penolakan'])) continue;
        ?>
            <div>
                <label for="<?php echo $key; ?>" class="block text-sm font-medium text-gray-700"><?php echo ucwords(str_replace('_', ' ', $key)); ?></label>
                <?php 
                // Gunakan textarea untuk input yang panjang
                if (strlen((string)$value) > 100 || strpos($key, 'alamat') !== false || strpos($key, 'keperluan') !== false): 
                ?>
                    <textarea name="<?php echo $key; ?>" id="<?php echo $key; ?>" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"><?php echo htmlspecialchars($value); ?></textarea>
                <?php else: ?>
                    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo htmlspecialchars($value); ?>" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <div class="flex justify-end pt-4 space-x-2">
            <a href="/sism-rt-rw/view_request.php?type=<?php echo $type; ?>&id=<?php echo $id; ?>" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Simpan Perubahan</button>
        </div>
    </form>
</div>
<?php include_once __DIR__ . '/includes/footer.php'; ?>