<?php
// FILE: manage_users.php
define('SISM_EXEC', true);
include_once __DIR__ . '/includes/header.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

$db = getDbConnection();
$result = pg_query($db, 'SELECT id, nama, email, telp, level, created_at FROM "user" ORDER BY created_at DESC');
$users = pg_fetch_all($result);
?>
<h1 class="text-3xl font-bold leading-tight text-gray-900 font-poppins">Manajemen User</h1>
<p class="mt-2 text-md text-gray-600">Daftar semua pengguna yang terdaftar di dalam sistem.</p>

<?php
if (isset($_SESSION['flash_message'])) {
    $flash = $_SESSION['flash_message'];
    $alert_type = $flash['type'] === 'success' ? 'green' : 'red';
    echo "<div class='bg-{$alert_type}-100 border-l-4 border-{$alert_type}-500 text-{$alert_type}-700 p-4 my-6 rounded-md' role='alert'>";
    echo "<p class='font-bold'>" . ($flash['type'] === 'success' ? 'Berhasil!' : 'Terjadi Kesalahan!') . "</p>";
    echo "<p>{$flash['message']}</p>";
    echo "</div>";
    unset($_SESSION['flash_message']);
}
?>

<div class="mt-8 bg-white shadow-lg rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kontak</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Level</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if ($users && count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo htmlspecialchars($user['nama']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($user['email']); ?></div>
                                <div class="text-sm text-gray-500"><?php echo htmlspecialchars($user['telp']); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500"><?php echo htmlspecialchars($user['level']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <a href="admin_edit_user.php?id=<?php echo $user['id']; ?>" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include_once __DIR__ . '/includes/footer.php'; ?>