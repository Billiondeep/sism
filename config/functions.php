<?php
// FILE: config/functions.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * 
 * 
 *
 * @param string|null $required_level
 */
function require_login($required_level = null) {
    // Cek apakah pengguna sudah login
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Anda harus login untuk mengakses halaman ini.'];
        header('Location: /sism-rt-rw/login.php');
        exit();
    }

    // Cek apakah ada level yang disyaratkan
    if ($required_level !== null) {
        // Cek apakah pengguna memiliki level yang sesuai
        if (!isset($_SESSION['level']) || $_SESSION['level'] !== $required_level) {
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Anda tidak memiliki hak akses untuk halaman ini.'];
            // Arahkan ke dashboard atau halaman utama jika sudah login tapi level tidak cocok
            header('Location: /sism-rt-rw/dashboard.php');
            exit();
        }
    }
}

?>