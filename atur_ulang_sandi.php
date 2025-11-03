<?php
// FILE: atur_ulang_sandi.php - VERSI PRODUKSI BERSIH
session_start();
include_once 'config/database.php';

// PENTING: Tetapkan zona waktu agar NOW() di DB dan waktu PHP konsisten.
date_default_timezone_set('Asia/Jakarta'); 

$error = '';
$success = '';

// =========================================================
// >>> Solusi Parsing URL Manual (Mengatasi masalah $_GET yang kosong) <<<
$token = '';
if (isset($_SERVER['REQUEST_URI'])) {
    $current_url = $_SERVER['REQUEST_URI'];
    
    // 1. Ekstrak bagian query string
    $query_string = parse_url($current_url, PHP_URL_QUERY);

    if ($query_string) {
        // 2. Uraikan query string menjadi array asosiatif
        parse_str($query_string, $params);
        
        // 3. Ambil nilai token dari array params
        $token = isset($params['token']) ? trim($params['token']) : '';
    }
}
// =========================================================

$user_found = false;
$user_id = null;


// 1. Cek validitas Token (MENGGUNAKAN $token HASIL PARSING MANUAL)
if (!empty($token)) {
    $db = getDbConnection(); 
    
    // Cari user dengan token ini DAN token belum kedaluwarsa (reset_expires > NOW())
    $result = pg_query_params(
        $db,
        'SELECT id FROM "user" WHERE reset_token = $1 AND reset_expires > NOW()',
        array($token)
    );

    if ($user = pg_fetch_assoc($result)) {
        $user_found = true;
        $user_id = $user['id'];
    } else {
        // Tautan tidak valid atau sudah kedaluwarsa (Ini yang terjadi pada kasus terakhir Anda)
        $error = 'Tautan tidak valid atau sudah kedaluwarsa.';
    }
} else {
    // Token tidak ada di URL
    $error = 'Token reset tidak ditemukan.'; 
}

// 2. Jika Token Valid dan Form Disubmit
if ($user_found && $_SERVER['REQUEST_METHOD'] == 'POST' && $user_id) {
    
    $sandi_baru = trim($_POST['sandi_baru'] ?? '');
    $konfirmasi_sandi = trim($_POST['konfirmasi_sandi'] ?? '');

    if (strlen($sandi_baru) < 6) {
        $error = 'Password minimal 6 karakter.';
    } elseif ($sandi_baru !== $konfirmasi_sandi) {
        $error = 'Konfirmasi password tidak cocok.';
    } else {
        $hashed_sandi = password_hash($sandi_baru, PASSWORD_DEFAULT);

        // Update password dan HAPUS token agar tidak dapat digunakan lagi
        $update_query = pg_query_params(
            $db,
            'UPDATE "user" SET sandi = $1, reset_token = NULL, reset_expires = NULL WHERE id = $2',
            array($hashed_sandi, $user_id)
        );

        if ($update_query) {
            $success = 'Password Anda berhasil diubah. Silakan login dengan password baru Anda.';
            header('Refresh: 5; URL=login.php');
        } else {
            $error = 'Gagal memperbarui password. Silakan coba lagi.';
            // JANGAN HAPUS: error_log tetap penting untuk debugging backend
            error_log('Gagal update password di atur_ulang_sandi: ' . pg_last_error($db)); 
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
<meta charset="UTF-8">
    <title>Atur Ulang Password - SISM</title>
    <link href="/sism-rt-rw/assets/css/style.css" rel="stylesheet">
</head>
<body class="h-full">
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="text-center text-3xl font-extrabold text-gray-900">Atur Ulang Password</h2>
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
                    <p><?php echo $success; ?></p>
                    <p class="mt-2">Anda akan diarahkan ke halaman login dalam 5 detik.</p>
                </div>
                <div class="mt-6 text-center text-sm">
                    <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Klik di sini untuk Login sekarang.
                    </a>
                </div>

            <?php elseif ($user_found): ?>
<form class="space-y-6" action="atur_ulang_sandi.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
                    <div>
                        <label for="sandi_baru" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input id="sandi_baru" name="sandi_baru" type="password" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="konfirmasi_sandi" class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                        <input id="konfirmasi_sandi" name="konfirmasi_sandi" type="password" required 
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Atur Ulang Password
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>