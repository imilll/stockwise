<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * includes/sidebar.php
 * Komponen navigasi vertikal samping (Sidebar) bertema Dark Navy modern.
 * Memuat identitas sistem, navigasi menu berbasis anchor internal,
 * serta status sistem lingkungan PHP.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */
?>
<aside class="sidebar" id="appSidebar">
    <!-- Brand / Logo Area -->
    <div class="sidebar-brand">
        <div class="brand-logo-icon">
            <!-- Modern Geometric Tech Cube SVG -->
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
        </div>
        <div class="brand-text-group">
            <span class="brand-title"><?php echo sanitize(APP_NAME); ?></span>
            <span class="brand-badge">v<?php echo sanitize(APP_VERSION); ?></span>
        </div>
    </div>

    <!-- Company Meta Tagline -->
    <div class="sidebar-company">
        <span class="company-sub"><?php echo sanitize(COMPANY_NAME); ?></span>
    </div>

    <!-- Navigation Menu List -->
    <nav class="sidebar-nav">
        <div class="nav-section-label">NAVIGASI UTAMA</div>
        <ul class="nav-menu">
            <li class="nav-item active">
                <a href="#dashboard" class="nav-link">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Dashboard Utama</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#katalog" class="nav-link">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <path d="M16 10a4 4 0 0 1-8 0"></path>
                    </svg>
                    <span>Katalog Produk</span>
                    <span class="nav-badge-count" id="navProductCount"><?php echo count($products); ?></span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#monitoring" class="nav-link">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Monitoring Stok</span>
                    <?php 
                        $jmlKritisNav = hitungProdukKritis($products);
                        if ($jmlKritisNav > 0): 
                    ?>
                        <span class="nav-badge-alert"><?php echo $jmlKritisNav; ?> Kritis</span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item">
                <a href="#analisis" class="nav-link">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="20" x2="18" y2="10"></line>
                        <line x1="12" y1="20" x2="12" y2="4"></line>
                        <line x1="6" y1="20" x2="6" y2="14"></line>
                    </svg>
                    <span>Analisis Nilai Aset</span>
                </a>
            </li>
        </ul>

        <div class="nav-section-label" style="margin-top: 24px;">INFORMASI TEKNIS</div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#arsitektur" class="nav-link">
                    <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                    <span>Arsitektur Sistem</span>
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar Technical Card (Bottom) -->
    <div class="sidebar-footer">
        <div class="sys-status-card">
            <div class="sys-status-header">
                <span class="pulse-indicator"></span>
                <span class="sys-title">PHP Runtime Status</span>
            </div>
            <p class="sys-desc">Native Array Data Engine • PHP <?php echo PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION; ?></p>
            <div class="sys-metric-row">
                <span>Architecture:</span>
                <span class="sys-val">Modular 3-Tier</span>
            </div>
            <div class="sys-metric-row">
                <span>Timezone:</span>
                <span class="sys-val"><?php echo date_default_timezone_get(); ?></span>
            </div>
        </div>
    </div>
</aside>
