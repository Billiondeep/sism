<?php
// FILE: buat_hash.php
// Alat sederhana untuk membuat hash password yang kompatibel dengan server Anda.

// Masukkan password yang ingin Anda hash di sini
$password_untuk_dihash = 'pakrt12345';

// Membuat hash menggunakan algoritma default yang aman
$hash_hasil = password_hash($password_untuk_dihash, PASSWORD_DEFAULT);

// Tampilkan hasilnya di layar agar bisa kita salin
echo '<h1>Alat Pembuat Hash Password</h1>';
echo '<p>Password yang di-hash: <strong>' . htmlspecialchars($password_untuk_dihash) . '</strong></p>';
echo '<p>Salin (copy) seluruh kode hash di bawah ini:</p>';
echo '<hr>';
echo '<pre style="background:#f0f0f0; padding:15px; font-size:16px; word-wrap:break-word;">';
echo '<strong>' . $hash_hasil . '</strong>';
echo '</pre>';
echo '<hr>';

?>