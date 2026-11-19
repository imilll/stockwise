<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * config.php
 * File konfigurasi global dan konstanta sistem aplikasi inventaris.
 * Mengimplementasikan konsep konstanta (Slide 4: define / const)
 * untuk nilai-nilai immutable konfigurasi global.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

// Konfigurasi Penanganan Error (Environment Development)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Pengaturan Zona Waktu Server
date_default_timezone_set('Asia/Jakarta');

// Definisi Konstanta Konfigurasi Global Aplikasi
define('APP_NAME', 'STOCKWISE');
define('APP_TAGLINE', 'Product Inventory & Information System');
define('APP_VERSION', '1.0.0');
define('APP_CODENAME', 'Vanguard Release');
define('COMPANY_NAME', 'PT Tech Nusantara Distribusi');
define('COMPANY_TAGLINE', 'Distributor Resmi Komponen & Perangkat Teknologi Indonesia');
define('DEFAULT_CURRENCY', 'IDR');
define('CURRENCY_SYMBOL', 'Rp');

// Nilai Ambang Batas Logika Bisnis Stok (Business Rules Thresholds)
define('STOCK_OUT_THRESHOLD', 0);       // Stok 0 = Habis
define('STOCK_CRITICAL_THRESHOLD', 3);  // Stok < 3 = Kritis (Sesuai Aturan Perkuliahan)
define('STOCK_LOW_THRESHOLD', 5);       // Stok <= 5 = Menipis

// Format Penomoran dan Bahasa
define('APP_LOCALE', 'id_ID');
