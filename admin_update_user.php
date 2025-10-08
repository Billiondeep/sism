<?php
// FILE: admin_update_user.php
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDbConnection();
    $user_id = (int)$_POST['user_id'];
    $nama = pg_escape_string($db, $_POST['nama']);
    $telp = pg_escape_string($db, $_POST['telp']);

    $query = 'UPDATE "user" SET nama = $1, telp = $2 WHERE id = $3';
    $result = pg_query_params($db, $query, array($nama, $telp, $user_id));

    if ($result) {
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Profil pengguna berhasil diperbarui!'];
        header("Location: /sism-rt-rw/manage_users.php");
        exit();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal memperbarui profil pengguna.'];
        header("Location: /sism-rt-rw/admin_edit_user.php?id=" . $user_id);
        exit();
    }
}
?>