<?php
// FILE: resend_wa.php

include_once __DIR__ . '/includes/header.php';
require_login('rt');
include_once __DIR__ . '/config/database.php';
include_once __DIR__ . '/config/whatsapp.php';

$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

$allowed_tables = [
    'surat_pengantar', 'surat_sktm', 'surat_domisili', 'surat_usaha',
    'surat_penghasilan', 'surat_kelahiran_kematian'
];

if (!in_array($type, $allowed_tables) || $id <= 0) {
    die("Permintaan tidak valid.");
}

$db = getDbConnection();
$query = "SELECT * FROM \"$type\" WHERE id = $1";
$result = pg_query_params($db, $query, array($id));
if (!$result) die("Query gagal.");

$data = pg_fetch_assoc($result);
if (!$data) die("Data pengajuan tidak ditemukan.");

// Pastikan hanya surat yang sudah selesai yang bisa dikirim ulang
if ($data['status'] !== 'Selesai') {
    die("Hanya surat yang berstatus 'Selesai' yang bisa dikirim ulang.");
}

// Ambil data yang dibutuhkan untuk pesan
$telp = $data['telp'];
$nama = $data['nama'] ?? $data['nama_lengkap'];

// Siapkan pesan dan URL PDF
$pdf_url = "http://" . $_SERVER['HTTP_HOST'] . "/sism-rt-rw/generate_pdf.php?type={$type}&id={$id}";
$pesan_warga = "SISM Notifikasi (KIRIM ULANG):\n\nYth. Sdr/i *{$nama}*,\n\nBerikut kami kirimkan kembali salinan surat Anda yang telah disetujui.\n\nAnda dapat mengunduh surat melalui tautan berikut atau dari lampiran di pesan ini.\n\n{$pdf_url}\n\nTerima kasih.";

// Kirim pesan
$kirim_wa = sendWhatsAppMessage($telp, $pesan_warga, $pdf_url);

// Arahkan kembali ke halaman detail dengan notifikasi sukses
header("Location: /sism-rt-rw/view_request.php?type={$type}&id={$id}&status=resent");
exit();
?>