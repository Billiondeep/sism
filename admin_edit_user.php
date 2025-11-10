<?php
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

$user_id = (int)($_GET['id'] ?? 0);
if ($user_id <= 0) die("ID User tidak valid.");

$db = getDbConnection();
$result = pg_query_params($db, 'SELECT nama, email, telp FROM "user" WHERE id = $1', array($user_id));
$user = pg_fetch_assoc($result);
if (!$user) die("User tidak ditemukan.");
?>

<h1 class="text-2xl font-bold text-gray-800 font-poppins">
    Edit Profil User: <?php echo htmlspecialchars($user['nama']); ?>
</h1>

<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">

    <!-- Form Edit Profil -->
    <div class="bg-white p-8 shadow-xl rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Informasi Profil</h2>
        <form action="admin_update_user.php" method="POST" class="space-y-6">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama" 
                    value="<?php echo htmlspecialchars($user['nama']); ?>" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email (Tidak bisa diubah)</label>
                <input 
                    type="email" 
                    value="<?php echo htmlspecialchars($user['email']); ?>" 
                    readonly 
                    class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm"
                >
            </div>

            <div>
                <label for="telp" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input 
                    type="tel" 
                    name="telp" 
                    id="telp"
                    value="<?php echo htmlspecialchars($user['telp']); ?>" 
                    placeholder="081234567890"
                    pattern="[0-9]{10,15}"
                    title="Nomor telepon harus 10–15 digit angka tanpa spasi atau simbol"
                    maxlength="15"
                    required
                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Hanya angka 0–9, tanpa spasi atau tanda (+)</p>
            </div>

            <div class="text-right">
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Simpan Profil
                </button>
            </div>
        </form>
    </div>

    <!-- Form Ganti Password -->
    <div class="bg-white p-8 shadow-xl rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Ubah Password User</h2>
        <form action="admin_update_password.php" method="POST" class="space-y-6">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <div>
                <label for="sandi_baru" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input 
                    type="password" 
                    name="sandi_baru" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="konfirmasi_sandi_baru" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input 
                    type="password" 
                    name="konfirmasi_sandi_baru" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div class="text-right">
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700"
                >
                    Ganti Password
                </button>
            </div>
        </form>
    </div>
</div>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
