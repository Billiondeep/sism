<?php
// FILE: update_request.php
session_start();
include_once __DIR__ . '/includes/functions.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDbConnection();
    $type = $_POST['type'];
    $id = (int)$_POST['id'];
    $allowed_tables = ['surat_pengantar', 'surat_sktm', 'surat_domisili', 'surat_usaha', 'surat_penghasilan', 'surat_kelahiran_kematian'];
    if (!in_array($type, $allowed_tables)) die("Jenis surat tidak valid.");

    $set_parts = [];
    $params = [];
    $i = 1;
    foreach($_POST as $key => $value) {
        if (in_array($key, ['type', 'id'])) continue;
        $set_parts[] = pg_escape_identifier($db, $key) . ' = $' . $i++;
        $params[] = $value;
    }
    $params[] = $id; 
    $set_string = implode(', ', $set_parts);
    
    $query = "UPDATE \"$type\" SET $set_string WHERE id = \$$i";
    $result = pg_query_params($db, $query, $params);

    if ($result) {
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Data pengajuan surat berhasil diperbarui!'];
        header("Location: /sism-rt-rw/view_request.php?type=$type&id=$id");
        exit();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal memperbarui data surat.'];
        header("Location: /sism-rt-rw/edit_request.php?type=$type&id=$id");
        exit();
    }
}
?>