<?php
// FILE: update_password.php
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('warga');
include_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDbConnection();
    $user_id = $_SESSION['user_id'];
    $sandi_lama = $_POST['sandi_lama'];
    $sandi_baru = $_POST['sandi_baru'];
    $konfirmasi_sandi_baru = $_POST['konfirmasi_sandi_baru'];

    if ($sandi_baru !== $konfirmasi_sandi_baru) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Konfirmasi password baru tidak cocok.'];
        header('Location: ubah_password.php');
        exit();
    }
    
    $result = pg_query_params($db, 'SELECT sandi FROM "user" WHERE id = $1', array($user_id));
    $user = pg_fetch_assoc($result);
    $sandi_hash_lama = $user['sandi'];

    if (password_verify($sandi_lama, $sandi_hash_lama)) {
        $sandi_hash_baru = password_hash($sandi_baru, PASSWORD_DEFAULT);
        $update_query = 'UPDATE "user" SET sandi = $1 WHERE id = $2';
        pg_query_params($db, $update_query, array($sandi_hash_baru, $user_id));
        
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Password berhasil diubah!'];
        header('Location: profil.php');
        exit();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Password lama yang Anda masukkan salah.'];
        header('Location: ubah_password.php');
        exit();
    }
}
?>