<?php
// FILE: generate_pdf.php

// Aktifkan error reporting untuk debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/lib/fpdf/fpdf.php';

$db = getDbConnection();
$type = $_GET['type'] ?? '';
$id = (int)($_GET['id'] ?? 0);

$pdf_map = [
    'surat_pengantar'          => 'SuratPengantarPdf',
    'surat_sktm'               => 'SuratSktmPdf',
    'surat_domisili'           => 'SuratDomisiliPdf',
    'surat_usaha'              => 'SuratUsahaPdf',
    'surat_penghasilan'        => 'SuratPenghasilanPdf',
    'surat_kelahiran_kematian' => 'SuratKelahiranKematianPdf'
];

if (!array_key_exists($type, $pdf_map)) {
    die("Tipe surat tidak valid untuk pembuatan PDF.");
}

$query = "SELECT * FROM \"$type\" WHERE id = $1";
$result = pg_query_params($db, $query, array($id));
if (!$result) die("Query untuk mengambil data surat gagal.");

$data = pg_fetch_assoc($result);
if (!$data) die("Data pengajuan tidak ditemukan.");

if ($_SESSION['level'] !== 'rt' && $_SESSION['user_id'] != $data['user_id']) {
    die("Anda tidak memiliki hak untuk mengakses dokumen ini.");
}

$pdf_template_class = $pdf_map[$type];
$pdf_template_file = __DIR__ . "/pdf_templates/{$pdf_template_class}.php";

if (!file_exists($pdf_template_file)) {
    die("Error Kritis: File template PDF <code>{$pdf_template_file}</code> tidak ditemukan.");
}

require_once __DIR__ . '/pdf_templates/BasePdf.php';
require_once $pdf_template_file;

if (!class_exists($pdf_template_class)) {
    die("Error Kritis: Kelas <code>{$pdf_template_class}</code> tidak ditemukan di dalam file template.");
}

$pdf = new $pdf_template_class();
$pdf->generate($data);
?>