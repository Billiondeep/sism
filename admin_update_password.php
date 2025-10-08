<?php
// FILE: admin_update_password.php
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDbConnection();
    $user_id = (int)$_POST['user_id'];
    $sandi_baru = $_POST['sandi_baru'];
    $konfirmasi_sandi_baru = $_POST['konfirmasi_sandi_baru'];

    if ($sandi_baru !== $konfirmasi_sandi_baru) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Konfirmasi password baru tidak cocok.'];
        header("Location: /sism-rt-rw/admin_edit_user.php?id=" . $user_id);
        exit();
    }
    
    $sandi_hash_baru = password_hash($sandi_baru, PASSWORD_DEFAULT);
    $update_query = 'UPDATE "user" SET sandi = $1 WHERE id = $2';
    $update_result = pg_query_params($db, $update_query, array($sandi_hash_baru, $user_id));

    if ($update_result) {
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Password pengguna berhasil diubah!'];
        header("Location: /sism-rt-rw/manage_users.php");
        exit();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal mengubah password pengguna.'];
        header("Location: /sism-rt-rw/admin_edit_user.php?id=" . $user_id);
        exit();
    }
}
?>