<?php
// FILE: profil.php
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('warga');
include_once __DIR__ . '/config/database.php';

$db = getDbConnection();
$user_id = $_SESSION['user_id'];
$result = pg_query_params($db, 'SELECT * FROM "user" WHERE id = $1', array($user_id));
$user = pg_fetch_assoc($result);
?>
<h1 class="text-2xl font-bold text-gray-800 font-poppins">Profil Saya</h1>
<p class="mt-1 text-gray-600">Kelola informasi data diri dan keamanan akun Anda.</p>

<div class="mt-8 max-w-2xl mx-auto">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <!-- Bagian untuk menampilkan Flash Message -->
        <?php
        if (isset($_SESSION['flash_message'])) {
            $flash = $_SESSION['flash_message'];
            $alert_type = $flash['type'] === 'success' ? 'green' : 'red';
            echo "<div class='bg-{$alert_type}-100 border-l-4 border-{$alert_type}-500 text-{$alert_type}-700 p-4 mb-6 rounded-md' role='alert'>";
            echo "<p class='font-bold'>" . ($flash['type'] === 'success' ? 'Berhasil!' : 'Terjadi Kesalahan!') . "</p>";
            echo "<p>{$flash['message']}</p>";
            echo "</div>";
            unset($_SESSION['flash_message']); // Hapus pesan setelah ditampilkan
        }
        ?>

        <div class="border-b border-gray-200 pb-4 mb-4">
             <dl class="divide-y divide-gray-200">
                <div class="py-3 flex justify-between text-sm font-medium"><dt class="text-gray-500">Nama Lengkap</dt><dd class="text-gray-900"><?php echo htmlspecialchars($user['nama']); ?></dd></div>
                <div class="py-3 flex justify-between text-sm font-medium"><dt class="text-gray-500">Email</dt><dd class="text-gray-900"><?php echo htmlspecialchars($user['email']); ?></dd></div>
                <div class="py-3 flex justify-between text-sm font-medium"><dt class="text-gray-500">Nomor Telepon (WhatsApp)</dt><dd class="text-gray-900"><?php echo htmlspecialchars($user['telp']); ?></dd></div>
            </dl>
        </div>
        <div class="mt-4 flex space-x-4">
            <a href="edit_profil.php" class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg shadow-md hover:bg-yellow-600 w-full text-center">🔧 Edit Profil</a>
            <a href="ubah_password.php" class="px-4 py-2 bg-gray-600 text-white font-semibold rounded-lg shadow-md hover:bg-gray-700 w-full text-center">🔒 Ubah Password</a>
        </div>
    </div>
</div>
<?php include_once __DIR__ . '/includes/footer.php'; ?>