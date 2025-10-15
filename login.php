<?php
// FILE: login.php (KODE YANG DIPERBAIKI - STANDALONE)

session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}
include_once 'config/database.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $sandi = trim($_POST['sandi']);

    // Validasi input kosong
    if (empty($email)) {
        $error = 'Email wajib diisi.';
    } elseif (empty($sandi)) {
        $error = 'Password wajib diisi.';
        } elseif (strlen($sandi) < 6) {
        $error = 'Password minimal 6 karakter.';
    } else {
        $db = getDbConnection();
        $email = pg_escape_string($db, $email);

        $result = pg_query_params($db, 'SELECT * FROM "user" WHERE email = $1', array($email));

        if ($result === false) {
                $error = 'Terjadi kesalahan saat mengakses data pengguna. Silakan coba lagi nanti.';
                error_log('Query login gagal: ' . pg_last_error($db));
            } elseif ($user = pg_fetch_assoc($result)) {
                if (password_verify($sandi, $user['sandi'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['nama'] = $user['nama'];
                    $_SESSION['level'] = $user['level'];
                    $_SESSION['telp'] = $user['telp'];
                    header('Location: dashboard.php');
                    exit();
                } else {
                    $error = 'Password salah.';
                }
            } else {
                $error = 'Email tidak terdaftar.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SISM RT/RW</title>
    <!-- Link ke CSS lokal agar halaman login tetap rapi -->
    <link href="/sism-rt-rw/assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/sism-rt-rw/assets/images/logo-sism.png" type="image/png">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="h-full">
<div class="min-h-screen bg-gray-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
        <img class="mx-auto h-24 w-auto" src="/sism-rt-rw/assets/images/logo-sism.png" alt="SISM Logo">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900 font-poppins">
            Selamat Datang di SISM
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
            Sistem Informasi Surat Menyurat RT/RW
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10">
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
            <form class="space-y-6" action="login.php" method="POST" novalidate>
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <div class="mt-1">
            <input id="email" name="email" type="email" autocomplete="email"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="mt-1">
            <input id="password" name="sandi" type="password" autocomplete="current-password"
                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm
                placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>
    </div>

    <div>
        <button type="submit"
            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
            text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Login
        </button>
    </div>
</form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Belum punya akun?</span>
                    </div>
                </div>
                <div class="mt-6">
                    <a href="register.php" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Daftar sebagai Warga
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
