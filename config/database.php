<?php
// FILE: config/database.php
function getDbConnection() {
    $host = 'localhost';
    $port = '5432';
    $dbname = 'sism_db';    
    $user = 'postgres';     
    $password = '123';  

    $conn_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password}";
    
    $db = pg_connect($conn_string);
    
    if (!$db) {
        error_log("Database connection failed: " . pg_last_error());
        die("Tidak dapat terhubung ke server. Silakan coba beberapa saat lagi.");
    }
    
    return $db;
}
?>