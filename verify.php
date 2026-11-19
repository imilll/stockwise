<?php
/**
 * STOCKWISE – Automated Verification & Health Check Script
 * 
 * Skrip pengujian otomatis untuk memvalidasi:
 * 1. Integritas modular require_once
 * 2. Ketepatan fungsi hitungTotalNilaiStok(), hitungTotalProduk(), hitungTotalStok(), hitungProdukKritis()
 * 3. Nilai ambang batas evaluasi status stok: 0, 1, 2, 3, 5, 6
 * 4. Kepatuhan syarat stok kritis ($stok < 3)
 * 5. Sanitasi keamanan htmlspecialchars()
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/functions.php';

echo "=========================================================\n";
echo "   STOCKWISE SYSTEM VERIFICATION & AUDIT SUITE\n";
echo "=========================================================\n\n";

$passCount = 0;
$failCount = 0;

function assertTest($description, $condition) {
    global $passCount, $failCount;
    if ($condition) {
        echo "[ PASS ] {$description}\n";
        $passCount++;
    } else {
        echo "[ FAIL ] {$description}\n";
        $failCount++;
    }
}

// 1. Uji Kelengkapan Array Produk
assertTest("Jumlah produk minimal 12 (terdapat " . count($products) . " produk)", count($products) >= 12);

// Periksa kelengkapan atribut setiap produk
$allKeysValid = true;
$requiredKeys = ['id', 'nama', 'kategori', 'harga', 'stok', 'deskripsi'];
foreach ($products as $p) {
    foreach ($requiredKeys as $k) {
        if (!array_key_exists($k, $p)) {
            $allKeysValid = false;
            break 2;
        }
    }
}
assertTest("Setiap produk memiliki atribut lengkap (id, nama, kategori, harga, stok, deskripsi)", $allKeysValid);

// 2. Uji Fungsi Agregasi
$totalProduk = hitungTotalProduk($products);
assertTest("hitungTotalProduk() mengembalikan nilai integer 16", $totalProduk === 16);

$totalStok = hitungTotalStok($products);
assertTest("hitungTotalStok() mengembalikan unit yang valid (> 0: {$totalStok} unit)", $totalStok > 0);

$totalNilai = hitungTotalNilaiStok($products);
$expectedNilai = 0.0;
foreach ($products as $p) {
    $expectedNilai += ((float)$p['harga'] * (int)$p['stok']);
}
assertTest("hitungTotalNilaiStok() akurat sesuai rumus (Rp " . number_format($totalNilai, 0, ',', '.') . ")", $totalNilai === $expectedNilai);

// 3. Uji Ambang Batas Logika Status Stok (0, 1, 2, 3, 5, 6)
assertTest("Stok 0 dievaluasi sebagai 'Habis'", tentukanStatusStok(0) === "Habis");
assertTest("Stok 1 dievaluasi sebagai 'Kritis' (< 3)", tentukanStatusStok(1) === "Kritis");
assertTest("Stok 2 dievaluasi sebagai 'Kritis' (< 3)", tentukanStatusStok(2) === "Kritis");
assertTest("Stok 3 dievaluasi sebagai 'Menipis' (<= 5)", tentukanStatusStok(3) === "Menipis");
assertTest("Stok 4 dievaluasi sebagai 'Menipis' (<= 5)", tentukanStatusStok(4) === "Menipis");
assertTest("Stok 5 dievaluasi sebagai 'Menipis' (<= 5)", tentukanStatusStok(5) === "Menipis");
assertTest("Stok 6 dievaluasi sebagai 'Aman' (> 5)", tentukanStatusStok(6) === "Aman");
assertTest("Stok 15 dievaluasi sebagai 'Aman' (> 5)", tentukanStatusStok(15) === "Aman");

// 4. Uji Syarat Khusus Dosen: Logika Stok Kritis ($stok < 3)
$totalKritisExpected = 0;
foreach ($products as $p) {
    if ($p['stok'] < 3) {
        $totalKritisExpected++;
    }
}
$totalKritisActual = hitungProdukKritis($products);
assertTest("hitungProdukKritis() mendeteksi produk dengan stok < 3 ({$totalKritisActual} produk)", $totalKritisActual === $totalKritisExpected);

// 5. Uji Fungsi Format Rupiah
assertTest("formatRupiah(1000000) menghasilkan 'Rp 1.000.000'", formatRupiah(1000000) === "Rp 1.000.000");
assertTest("formatRupiah(0) menghasilkan 'Rp 0'", formatRupiah(0) === "Rp 0");

// 6. Uji Sanitasi XSS
$dirtyString = "<script>alert('xss')</script>";
assertTest("sanitize() mengenkapsulasi tag HTML berbahaya", sanitize($dirtyString) === "&lt;script&gt;alert(&#039;xss&#039;)&lt;/script&gt;");

echo "\n---------------------------------------------------------\n";
echo "HASIL AKHIR: {$passCount} Passed, {$failCount} Failed\n";
echo "=========================================================\n";

if ($failCount === 0) {
    exit(0);
} else {
    exit(1);
}
