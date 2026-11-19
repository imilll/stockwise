<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * includes/header.php
 * Komponen layout header dan topbar aplikasi.
 * Memuat metadata HTML5, Google Fonts, stylesheet internal, dan top navigation bar.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

// Pastikan file config telah termuat
if (!defined('APP_NAME')) {
    require_once __DIR__ . '/../config.php';
}

// Format tanggal hari ini dalam Bahasa Indonesia
$namaHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$namaBulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

$hariIni = $namaHari[date('w')];
$tgl = date('j');
$bln = $namaBulan[(int)date('n')];
$thn = date('Y');
$tanggalTerformat = "{$hariIni}, {$tgl} {$bln} {$thn}";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo sanitize(APP_NAME . ' – ' . APP_TAGLINE); ?> | Sistem Manajemen Inventaris Berbasis PHP Native">
    <meta name="author" content="Mahasiswa Sistem Informasi">
    <title><?php echo sanitize(APP_NAME . ' – ' . APP_TAGLINE); ?></title>

    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Stylesheet Utama -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="app-layout">
        <!-- Sidebar Navigation Component -->
        <?php include_once __DIR__ . '/sidebar.php'; ?>

        <!-- Main Wrapper Content -->
        <div class="main-wrapper">
            <!-- Topbar Header -->
            <header class="topbar">
                <div class="topbar-left">
                    <button type="button" class="sidebar-toggle" id="sidebarToggle" aria-label="Buka/Tutup Sidebar">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="breadcrumbs">
                        <span class="crumb-root"><?php echo sanitize(APP_NAME); ?></span>
                        <span class="crumb-separator">/</span>
                        <span class="crumb-current">Enterprise Dashboard</span>
                    </div>
                </div>

                <div class="topbar-right">
                    <!-- Tanggal Real-Time Server -->
                    <div class="date-badge">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span><?php echo $tanggalTerformat; ?></span>
                    </div>

                    <!-- User Profile Pill -->
                    <div class="user-profile-pill">
                        <div class="avatar-circle">AD</div>
                        <div class="user-meta">
                            <span class="user-name">Inventory Admin</span>
                            <span class="user-role"><?php echo sanitize(COMPANY_NAME); ?></span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Container -->
            <main class="content-body">
