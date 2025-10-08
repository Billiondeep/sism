<?php

if (!function_exists('require_login')) {
    /**
     * Memastikan pengguna sudah login sebelum mengakses halaman.
     * Jika tidak, pengguna akan diarahkan ke halaman login.
     * @param string|null $level 
     */
    function require_login($level = null) {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /sism-rt-rw/login.php');
            exit();
        }
        if ($level && (!isset($_SESSION['level']) || $_SESSION['level'] !== $level)) {
            // Jika level yang dibutuhkan tidak sesuai, arahkan ke dashboard utama.
            header('Location: /sism-rt-rw/dashboard.php?error=access_denied');
            exit();
        }
    }
}
