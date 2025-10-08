<?php
// FILE: includes/header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Muat file fungsi agar require_login() tersedia di semua halaman view
include_once __DIR__ . '/functions.php'; 
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISM RT/RW</title>
    <link href="/sism-rt-rw/assets/css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="/sism-rt-rw/assets/images/logo-sism.png" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; }
        .badge-menunggu { background-color: #f59e0b; color: #fff; }
        .badge-disetujui, .badge-selesai { background-color: #16a34a; color: #fff; }
        .badge-diproses { background-color: #3b82f6; color: #fff; }
        .badge-ditolak { background-color: #ef4444; color: #fff; }
    </style>
</head>
<body class="h-full">
<div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="relative flex h-screen bg-gray-100">
    <!-- Background overlay untuk mobile saat sidebar terbuka -->
    <div x-show="sidebarOpen" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity md:hidden" @click="sidebarOpen = false"></div>
    
    <!-- Sidebar -->
    <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0">
        <div class="flex items-center justify-center h-20 shadow-md bg-gray-900">
             <h1 class="text-xl text-white font-poppins font-bold">Menu Navigasi</h1>
        </div>
        <nav class="flex-1 px-2 py-4 space-y-2">
            <!-- (Isi menu navigasi tetap sama seperti sebelumnya) -->
            <?php if (isset($_SESSION['level']) && $_SESSION['level'] == 'rt'): ?>
                <a href="/sism-rt-rw/dashboard.php" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md <?php echo $current_page == 'dashboard.php' ? 'bg-gray-900 text-white' : '' ?>">Dashboard</a>
                <a href="/sism-rt-rw/manage_users.php" class="flex items-center px-4 py-2 mt-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md <?php echo $current_page == 'manage_users.php' ? 'bg-gray-900 text-white' : '' ?>">Manajemen User</a>
            <?php elseif (isset($_SESSION['level']) && $_SESSION['level'] == 'warga'): ?>
                 <a href="/sism-rt-rw/dashboard.php" class="flex items-center px-4 py-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md <?php echo $current_page == 'dashboard.php' ? 'bg-gray-900 text-white' : '' ?>">Dashboard</a>
                 <a href="/sism-rt-rw/info_surat.php" class="flex items-center px-4 py-2 mt-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md <?php echo $current_page == 'info_surat.php' ? 'bg-gray-900 text-white' : '' ?>">Info Surat</a>
                 <a href="/sism-rt-rw/profil.php" class="flex items-center px-4 py-2 mt-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md <?php echo $current_page == 'profil.php' ? 'bg-gray-900 text-white' : '' ?>">Profil Saya</a>
            <?php endif; ?>
            <a href="/sism-rt-rw/logout.php" class="flex items-center px-4 py-2 mt-2 text-gray-300 hover:bg-gray-700 hover:text-white rounded-md">Logout</a>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Top Header -->
        <header class="flex justify-between items-center p-4 bg-white border-b-2 h-20">
            <div class="flex items-center">
                <!-- Tombol Buka/Tutup Sidebar untuk Mobile -->
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none md:hidden">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <div class="relative ml-4 flex items-center">
                    <img src="/sism-rt-rw/assets/images/logo-sism.png" alt="Logo SISM" style="height: 40px; width: auto;">
                    <span class="ml-3 text-xl font-bold text-gray-800 font-poppins">SISM RT/RW</span>
                </div>
            </div>
            <div class="hidden sm:flex items-center">
                 <h1 class="text-lg font-semibold text-gray-700">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama'] ?? 'Tamu'); ?>!</h1>
            </div>
        </header>
        
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100">
            <div class="container mx-auto px-4 sm:px-6 py-8">