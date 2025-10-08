<?php
// FILE: process_request.php
session_start();

// =============================================================
// PERBAIKAN: Path include diperbaiki dengan menghapus garis miring di awal
// dan memastikan __DIR__ digunakan secara konsisten.
// =============================================================
include_once __DIR__ . '/includes/functions.php';
require_login('warga');
include_once __DIR__ . '/config/database.php';
include_once __DIR__ . '/config/whatsapp.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /sism-rt-rw/dashboard.php');
    exit();
}

// Logika Upload File
$dokumen_pendukung_filename = '';
$upload_ok = 1;
$message = '';

if (isset($_FILES['dokumen_pendukung']) && $_FILES['dokumen_pendukung']['error'] == 0) {
    $target_dir = __DIR__ . "/uploads/";
    $file_extension = strtolower(pathinfo($_FILES["dokumen_pendukung"]["name"], PATHINFO_EXTENSION));
    $dokumen_pendukung_filename = "doc_" . uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $dokumen_pendukung_filename;

    if ($_FILES["dokumen_pendukung"]["size"] > 2000000) {
        $message = "Maaf, ukuran file Anda terlalu besar (Maks 2MB).";
        $upload_ok = 0;
    }
    if(!in_array($file_extension, ["jpg", "png", "jpeg", "pdf"])) {
        $message = "Maaf, hanya format JPG, JPEG, PNG & PDF yang diizinkan.";
        $upload_ok = 0;
    }

    if ($upload_ok != 0) {
        if (!move_uploaded_file($_FILES["dokumen_pendukung"]["tmp_name"], $target_file)) {
            $message = "Maaf, terjadi kesalahan saat mengupload file Anda.";
            $upload_ok = 0;
        }
    }
} else {
    $message = "Anda wajib mengupload dokumen pendukung.";
    $upload_ok = 0;
}

if ($upload_ok) {
    $db = getDbConnection();
    $jenis_surat_table = $_POST['jenis_surat'];
    $_POST['dokumen_pendukung'] = $dokumen_pendukung_filename;
    
    // Logika Insert ke DB
    $columns = []; $params = []; $placeholders = []; $i = 1;
    $columns[] = '"user_id"';
    $params[] = $_SESSION['user_id'];
    $placeholders[] = '$' . $i++;
    foreach ($_POST as $key => $value) {
        if ($key === 'jenis_surat') continue;
        $columns[] = pg_escape_identifier($db, $key);
        $params[] = pg_escape_string($db, $value);
        $placeholders[] = '$' . $i++;
    }
    
    $cols_str = implode(', ', $columns);
    $placeholders_str = implode(", ", $placeholders);
    $query = "INSERT INTO \"$jenis_surat_table\" ($cols_str) VALUES ($placeholders_str)";
    $result = pg_query_params($db, $query, $params);

    if ($result) {
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Pengajuan surat berhasil dikirim!'];
        // Kirim WA Notif ke Admin
        // ... (logika kirim WA) ...
        header("Location: /sism-rt-rw/dashboard.php");
        exit();
    } else {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal menyimpan data ke database. Silakan coba lagi.'];
        header("Location: /sism-rt-rw/form_surat.php?type=" . urlencode($_POST['jenis_surat']));
        exit();
    }
} else {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => $message];
    header("Location: /sism-rt-rw/form_surat.php?type=" . urlencode($_POST['jenis_surat']));
    exit();
}
?>