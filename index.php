<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * index.php
 * Presentation Layer: Titik masuk utama aplikasi (Main Entry Point).
 * Mengintegrasikan konfigurasi, data array, dan fungsi bisnis secara modular
 * menggunakan require_once (Slide 13-14 & Slide 17).
 * 
 * Melakukan traversal multidimensional associative array via perulangan foreach
 * untuk merender dashboard analitik dan tabel inventaris responsif.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

// Memuat komponen backend secara modular
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/products.php';
require_once __DIR__ . '/functions.php';

// Eksekusi kalkulasi statistik inventaris melalui Processing Layer
$totalProduk      = hitungTotalProduk($products);
$totalUnitStok    = hitungTotalStok($products);
$totalNilaiAset   = hitungTotalNilaiStok($products);
$totalNilaiFmt    = formatRupiah($totalNilaiAset);
$totalKritis      = hitungProdukKritis($products);

// Analisis distribusi dan statistik per kategori
$distribusiStatus = hitungDistribusiStatus($products);
$statistikKategori = hitungStatistikKategori($products);
$daftarKategori   = getKategoriList($products);

// Memuat Header Layout
include_once __DIR__ . '/includes/header.php';
?>

<!-- Section: Dashboard Hero Header -->
<section class="dashboard-hero" id="dashboard">
    <div class="hero-text-wrap">
        <div class="hero-badge-tag">
            <span class="tag-dot"></span>
            <span>Sistem Pemantauan Gudang Real-Time</span>
        </div>
        <h1 class="hero-title">Ringkasan Inventaris & Katalog Produk</h1>
        <p class="hero-subtitle">
            Selamat datang di <strong><?php echo sanitize(APP_NAME); ?></strong>. Kelola katalog barang komoditas teknologi, pantau rotasi stok gudang, dan pantau valuasi aset persediaan secara efisien dan akurat.
        </p>
    </div>

    <!-- Quick Action Tool Buttons -->
    <div class="hero-actions">
        <button type="button" class="btn btn-outline" id="btnPrintReport">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                <rect x="6" y="14" width="12" height="8"></rect>
            </svg>
            <span>Cetak Lembar Laporan</span>
        </button>
        <button type="button" class="btn btn-primary" id="btnExportCsv">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
            </svg>
            <span>Ekspor Data ke CSV</span>
        </button>
    </div>
</section>

<!-- Section: Critical Stock Warning Banner (Hanya muncul jika terdapat stok < 3) -->
<?php if ($totalKritis > 0): ?>
<section class="alert-banner alert-critical-pulse" role="alert">
    <div class="alert-icon-box">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="8" x2="12" y2="12"></line>
            <line x1="12" y1="16" x2="12.01" y2="16"></line>
        </svg>
    </div>
    <div class="alert-content">
        <h4 class="alert-heading">Peringatan Kritis: <?php echo $totalKritis; ?> Komoditas Memerlukan Restock Segera!</h4>
        <p class="alert-message">
            Terdeteksi <strong><?php echo $totalKritis; ?> produk</strong> dengan jumlah stok berada di bawah batas ambang batas aman (&lt; 3 unit atau habis). Segera lakukan pemesanan ulang (Purchase Order) ke vendor distributor untuk mencegah kekosongan suplai penjualan.
        </p>
    </div>
    <div class="alert-action">
        <a href="#monitoring" class="btn btn-sm btn-alert">Lihat Daftar Kritis</a>
    </div>
</section>
<?php endif; ?>

<!-- Section: Summary KPI Statistic Cards -->
<section class="stats-grid">
    <!-- Card 1: Total Produk -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Varian Produk</span>
            <div class="stat-icon-wrapper icon-blue">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                </svg>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-value"><?php echo number_format($totalProduk, 0, ',', '.'); ?></div>
            <div class="stat-meta">
                <span class="badge-sub badge-neutral"><?php echo count($daftarKategori); ?> Kategori</span>
                <span class="stat-meta-text">Tercatat aktif dalam katalog</span>
            </div>
        </div>
    </div>

    <!-- Card 2: Total Unit Stok Fisik -->
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Kuantitas Fisik</span>
            <div class="stat-icon-wrapper icon-emerald">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                </svg>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-value"><?php echo number_format($totalUnitStok, 0, ',', '.'); ?> <span class="stat-unit">Unit</span></div>
            <div class="stat-meta">
                <span class="badge-sub badge-emerald">Persediaan Gudang</span>
                <span class="stat-meta-text">Siap didistribusikan</span>
            </div>
        </div>
    </div>

    <!-- Card 3: Total Nilai Aset Persediaan -->
    <div class="stat-card stat-card-featured">
        <div class="stat-header">
            <span class="stat-label">Total Valuasi Aset Stok</span>
            <div class="stat-icon-wrapper icon-purple">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-value stat-value-lg"><?php echo $totalNilaiFmt; ?></div>
            <div class="stat-meta">
                <span class="badge-sub badge-purple">Σ (Harga × Stok)</span>
                <span class="stat-meta-text">Akumulasi nilai buku inventaris</span>
            </div>
        </div>
    </div>

    <!-- Card 4: Produk Stok Kritis (< 3) -->
    <div class="stat-card <?php echo ($totalKritis > 0) ? 'stat-card-warning' : ''; ?>">
        <div class="stat-header">
            <span class="stat-label">Produk Stok Kritis</span>
            <div class="stat-icon-wrapper icon-rose">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                </svg>
            </div>
        </div>
        <div class="stat-body">
            <div class="stat-value text-rose"><?php echo number_format($totalKritis, 0, ',', '.'); ?> <span class="stat-unit">SKU</span></div>
            <div class="stat-meta">
                <span class="badge-sub badge-rose">Stok &lt; 3 Unit</span>
                <span class="stat-meta-text">Memerlukan PO pengadaan</span>
            </div>
        </div>
    </div>
</section>

<!-- Section: Inventory Visual Overview (Health Distribution & Category Breakdown) -->
<section class="overview-grid" id="analisis">
    <!-- Panel 1: Visualisasi Distribusi Kesehatan Stok -->
    <div class="overview-card">
        <div class="card-header">
            <div class="card-title-group">
                <h3 class="card-title">Kondisi Kesehatan Persediaan</h3>
                <p class="card-sub">Distribusi status stok barang berdasarkan klasifikasi aturan perkuliahan</p>
            </div>
            <span class="pill-meta"><?php echo $totalProduk; ?> Total SKU</span>
        </div>
        <div class="card-body">
            <!-- Multi-color Segmented Progress Bar -->
            <?php
                $pctAman    = $totalProduk > 0 ? round(($distribusiStatus['Aman'] / $totalProduk) * 100, 1) : 0;
                $pctMenipis = $totalProduk > 0 ? round(($distribusiStatus['Menipis'] / $totalProduk) * 100, 1) : 0;
                $pctKritis  = $totalProduk > 0 ? round(($distribusiStatus['Kritis'] / $totalProduk) * 100, 1) : 0;
                $pctHabis   = $totalProduk > 0 ? round(($distribusiStatus['Habis'] / $totalProduk) * 100, 1) : 0;
            ?>
            <div class="segmented-progress-bar" title="Distribusi Status Stok">
                <div class="bar-segment seg-aman" style="width: <?php echo $pctAman; ?>%;" title="Aman: <?php echo $pctAman; ?>%"></div>
                <div class="bar-segment seg-menipis" style="width: <?php echo $pctMenipis; ?>%;" title="Menipis: <?php echo $pctMenipis; ?>%"></div>
                <div class="bar-segment seg-kritis" style="width: <?php echo $pctKritis; ?>%;" title="Kritis: <?php echo $pctKritis; ?>%"></div>
                <div class="bar-segment seg-habis" style="width: <?php echo $pctHabis; ?>%;" title="Habis: <?php echo $pctHabis; ?>%"></div>
            </div>

            <!-- Detail Breakdown Badges -->
            <div class="status-legend-grid">
                <div class="legend-item">
                    <div class="legend-header">
                        <span class="legend-dot dot-aman"></span>
                        <span class="legend-title">Aman (&gt; 5 Unit)</span>
                    </div>
                    <div class="legend-value"><?php echo $distribusiStatus['Aman']; ?> <small>SKU (<?php echo $pctAman; ?>%)</small></div>
                </div>

                <div class="legend-item">
                    <div class="legend-header">
                        <span class="legend-dot dot-menipis"></span>
                        <span class="legend-title">Menipis (3–5 Unit)</span>
                    </div>
                    <div class="legend-value"><?php echo $distribusiStatus['Menipis']; ?> <small>SKU (<?php echo $pctMenipis; ?>%)</small></div>
                </div>

                <div class="legend-item">
                    <div class="legend-header">
                        <span class="legend-dot dot-kritis"></span>
                        <span class="legend-title">Kritis (&lt; 3 Unit)</span>
                    </div>
                    <div class="legend-value"><?php echo $distribusiStatus['Kritis']; ?> <small>SKU (<?php echo $pctKritis; ?>%)</small></div>
                </div>

                <div class="legend-item">
                    <div class="legend-header">
                        <span class="legend-dot dot-habis"></span>
                        <span class="legend-title">Habis (0 Unit)</span>
                    </div>
                    <div class="legend-value"><?php echo $distribusiStatus['Habis']; ?> <small>SKU (<?php echo $pctHabis; ?>%)</small></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel 2: Distribusi Nilai dan Unit per Kategori Komoditas -->
    <div class="overview-card">
        <div class="card-header">
            <div class="card-title-group">
                <h3 class="card-title">Ringkasan Komoditas per Kategori</h3>
                <p class="card-sub">Akumulasi kuantitas dan total nilai aset berdasarkan rumpun produk</p>
            </div>
            <span class="pill-meta"><?php echo count($statistikKategori); ?> Rumpun</span>
        </div>
        <div class="card-body">
            <div class="category-bars-list">
                <?php foreach ($statistikKategori as $katNama => $katData): 
                    $pctCategoryVal = $totalNilaiAset > 0 ? round(($katData['total_nilai'] / $totalNilaiAset) * 100, 1) : 0;
                ?>
                <div class="category-item-row">
                    <div class="cat-row-top">
                        <div class="cat-name-wrap">
                            <span class="cat-name"><?php echo sanitize($katNama); ?></span>
                            <span class="cat-badge-item"><?php echo $katData['total_item']; ?> SKU &bull; <?php echo $katData['total_stok']; ?> Unit</span>
                        </div>
                        <div class="cat-val-wrap">
                            <span class="cat-val-fmt"><?php echo formatRupiah($katData['total_nilai']); ?></span>
                            <span class="cat-pct-label"><?php echo $pctCategoryVal; ?>%</span>
                        </div>
                    </div>
                    <div class="cat-progress-bg">
                        <div class="cat-progress-fill" style="width: <?php echo $pctCategoryVal; ?>%;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Section: Main Product Management Table (Presentation Layer Traversal) -->
<section class="catalog-section" id="katalog">
    <div class="section-card">
        <!-- Table Toolbar & Filters -->
        <div class="table-toolbar">
            <div class="toolbar-title-wrap">
                <div class="toolbar-badge">Data Layer Traversal (foreach)</div>
                <h2 class="table-main-title">Katalog & Manajemen Persediaan Barang</h2>
                <p class="table-main-sub">
                    Pemrosesan data server-side PHP menggunakan associative array multidimensi dengan sanitasi data XSS.
                </p>
            </div>

            <!-- Dynamic Filter Controls -->
            <div class="filter-controls">
                <!-- Search Input -->
                <div class="search-input-group">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari nama perangkat, ID, atau spesifikasi..." autocomplete="off">
                    <button type="button" id="clearSearchBtn" class="clear-btn" title="Hapus pencarian">&times;</button>
                </div>

                <!-- Category Dropdown Filter -->
                <div class="select-group">
                    <label for="filterCategory" class="sr-only">Filter Kategori</label>
                    <select id="filterCategory" class="form-select">
                        <option value="all">Semua Kategori (<?php echo count($products); ?>)</option>
                        <?php foreach ($daftarKategori as $katOption): ?>
                            <option value="<?php echo sanitize($katOption); ?>">
                                <?php echo sanitize($katOption); ?> (<?php echo $statistikKategori[$katOption]['total_item']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Stock Status Dropdown Filter -->
                <div class="select-group">
                    <label for="filterStatus" class="sr-only">Filter Status</label>
                    <select id="filterStatus" class="form-select">
                        <option value="all">Semua Status Stok</option>
                        <option value="Aman">Stok Aman (&gt; 5 Unit)</option>
                        <option value="Menipis">Stok Menipis (3–5 Unit)</option>
                        <option value="Kritis">Stok Kritis (&lt; 3 Unit)</option>
                        <option value="Habis">Stok Habis (0 Unit)</option>
                    </select>
                </div>

                <!-- Sort By Dropdown -->
                <div class="select-group">
                    <label for="sortBy" class="sr-only">Urutkan Data</label>
                    <select id="sortBy" class="form-select">
                        <option value="id_asc">Urutan: Default (ID Produk)</option>
                        <option value="nama_asc">Nama Produk (A &rarr; Z)</option>
                        <option value="nama_desc">Nama Produk (Z &rarr; A)</option>
                        <option value="harga_desc">Harga (Tertinggi &rarr; Terendah)</option>
                        <option value="harga_asc">Harga (Terendah &rarr; Tertinggi)</option>
                        <option value="stok_desc">Stok (Terbanyak &rarr; Sedikit)</option>
                        <option value="stok_asc">Stok (Tersedikit &rarr; Terbanyak)</option>
                    </select>
                </div>

                <!-- Reset Filters Button -->
                <button type="button" class="btn btn-secondary" id="btnResetFilters" title="Kembalikan semua filter ke kondisi awal">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1 4 1 10 7 10"></polyline>
                        <polyline points="23 20 23 14 17 14"></polyline>
                        <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                    </svg>
                    <span>Reset Filter</span>
                </button>
            </div>
        </div>

        <!-- Responsive Table Container -->
        <div class="table-responsive">
            <table class="inventory-table" id="inventoryTable">
                <thead>
                    <tr>
                        <th class="th-id" data-sort="id">ID Produk</th>
                        <th class="th-name" data-sort="nama">Nama Produk</th>
                        <th class="th-cat" data-sort="kategori">Kategori</th>
                        <th class="th-price text-right" data-sort="harga">Harga</th>
                        <th class="th-stock text-center" data-sort="stok">Stok</th>
                        <th class="th-status text-center">Status</th>
                        <th class="th-desc">Deskripsi</th>
                        <th class="th-action text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php 
                    // TRAVERSAL MULTIDIMENSIONAL ARRAY MENGGUNAKAN FOREACH (Slide 8, 11, 17)
                    foreach ($products as $item): 
                        // Sanitasi dan ekstraksi nilai data
                        $id        = sanitize($item['id']);
                        $nama      = sanitize($item['nama']);
                        $kategori  = sanitize($item['kategori']);
                        $hargaRaw  = (float)($item['harga'] ?? 0);
                        $stokRaw   = (int)($item['stok'] ?? 0);
                        $deskripsi = sanitize($item['deskripsi']);

                        // Evaluasi status stok menggunakan fungsi PHP dari functions.php
                        $statusText   = tentukanStatusStok($stokRaw);
                        $badgeClass   = getStatusBadgeClass($statusText);
                        $rowHighlight = getRowHighlightClass($stokRaw);
                        $hargaFormatted = formatRupiah($hargaRaw);
                        $totalAssetPerProduk = formatRupiah($hargaRaw * $stokRaw);
                    ?>
                    <tr class="table-row <?php echo $rowHighlight; ?>" 
                        data-id="<?php echo $id; ?>"
                        data-nama="<?php echo strtolower($nama); ?>"
                        data-kategori="<?php echo $kategori; ?>"
                        data-status="<?php echo $statusText; ?>"
                        data-harga="<?php echo $hargaRaw; ?>"
                        data-stok="<?php echo $stokRaw; ?>"
                        data-desc="<?php echo $deskripsi; ?>"
                        data-asset="<?php echo $totalAssetPerProduk; ?>">
                        
                        <!-- Kolom 1: ID Produk -->
                        <td class="td-id">
                            <span class="sku-badge"><?php echo $id; ?></span>
                        </td>

                        <!-- Kolom 2: Nama Produk -->
                        <td class="td-name">
                            <div class="product-name-main"><?php echo $nama; ?></div>
                        </td>

                        <!-- Kolom 3: Kategori -->
                        <td class="td-cat">
                            <span class="category-pill"><?php echo $kategori; ?></span>
                        </td>

                        <!-- Kolom 4: Harga -->
                        <td class="td-price text-right">
                            <span class="price-value"><?php echo $hargaFormatted; ?></span>
                        </td>

                        <!-- Kolom 5: Stok -->
                        <td class="td-stock text-center">
                            <div class="stock-display-wrap">
                                <span class="stock-number"><?php echo $stokRaw; ?></span>
                                <span class="stock-label-unit">unit</span>
                            </div>
                        </td>

                        <!-- Kolom 6: Status (Badge dengan indikator warna) -->
                        <td class="td-status text-center">
                            <span class="status-badge <?php echo $badgeClass; ?>">
                                <span class="status-dot"></span>
                                <?php echo $statusText; ?>
                            </span>
                        </td>

                        <!-- Kolom 7: Deskripsi -->
                        <td class="td-desc">
                            <p class="desc-clamp" title="<?php echo $deskripsi; ?>">
                                <?php echo $deskripsi; ?>
                            </p>
                        </td>

                        <!-- Kolom 8: Aksi Interaktif (Quick Detail Modal) -->
                        <td class="td-action text-center">
                            <button type="button" class="btn-action-view btn-view-detail" 
                                    data-id="<?php echo $id; ?>" 
                                    title="Lihat Detail Lengkap <?php echo $nama; ?>">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                                <span>Detail</span>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Empty State Container jika pencarian tidak membuahkan hasil -->
            <div class="empty-state" id="emptyState" style="display: none;">
                <div class="empty-icon-wrap">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        <line x1="8" y1="11" x2="14" y2="11"></line>
                    </svg>
                </div>
                <h3 class="empty-title">Tidak Ada Produk yang Cocok</h3>
                <p class="empty-sub">
                    Kata kunci pencarian atau kombinasi filter kategori dan status tidak menemukan hasil. Silakan periksa kembali atau reset filter Anda.
                </p>
                <button type="button" class="btn btn-outline" id="btnEmptyReset">
                    <span>Kembalikan Semua Produk</span>
                </button>
            </div>
        </div>

        <!-- Table Summary Footer -->
        <div class="table-footer-bar">
            <div class="table-counter">
                Menampilkan <strong id="visibleCount"><?php echo $totalProduk; ?></strong> dari <strong><?php echo $totalProduk; ?></strong> komoditas terdaftar
            </div>
            <div class="table-color-legend">
                <span class="legend-note-label">Keterangan Baris:</span>
                <span class="row-indicator ind-aman">Aman (&gt; 5)</span>
                <span class="row-indicator ind-menipis">Menipis (3–5)</span>
                <span class="row-indicator ind-kritis">Kritis (&lt; 3)</span>
                <span class="row-indicator ind-habis">Habis (0)</span>
            </div>
        </div>
    </div>
</section>

<!-- Section: Stock Monitoring & Quick Restock Table -->
<section class="monitoring-section" id="monitoring">
    <div class="section-card">
        <div class="monitoring-header">
            <div class="mon-title-wrap">
                <span class="section-tag-red">Logistik Gudang</span>
                <h3 class="section-h3">Monitoring Persediaan Kritis & Tindakan Restock</h3>
                <p class="section-p">
                    Daftar prioritas komoditas yang memerlukan pemesanan ulang (Restock Order) ke vendor prinsipal karena jumlah stok fisik telah mencapai batas kritis (&lt; 3 unit) atau telah habis sepenuhnya.
                </p>
            </div>
        </div>

        <div class="monitoring-grid">
            <?php 
            $adaKritis = false;
            foreach ($products as $item): 
                $stk = (int)($item['stok'] ?? 0);
                if ($stk < 3): 
                    $adaKritis = true;
                    $statusItem = tentukanStatusStok($stk);
                    $badgeCls   = getStatusBadgeClass($statusItem);
                    $rekomendasiOrder = max(10, 15 - $stk); // Rekomendasi restock cerdas
            ?>
            <div class="urgent-item-card <?php echo ($stk === 0) ? 'urgent-habis' : 'urgent-kritis'; ?>">
                <div class="urgent-top">
                    <span class="urgent-sku"><?php echo sanitize($item['id']); ?></span>
                    <span class="status-badge <?php echo $badgeCls; ?>">
                        <span class="status-dot"></span>
                        <?php echo $statusItem; ?>
                    </span>
                </div>
                <h4 class="urgent-name"><?php echo sanitize($item['nama']); ?></h4>
                <div class="urgent-category"><?php echo sanitize($item['kategori']); ?></div>
                
                <div class="urgent-metrics">
                    <div class="metric-box">
                        <span class="m-label">Stok Saat Ini</span>
                        <span class="m-val <?php echo ($stk === 0) ? 'text-habis' : 'text-kritis'; ?>">
                            <?php echo $stk; ?> Unit
                        </span>
                    </div>
                    <div class="metric-box">
                        <span class="m-label">Rekomendasi PO</span>
                        <span class="m-val text-emerald">+<?php echo $rekomendasiOrder; ?> Unit</span>
                    </div>
                </div>

                <div class="urgent-action-row">
                    <button type="button" class="btn btn-sm btn-order-trigger btn-view-detail" data-id="<?php echo sanitize($item['id']); ?>">
                        Periksa Detail
                    </button>
                </div>
            </div>
            <?php 
                endif;
            endforeach; 

            if (!$adaKritis):
            ?>
            <div class="alert-success-box">
                <p>Seluruh persediaan barang dalam kondisi aman (&ge; 3 unit). Tidak ada komoditas kritis saat ini.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Section: System Architecture & Academic Compliance Card -->
<section class="architecture-section" id="arsitektur">
    <div class="section-card">
        <div class="arch-header">
            <span class="section-tag-emerald">Arsitektur Modular PHP Native</span>
            <h3 class="section-h3">Penerapan Konsep Pertemuan 2: PHP Fundamental & Data Structure</h3>
            <p class="section-p">
                Aplikasi <strong>STOCKWISE</strong> dirancang secara modular tanpa framework eksternal, mendemonstrasikan implementasi nyata dari materi perkuliahan server-side programming.
            </p>
        </div>

        <div class="arch-tiers-grid">
            <!-- Tier 1: Data Layer -->
            <div class="tier-card">
                <div class="tier-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                        <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                        <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                    </svg>
                </div>
                <h4 class="tier-name">1. Data Layer (products.php)</h4>
                <p class="tier-desc">
                    Menggunakan <strong>Multidimensional Associative Array</strong> (Slide 10-11). Setiap elemen array merepresentasikan tuple rekaman produk dengan kunci terstruktur: <code>id</code>, <code>nama</code>, <code>kategori</code>, <code>harga</code>, <code>stok</code>, dan <code>deskripsi</code>.
                </p>
                <div class="tier-code-preview">
                    <code>$products = [&hellip; ['id' =&gt; 'PRD-001', 'harga' =&gt; 32500000] &hellip;];</code>
                </div>
            </div>

            <!-- Tier 2: Processing Layer -->
            <div class="tier-card">
                <div class="tier-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                </div>
                <h4 class="tier-name">2. Processing Layer (functions.php)</h4>
                <p class="tier-desc">
                    Menerapkan <strong>Single Responsibility Principle</strong> (Slide 9 & 14). Menyediakan fungsi bisnis: <code>hitungTotalNilaiStok()</code>, <code>hitungTotalStok()</code>, <code>hitungProdukKritis()</code>, dan <code>tentukanStatusStok()</code> menggunakan conditional <code>if-elseif-else</code> dengan syarat kritis <code>$stok &lt; 3</code>.
                </p>
                <div class="tier-code-preview">
                    <code>if ($stok === 0) &hellip; elseif ($stok &lt; 3) &hellip;</code>
                </div>
            </div>

            <!-- Tier 3: Presentation Layer -->
            <div class="tier-card">
                <div class="tier-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                        <line x1="8" y1="21" x2="16" y2="21"></line>
                        <line x1="12" y1="17" x2="12" y2="21"></line>
                    </svg>
                </div>
                <h4 class="tier-name">3. Presentation Layer (index.php)</h4>
                <p class="tier-desc">
                    Merajut komponen via <strong>require_once</strong> (Slide 13). Menggunakan perulangan <strong>foreach</strong> (Slide 8) untuk merender tabel inventaris dinamis dengan proteksi sanitasi XSS <code>htmlspecialchars()</code> (Slide 12).
                </p>
                <div class="tier-code-preview">
                    <code>foreach ($products as $item) { echo sanitize($item['nama']); }</code>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Memuat Footer Layout
include_once __DIR__ . '/includes/footer.php';
?>
