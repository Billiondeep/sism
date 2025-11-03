<?php
// FILE: lupa_sandi.php - FINAL VERSION

session_start();
include_once 'config/database.php';

date_default_timezone_set('Asia/Jakarta'); 

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Email wajib diisi.';
    } else {
        $db = getDbConnection();

        // 1. Cari pengguna berdasarkan email
        $result = pg_query_params(
            $db,
            'SELECT id FROM "user" WHERE email = $1',
            array($email)
        );

        if ($user = pg_fetch_assoc($result)) {
            $user_id = $user['id'];
            
            // 2. Buat Token Acak Unik (64 karakter heksadesimal)
            $token = bin2hex(random_bytes(32));
            
            // 3. Tentukan waktu kedaluwarsa (misalnya, 1 jam dari sekarang)
            $expiry_time = date('Y-m-d H:i:s', time() + 3600); // +3600 detik = 1 jam

            // 4. Simpan token dan waktu kedaluwarsa ke database
            $update_query = pg_query_params(
                $db,
                'UPDATE "user" SET reset_token = $1, reset_expires = $2 WHERE id = $3',
                array($token, $expiry_time, $user_id)
            );

            if ($update_query) {
                // 5. Rangkai Tautan Reset Password
                // Ganti BASE URL ini sesuai dengan environment Anda (wajib diakhiri slash)
                $base_url = "http://localhost/sism-rt-rw/"; 
                $reset_link = $base_url . "atur_ulang_sandi.php?token=" . urlencode($token); 

                // 6. Tampilkan Pesan Sukses dan Tautan (Simulasi Email)
                $success = "Tautan reset password telah berhasil dibuat dan dikirim ke email Anda.";
                $success .= "<br><br><strong>‼️ DEBUGS: SALIN TAUTAN INI SEKARANG ‼️</strong>";
                $success .= "<p class='text-sm'>Gunakan tautan ini untuk melanjutkan proses reset password. (Hapus setelah deployment).</p>";
                // Gunakan textarea agar mudah disalin tanpa terpotong
                $success .= "<textarea id='reset-link-debug' rows='3' cols='80' readonly class='w-full mt-2 p-2 border rounded-md text-xs'>" . htmlspecialchars($reset_link) . "</textarea>";
                
            } else {
                $error = 'Gagal menyimpan token reset. Coba lagi.';
            }

        } else {
            // Beri pesan yang ambigu untuk keamanan (agar tidak memberi tahu user mana yang terdaftar)
            $success = 'Jika email ini terdaftar di sistem kami, tautan reset password akan dikirimkan.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password - SISM</title>
    <link href="/sism-rt-rw/assets/css/style.css" rel="stylesheet">
</head>
<body class="h-full">
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Lupa Password</h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10">
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    <?php echo $success; ?>
                </div>
                <div class="mt-6 text-center text-sm">
                    <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Kembali ke Halaman Login
                    </a>
                </div>
            <?php else: ?>
                <form class="space-y-6" action="lupa_sandi.php" method="POST">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Kirim Tautan Reset Password
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>