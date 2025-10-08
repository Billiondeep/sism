<?php
// FILE: update_status.php

// KESALAHAN UTAMA DIHAPUS: Baris 'include header.php' dihilangkan dari sini.
// Logika dimulai langsung dengan session dan proses PHP.

// Mulai sesi jika belum ada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Panggil semua file konfigurasi dan fungsi yang dibutuhkan
require_once __DIR__ . '/config/functions.php'; // Asumsi fungsi require_login ada di sini
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/whatsapp.php';

// Cek hak akses
require_login('rt');

// Pastikan request adalah POST, jika tidak, tendang ke dashboard
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /sism-rt-rw/dashboard.php');
    exit();
}

// --- Semua Logika Pemrosesan ---
$db = getDbConnection();
$type = $_POST['type'];
$id = (int)$_POST['id'];
$new_status = $_POST['status'];
$telp = $_POST['telp'];
$nama = $_POST['nama'];
$catatan_penolakan = $_POST['catatan_penolakan'] ?? '';

// Validasi tabel yang diizinkan
$allowed_tables = ['surat_pengantar', 'surat_sktm', 'surat_domisili', 'surat_usaha', 'surat_penghasilan', 'surat_kelahiran_kematian'];
if (!in_array($type, $allowed_tables) || $id <= 0) {
    die("Permintaan tidak valid.");
}

// Validasi jika statusnya 'Ditolak' tapi catatan kosong
if ($new_status === 'Ditolak' && empty(trim($catatan_penolakan))) {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Catatan penolakan wajib diisi jika status Ditolak.'];
    header("Location: /sism-rt-rw/view_request.php?type={$type}&id={$id}");
    exit();
}

// Siapkan query berdasarkan status baru
if ($new_status === 'Ditolak') {
    $update_query = "UPDATE \"$type\" SET status = $1, catatan_penolakan = $2 WHERE id = $3";
    $params = [$new_status, $catatan_penolakan, $id];
} else {
    if ($new_status === 'Selesai') {
        $token = md5(uniqid($nama, true) . time());
        $update_query = "UPDATE \"$type\" SET status = $1, verification_token = $2 WHERE id = $3";
        $params = [$new_status, $token, $id];
    } else { // Jika statusnya 'Diproses'
        $update_query = "UPDATE \"$type\" SET status = $1 WHERE id = $2";
        $params = [$new_status, $id];
    }
}

// Eksekusi query
$result = pg_query_params($db, $update_query, $params);

// Redirect berdasarkan hasil query
if ($result) {
    $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Status pengajuan berhasil diperbarui.'];
    
    // Logika kirim WA tetap di sini jika diperlukan...
    // contoh: kirim_wa($telp, "Status surat Anda telah diperbarui menjadi: " . $new_status);
    
    header("Location: /sism-rt-rw/view_request.php?type={$type}&id={$id}");
    exit();
} else {
    $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal memperbarui status di database.'];
    header("Location: /sism-rt-rw/view_request.php?type={$type}&id={$id}");
    exit();
}
?>