<?php
// FILE: ubah_password.php - FORMULIR UNTUK MENGGANTI PASSWORD

define('SISM_EXEC', true);
// Asumsi includes/header.php dan require_login() tersedia
include_once __DIR__ . '/includes/header.php'; 

// Memastikan hanya pengguna yang memiliki level 'warga' yang bisa mengakses
// Ganti 'warga' dengan level yang sesuai di sistem Anda jika berbeda
require_login('warga'); 
?>
<h1 class="text-2xl font-bold text-gray-800 font-poppins">Ubah Password</h1>
<p class="mt-1 text-gray-600">Ganti password lama Anda dengan yang baru untuk keamanan.</p>

<div class="mt-8 max-w-2xl mx-auto">
    <div class="bg-white p-8 shadow-xl rounded-lg">
        
        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <p><?php echo htmlspecialchars($_GET['error']); ?></p>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <p><?php echo htmlspecialchars($_GET['success']); ?></p>
            </div>
        <?php endif; ?>

        <form action="update_password.php" method="POST" class="space-y-6">
            <div>
                <label for="sandi_lama" class="block text-sm font-medium text-gray-700">Password Lama</label>
                <input type="password" name="sandi_lama" id="sandi_lama" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2">
            </div>
             <div>
                <label for="sandi_baru" class="block text-sm font-medium text-gray-700">Password Baru</label>
                <input type="password" name="sandi_baru" id="sandi_baru" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2">
            </div>
             <div>
                <label for="konfirmasi_sandi_baru" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi_sandi_baru" id="konfirmasi_sandi_baru" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm px-3 py-2">
            </div>
            <div class="flex justify-end pt-4 space-x-2">
                <a href="profil.php" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Ubah Password</button>
            </div>
        </form>
    </div>
</div>
<?php 
// Asumsi includes/footer.php tersedia
include_once __DIR__ . '/includes/footer.php'; 
?>
