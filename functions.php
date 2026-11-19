<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * functions.php
 * Processing Layer: Berisi kumpulan fungsi bisnis murni (Slide 9 & Slide 17)
 * untuk pengolahan kalkulasi data, agregasi statistik, penentuan status stok,
 * dan formatting output.
 * 
 * Menerapkan prinsip Single Responsibility Principle (SRP) dan Modular Programming.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

/**
 * A. Menghitung total nilai aset persediaan secara keseluruhan.
 * Rumus: Σ (harga produk × jumlah stok) untuk seluruh komoditas produk.
 * 
 * @param array $products Multidimensional associative array data produk.
 * @return float|int Total akumulasi nilai nominal persediaan barang.
 */
function hitungTotalNilaiStok($products) {
    $totalNilai = 0;
    
    // Traversal menggunakan foreach untuk menjumlahkan perkalian harga * stok
    foreach ($products as $item) {
        $harga = isset($item['harga']) ? (float)$item['harga'] : 0;
        $stok  = isset($item['stok']) ? (int)$item['stok'] : 0;
        
        $totalNilai += ($harga * $stok);
    }
    
    return $totalNilai;
}

/**
 * B. Menghitung jumlah seluruh varian produk yang terdaftar dalam katalog.
 * 
 * @param array $products Multidimensional associative array data produk.
 * @return int Total jenis produk.
 */
function hitungTotalProduk($products) {
    return count($products);
}

/**
 * C. Menghitung total keseluruhan kuantitas unit barang fisik yang tersedia di gudang.
 * 
 * @param array $products Multidimensional associative array data produk.
 * @return int Total akumulasi unit fisik stok barang.
 */
function hitungTotalStok($products) {
    $totalUnit = 0;
    
    foreach ($products as $item) {
        if (isset($item['stok'])) {
            $totalUnit += (int)$item['stok'];
        }
    }
    
    return $totalUnit;
}

/**
 * D. Menghitung jumlah produk yang berada dalam kondisi stok kritis.
 * Sesuai aturan akademik, stok kritis adalah produk dengan jumlah stok < 3.
 * 
 * @param array $products Multidimensional associative array data produk.
 * @return int Jumlah produk berstatus kritis (< 3 unit, di luar atau termasuk habis sesuai kebutuhan operasional).
 */
function hitungProdukKritis($products) {
    $jumlahKritis = 0;
    
    foreach ($products as $item) {
        $stok = isset($item['stok']) ? (int)$item['stok'] : 0;
        
        // PENTING: Logika stok kritis sesuai instruksi dosen adalah $stok < 3
        if ($stok < 3) {
            $jumlahKritis++;
        }
    }
    
    return $jumlahKritis;
}

/**
 * E. Menentukan label status ketersediaan stok produk berdasarkan aturan bisnis.
 * 
 * Aturan Evaluasi Bersyarat (if - elseif - else):
 * 1. Jika stok === 0          -> "Habis"
 * 2. Jika stok < 3           -> "Kritis"  (Instruksi khusus dosen)
 * 3. Jika stok <= 5          -> "Menipis"
 * 4. Selain itu (> 5)        -> "Aman"
 * 
 * @param int $stok Kuantitas persediaan produk yang dievaluasi.
 * @return string Label status persediaan ("Habis", "Kritis", "Menipis", "Aman").
 */
function tentukanStatusStok($stok) {
    $stok = (int)$stok;
    
    if ($stok === 0) {
        return "Habis";
    } elseif ($stok < 3) {
        return "Kritis";
    } elseif ($stok <= 5) {
        return "Menipis";
    } else {
        return "Aman";
    }
}

/**
 * F. Mengubah nilai angka nominal menjadi representasi format mata uang Rupiah Indonesia.
 * Contoh: 32500000 -> "Rp 32.500.000"
 * 
 * @param float|int $angka Nilai numerik yang akan diformat.
 * @return string String terformat standar mata uang Rupiah.
 */
function formatRupiah($angka) {
    $nilai = is_numeric($angka) ? (float)$angka : 0;
    return "Rp " . number_format($nilai, 0, ',', '.');
}

/**
 * HELPER: Mendapatkan CSS Class untuk badge status persediaan.
 * 
 * @param string $status Label status ketersediaan.
 * @return string Nama CSS class styling.
 */
function getStatusBadgeClass($status) {
    switch (strtolower(trim($status))) {
        case 'habis':
            return 'badge-habis';
        case 'kritis':
            return 'badge-kritis';
        case 'menipis':
            return 'badge-menipis';
        case 'aman':
        default:
            return 'badge-aman';
    }
}

/**
 * HELPER: Mendapatkan CSS Class untuk pewarnaan baris tabel (row highlight).
 * - Kritis (< 3): merah muda / merah lembut
 * - Menipis (3-5): kuning / oranye lembut
 * - Aman (> 5): hijau lembut
 * - Habis (0): merah dengan indikator khusus
 * 
 * @param int $stok Kuantitas persediaan.
 * @return string Nama CSS class baris tabel.
 */
function getRowHighlightClass($stok) {
    $stok = (int)$stok;
    
    if ($stok === 0) {
        return 'row-habis';
    } elseif ($stok < 3) {
        return 'row-kritis';
    } elseif ($stok <= 5) {
        return 'row-menipis';
    } else {
        return 'row-aman';
    }
}

/**
 * HELPER: Mengambil daftar kategori unik dari array produk.
 * 
 * @param array $products Multidimensional associative array.
 * @return array Array terindeks berisi nama kategori unik terurut alfabetis.
 */
function getKategoriList($products) {
    $kategori = [];
    foreach ($products as $item) {
        if (!empty($item['kategori']) && !in_array($item['kategori'], $kategori, true)) {
            $kategori[] = $item['kategori'];
        }
    }
    sort($kategori);
    return $kategori;
}

/**
 * HELPER: Menghitung agregasi statistik per kategori (jumlah item, total stok, total aset).
 * 
 * @param array $products Multidimensional associative array data produk.
 * @return array Associative array data ringkasan per kategori.
 */
function hitungStatistikKategori($products) {
    $stats = [];
    
    foreach ($products as $item) {
        $kat = $item['kategori'] ?? 'Lainnya';
        if (!isset($stats[$kat])) {
            $stats[$kat] = [
                'total_item'  => 0,
                'total_stok'  => 0,
                'total_nilai' => 0
            ];
        }
        $stats[$kat]['total_item'] += 1;
        $stats[$kat]['total_stok'] += (int)($item['stok'] ?? 0);
        $stats[$kat]['total_nilai'] += ((float)($item['harga'] ?? 0) * (int)($item['stok'] ?? 0));
    }
    
    return $stats;
}

/**
 * HELPER: Menghitung distribusi kuantitas produk berdasarkan status kesehatan stok.
 * 
 * @param array $products Multidimensional associative array.
 * @return array Associative array komposisi status stok.
 */
function hitungDistribusiStatus($products) {
    $distribusi = [
        'Habis'   => 0,
        'Kritis'  => 0,
        'Menipis' => 0,
        'Aman'    => 0
    ];
    
    foreach ($products as $item) {
        $status = tentukanStatusStok($item['stok'] ?? 0);
        if (isset($distribusi[$status])) {
            $distribusi[$status]++;
        }
    }
    
    return $distribusi;
}

/**
 * HELPER: Sanitasi string untuk proteksi terhadap celah XSS (Cross-Site Scripting).
 * Sesuai prinsip Slide 12 (Sanitasi String) dan best practices keamanan web.
 * 
 * @param mixed $data Data masukan yang akan disanitasi.
 * @return string String hasil sanitasi aman ditampilkan di browser.
 */
function sanitize($data) {
    return htmlspecialchars((string)$data, ENT_QUOTES, 'UTF-8');
}
