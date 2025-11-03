<?php
// FILE: update_password.php - LOGIKA PEMROSESAN UBAH PASSWORD
session_start();

include_once 'config/database.php'; // Asumsi file koneksi database
date_default_timezone_set('Asia/Jakarta'); 

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// URL redirect kembali ke form jika ada error
$redirect_url = 'ubah_password.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $redirect_url);
    exit();
}

// Ambil data
$user_id = $_SESSION['user_id'];
$sandi_lama = trim($_POST['sandi_lama'] ?? '');
$sandi_baru = trim($_POST['sandi_baru'] ?? '');
$konfirmasi_sandi_baru = trim($_POST['konfirmasi_sandi_baru'] ?? '');

$error = '';

// --- 1. Validasi Input Klien ---

if (empty($sandi_lama) || empty($sandi_baru) || empty($konfirmasi_sandi_baru)) {
    $error = 'Semua field wajib diisi.';
} elseif (strlen($sandi_baru) < 6) {
    $error = 'Password baru minimal harus 6 karakter.';
} 
// 🚨 VALIDASI KRITIS 1: Password Baru TIDAK BOLEH SAMA dengan Password Lama
elseif ($sandi_lama === $sandi_baru) {
    $error = 'Password baru tidak boleh sama dengan password lama Anda.';
}
// 🚨 VALIDASI KRITIS 2: Konfirmasi Password Baru harus sama
elseif ($sandi_baru !== $konfirmasi_sandi_baru) {
    $error = 'Konfirmasi password baru tidak cocok.';
}

// Jika ada error validasi input, redirect kembali ke form
if ($error) {
    header('Location: ' . $redirect_url . '?error=' . urlencode($error));
    exit();
}

// --- 2. Verifikasi Password Lama dengan Database ---

$db = getDbConnection();

// Ambil hash sandi lama dari database
$result = pg_query_params(
    $db, 
    'SELECT sandi FROM "user" WHERE id = $1', 
    array($user_id)
);

if ($result && $user = pg_fetch_assoc($result)) {
    $hash_sandi_lama = $user['sandi'];

    if (!password_verify($sandi_lama, $hash_sandi_lama)) {
        // Jika password lama yang dimasukkan salah
        $error = 'Password lama yang Anda masukkan salah.';
    }
} else {
    // Error database atau user tidak ditemukan (sangat jarang terjadi jika sesi valid)
    $error = 'Terjadi kesalahan sistem. Silakan coba lagi.';
}

// Jika ada error saat verifikasi, redirect
if ($error) {
    header('Location: ' . $redirect_url . '?error=' . urlencode($error));
    exit();
}

// --- 3. Update Password Baru ke Database ---

// Hash password baru sebelum disimpan
$hashed_sandi_baru = password_hash($sandi_baru, PASSWORD_DEFAULT);

$update_query = pg_query_params(
    $db, 
    'UPDATE "user" SET sandi = $1 WHERE id = $2', 
    array($hashed_sandi_baru, $user_id)
);

if ($update_query) {
    // Sukses: Redirect kembali ke halaman ubah password dengan pesan sukses
    $success_message = 'Password Anda berhasil diubah!';
    header('Location: ' . $redirect_url . '?success=' . urlencode($success_message));
    exit();
} else {
    // Gagal update database
    $error = 'Gagal memperbarui password. Silakan coba lagi.';
    error_log('Gagal update password user ID ' . $user_id . ': ' . pg_last_error($db));
    header('Location: ' . $redirect_url . '?error=' . urlencode($error));
    exit();
}
?>
