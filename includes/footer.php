<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * includes/footer.php
 * Komponen layout footer, modal interaktif, toast container, dan pemanggilan script JS.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */
?>
            </main> <!-- /content-body -->

            <!-- Main App Footer -->
            <footer class="app-footer">
                <div class="footer-left">
                    <p class="copyright">
                        <strong><?php echo sanitize(APP_NAME); ?></strong> &copy; <?php echo date('Y'); ?> — <?php echo sanitize(COMPANY_NAME); ?>. Seluruh hak cipta dilindungi.
                    </p>
                    <p class="academic-note">
                        Mini Project 1: Pemrograman Web (PHP Fundamental & Data Structure).
                    </p>
                </div>
                <div class="footer-right">
                    <span class="version-tag">Build: Native Core v<?php echo sanitize(APP_VERSION); ?></span>
                    <a href="#dashboard" class="back-to-top" title="Kembali ke atas">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="18 15 12 9 6 15"></polyline>
                        </svg>
                        <span>Ke Atas</span>
                    </a>
                </div>
            </footer>
        </div> <!-- /main-wrapper -->
    </div> <!-- /app-layout -->

    <!-- Quick View Product Detail Modal -->
    <div class="modal-overlay" id="productModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <span class="modal-badge-id" id="modalProductSku">PRD-000</span>
                    <h3 class="modal-title" id="modalTitle">Detail Informasi Produk</h3>
                </div>
                <button type="button" class="modal-close-btn" id="modalCloseBtn" aria-label="Tutup Jendela Modal">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="modal-detail-grid">
                    <div class="modal-field">
                        <label class="modal-label">Nama Perangkat</label>
                        <p class="modal-val-lg" id="modalProductName">-</p>
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Kategori Komoditas</label>
                        <p class="modal-val" id="modalProductCategory">-</p>
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Harga Satuan Unit</label>
                        <p class="modal-val-price" id="modalProductPrice">-</p>
                    </div>
                    <div class="modal-field">
                        <label class="modal-label">Kuantitas Stok & Status</label>
                        <div class="modal-stock-group">
                            <span class="modal-stock-qty" id="modalProductStock">0 Unit</span>
                            <span class="status-badge" id="modalProductBadge">-</span>
                        </div>
                    </div>
                    <div class="modal-field modal-field-full">
                        <label class="modal-label">Estimasi Nilai Total Persediaan Produk Ini (Harga × Stok)</label>
                        <p class="modal-val-highlight" id="modalProductAssetVal">-</p>
                    </div>
                    <div class="modal-field modal-field-full">
                        <label class="modal-label">Spesifikasi & Deskripsi Teknis</label>
                        <div class="modal-desc-box" id="modalProductDesc">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="modalCopyBtn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                    </svg>
                    <span>Salin Info Ringkas</span>
                </button>
                <button type="button" class="btn btn-primary" id="modalDismissBtn">Tutup Jendela</button>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container" id="toastContainer" aria-live="polite"></div>

    <!-- Vanilla JavaScript Core -->
    <script src="assets/js/script.js"></script>
</body>
</html>
