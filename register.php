<?php
// FILE: register.php (KODE YANG DIPERBAIKI - STANDALONE)

session_start();
// Jika user sudah login, arahkan ke dashboard, jangan biarkan mendaftar lagi.
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit();
}

include_once 'config/database.php';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = getDbConnection();
    $nama = pg_escape_string($db, $_POST['nama']);
    $email = pg_escape_string($db, $_POST['email']);
    $telp = pg_escape_string($db, $_POST['telp']);
    $sandi = $_POST['sandi'];
    $sandi_konfirmasi = $_POST['sandi_konfirmasi'];

    if (empty($nama) || empty($email) || empty($sandi) || empty($telp)) {
        $error = 'Semua field wajib diisi.';
    } elseif ($sandi !== $sandi_konfirmasi) {
        $error = 'Konfirmasi password tidak cocok!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        $result = pg_query_params($db, 'SELECT id FROM "user" WHERE email = $1', array($email));
        if (pg_num_rows($result) > 0) {
            $error = 'Email sudah terdaftar. Silakan gunakan email lain.';
        } else {
            $sandi_hash = password_hash($sandi, PASSWORD_DEFAULT);
            $query = 'INSERT INTO "user" (nama, email, telp, sandi, level) VALUES ($1, $2, $3, $4, \'warga\')';
            $insert_result = pg_query_params($db, $query, array($nama, $email, $telp, $sandi_hash));

            if ($insert_result) {
                $success = 'Registrasi berhasil! Anda akan diarahkan ke halaman login dalam 5 detik. Atau <a href="login.php" class="font-bold text-indigo-700">klik di sini</a> untuk login.';
                header("refresh:5;url=login.php");
            } else {
                $error = 'Registrasi gagal, silakan coba lagi.';
                error_log("Registration failed: " . pg_last_error($db));
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - SISM RT/RW</title>
    <!-- Link ke CSS lokal agar halaman registrasi tetap rapi -->
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
            Buat Akun Baru
        </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
        <div class="bg-white py-8 px-4 shadow-xl rounded-lg sm:px-10">
            <?php if ($error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert"><p><?php echo $error; ?></p></div>
            <?php endif; ?>
            <?php if ($success): ?>
                 <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert"><p><?php echo $success; ?></p></div>
            <?php else: ?>
            <form class="space-y-6" action="register.php" method="POST">
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input id="nama" name="nama" type="text" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" name="email" type="email" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                 <div>
                    <label for="telp" class="block text-sm font-medium text-gray-700">No. WhatsApp (Format: 628...)</label>
                    <input id="telp" name="telp" type="tel" required placeholder="6281234567890" class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="sandi" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="sandi" name="sandi" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <label for="sandi_konfirmasi" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input id="sandi_konfirmasi" name="sandi_konfirmasi" type="password" required class="mt-1 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Daftar
                    </button>
                </div>
            </form>
            <p class="mt-4 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="login.php" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Login di sini
                </a>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>