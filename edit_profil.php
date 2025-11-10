<?php
// FILE: edit_profil.php
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('warga');
include_once __DIR__ . '/config/database.php';

$db = getDbConnection();
$user_id = $_SESSION['user_id'];
$result = pg_query_params($db, 'SELECT nama, email, telp FROM "user" WHERE id = $1', array($user_id));
$user = pg_fetch_assoc($result);
?>
<h1 class="text-2xl font-bold text-gray-800 font-poppins">Edit Profil</h1>
<p class="mt-1 text-gray-600">Perbarui informasi nama dan nomor telepon Anda.</p>

<div class="mt-8 max-w-2xl mx-auto">
    <div class="bg-white p-8 shadow-xl rounded-lg">
        <form action="update_profil.php" method="POST" class="space-y-6">
            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input 
                    type="text" 
                    name="nama" 
                    id="nama" 
                    value="<?php echo htmlspecialchars($user['nama']); ?>" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email (Tidak bisa diubah)</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    value="<?php echo htmlspecialchars($user['email']); ?>" 
                    readonly 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
                >
            </div>

            <div>
                <label for="telp" class="block text-sm font-medium text-gray-700">
                    Nomor Telepon
                </label>
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

            <div class="flex justify-end pt-4 space-x-2">
                <a href="profil.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                <button 
                    type="submit" 
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
<?php include_once __DIR__ . '/includes/footer.php'; ?>
