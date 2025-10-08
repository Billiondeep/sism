<?php
// FILE: update_profil.php
session_start();

// Muat fungsi yang diperlukan, BUKAN seluruh header.php
include_once __DIR__ . '/includes/functions.php';
require_login('warga');
include_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = getDbConnection();
    $user_id = $_SESSION['user_id'];
    $nama = pg_escape_string($db, $_POST['nama']);
    $telp = pg_escape_string($db, $_POST['telp']);

    $query = 'UPDATE "user" SET nama = $1, telp = $2 WHERE id = $3';
    $result = pg_query_params($db, $query, array($nama, $telp, $user_id));

    if ($result) {
        // Perbarui juga session agar nama di header ikut berubah
        $_SESSION['nama'] = $_POST['nama'];
        $_SESSION['telp'] = $_POST['telp'];
        
        // Simpan pesan sukses ke session, BUKAN menampilkannya
        $_SESSION['flash_message'] = ['type' => 'success', 'message' => 'Profil berhasil diperbarui!'];
        
        // Arahkan pengguna kembali ke halaman profil
        header('Location: profil.php');
        exit();
    } else {
        // Jika gagal, simpan pesan error dan arahkan kembali
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Gagal memperbarui profil: ' . pg_last_error($db)];
        header('Location: edit_profil.php');
        exit();
    }
}
?>