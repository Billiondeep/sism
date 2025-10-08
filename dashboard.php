<?php
// FILE: dashboard.php

define('SISM_EXEC', true);

// Langkah 1: Memuat seluruh layout (header + sidebar + pembuka konten)
include_once __DIR__ . '/includes/header.php';

// Langkah 2: Logika dan konten spesifik untuk halaman ini
require_login();
if ($_SESSION['level'] == 'rt') {
    include_once __DIR__ . '/views/admin_dashboard.php';
} else {
    include_once __DIR__ . '/views/warga_dashboard.php';
}

// Langkah 3: Memuat penutup layout
include_once __DIR__ . '/includes/footer.php';
?>