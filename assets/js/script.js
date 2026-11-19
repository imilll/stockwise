/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * assets/js/script.js
 * Vanilla JavaScript Frontend Controller:
 * - Client-side Instant Search & Multi-criteria Filtering
 * - Real-time Multi-column Sorting (Dropdown & Column Headers)
 * - Dynamic Empty State & Matching Counter
 * - Interactive Product Quick View Modal & Clipboard Utility
 * - Client-side Dynamic CSV Exporter & Print Handler
 * - Toast Notification Feedback System
 * - Mobile Navigation Sidebar Drawer Controller
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

document.addEventListener('DOMContentLoaded', () => {
    // =========================================================================
    // 1. DOM ELEMENTS REFERENCES
    // =========================================================================
    const searchInput      = document.getElementById('searchInput');
    const clearSearchBtn   = document.getElementById('clearSearchBtn');
    const filterCategory   = document.getElementById('filterCategory');
    const filterStatus     = document.getElementById('filterStatus');
    const sortBy           = document.getElementById('sortBy');
    const btnResetFilters  = document.getElementById('btnResetFilters');
    const btnEmptyReset    = document.getElementById('btnEmptyReset');
    const tableBody        = document.getElementById('tableBody');
    const emptyState       = document.getElementById('emptyState');
    const visibleCount     = document.getElementById('visibleCount');
    const inventoryTable   = document.getElementById('inventoryTable');
    const tableHeaders     = inventoryTable ? inventoryTable.querySelectorAll('th[data-sort]') : [];

    // Modal Elements
    const productModal     = document.getElementById('productModal');
    const modalCloseBtn    = document.getElementById('modalCloseBtn');
    const modalDismissBtn  = document.getElementById('modalDismissBtn');
    const modalCopyBtn     = document.getElementById('modalCopyBtn');
    const modalProductSku  = document.getElementById('modalProductSku');
    const modalProductName = document.getElementById('modalProductName');
    const modalProductCategory = document.getElementById('modalProductCategory');
    const modalProductPrice = document.getElementById('modalProductPrice');
    const modalProductStock = document.getElementById('modalProductStock');
    const modalProductBadge = document.getElementById('modalProductBadge');
    const modalProductAssetVal = document.getElementById('modalProductAssetVal');
    const modalProductDesc = document.getElementById('modalProductDesc');

    // Action Buttons
    const btnExportCsv     = document.getElementById('btnExportCsv');
    const btnPrintReport   = document.getElementById('btnPrintReport');
    const toastContainer   = document.getElementById('toastContainer');
    const sidebarToggle    = document.getElementById('sidebarToggle');
    const appSidebar       = document.getElementById('appSidebar');

    // Store all initial rows for client-side manipulation
    const initialRows = tableBody ? Array.from(tableBody.querySelectorAll('tr.table-row')) : [];

    // Current active modal data cache
    let currentModalData = null;

    // =========================================================================
    // 2. TOAST NOTIFICATION UTILITY
    // =========================================================================
    function showToast(message, type = 'success') {
        if (!toastContainer) return;

        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        
        let iconSvg = '';
        if (type === 'success') {
            iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`;
        } else if (type === 'warning') {
            iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`;
        } else {
            iconSvg = `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>`;
        }

        toast.innerHTML = `${iconSvg} <span>${message}</span>`;
        toastContainer.appendChild(toast);

        // Auto dismiss after 3.5 seconds
        setTimeout(() => {
            toast.classList.add('toast-out');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3500);
    }

    // =========================================================================
    // 3. SEARCH & FILTER CORE CONTROLLER
    // =========================================================================
    function applyFiltersAndSort() {
        if (!tableBody) return;

        const searchQuery    = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedCat    = filterCategory ? filterCategory.value : 'all';
        const selectedStatus = filterStatus ? filterStatus.value : 'all';
        const activeSort     = sortBy ? sortBy.value : 'id_asc';

        // Toggle clear search button visibility
        if (clearSearchBtn) {
            clearSearchBtn.style.display = searchQuery.length > 0 ? 'block' : 'none';
        }

        // 1. Filtering
        const filteredRows = initialRows.filter(row => {
            const id        = (row.getAttribute('data-id') || '').toLowerCase();
            const nama      = (row.getAttribute('data-nama') || '').toLowerCase();
            const kategori  = (row.getAttribute('data-kategori') || '');
            const status    = (row.getAttribute('data-status') || '');
            const desc      = (row.getAttribute('data-desc') || '').toLowerCase();

            // Match search
            const matchSearch = (
                searchQuery === '' ||
                id.includes(searchQuery) ||
                nama.includes(searchQuery) ||
                desc.includes(searchQuery)
            );

            // Match category
            const matchCat = (selectedCat === 'all' || kategori === selectedCat);

            // Match status
            const matchStatus = (selectedStatus === 'all' || status === selectedStatus);

            return matchSearch && matchCat && matchStatus;
        });

        // 2. Sorting
        filteredRows.sort((a, b) => {
            const idA    = a.getAttribute('data-id') || '';
            const idB    = b.getAttribute('data-id') || '';
            const namaA  = (a.getAttribute('data-nama') || '').toLowerCase();
            const namaB  = (b.getAttribute('data-nama') || '').toLowerCase();
            const hargaA = parseFloat(a.getAttribute('data-harga')) || 0;
            const hargaB = parseFloat(b.getAttribute('data-harga')) || 0;
            const stokA  = parseInt(a.getAttribute('data-stok'), 10) || 0;
            const stokB  = parseInt(b.getAttribute('data-stok'), 10) || 0;

            switch (activeSort) {
                case 'nama_asc':
                    return namaA.localeCompare(namaB);
                case 'nama_desc':
                    return namaB.localeCompare(namaA);
                case 'harga_desc':
                    return hargaB - hargaA;
                case 'harga_asc':
                    return hargaA - hargaB;
                case 'stok_desc':
                    return stokB - stokA;
                case 'stok_asc':
                    return stokA - stokB;
                case 'id_desc':
                    return idB.localeCompare(idA);
                case 'id_asc':
                default:
                    return idA.localeCompare(idB);
            }
        });

        // 3. Render into DOM
        tableBody.innerHTML = '';
        if (filteredRows.length > 0) {
            filteredRows.forEach(row => tableBody.appendChild(row));
            if (emptyState) emptyState.style.display = 'none';
            if (inventoryTable) inventoryTable.style.display = 'table';
        } else {
            if (emptyState) emptyState.style.display = 'flex';
            if (inventoryTable) inventoryTable.style.display = 'none';
        }

        // 4. Update Counter
        if (visibleCount) {
            visibleCount.textContent = filteredRows.length;
        }
    }

    // Event Listeners for Filters
    if (searchInput) {
        searchInput.addEventListener('input', applyFiltersAndSort);
    }

    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', () => {
            searchInput.value = '';
            searchInput.focus();
            applyFiltersAndSort();
        });
    }

    if (filterCategory) {
        filterCategory.addEventListener('change', applyFiltersAndSort);
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', applyFiltersAndSort);
    }

    if (sortBy) {
        sortBy.addEventListener('change', applyFiltersAndSort);
    }

    // Reset Filters Button Handler
    function resetAllFilters() {
        if (searchInput) searchInput.value = '';
        if (filterCategory) filterCategory.value = 'all';
        if (filterStatus) filterStatus.value = 'all';
        if (sortBy) sortBy.value = 'id_asc';
        applyFiltersAndSort();
        showToast('Semua filter berhasil dikembalikan ke tampilan awal.', 'success');
    }

    if (btnResetFilters) {
        btnResetFilters.addEventListener('click', resetAllFilters);
    }

    if (btnEmptyReset) {
        btnEmptyReset.addEventListener('click', resetAllFilters);
    }

    // Column Header Click to Sort
    tableHeaders.forEach(th => {
        th.style.cursor = 'pointer';
        th.setAttribute('title', 'Klik untuk mengurutkan kolom');
        th.addEventListener('click', () => {
            const sortKey = th.getAttribute('data-sort');
            if (!sortBy) return;

            if (sortKey === 'nama') {
                sortBy.value = (sortBy.value === 'nama_asc') ? 'nama_desc' : 'nama_asc';
            } else if (sortKey === 'harga') {
                sortBy.value = (sortBy.value === 'harga_desc') ? 'harga_asc' : 'harga_desc';
            } else if (sortKey === 'stok') {
                sortBy.value = (sortBy.value === 'stok_desc') ? 'stok_asc' : 'stok_desc';
            } else if (sortKey === 'id') {
                sortBy.value = (sortBy.value === 'id_asc') ? 'id_desc' : 'id_asc';
            }
            applyFiltersAndSort();
            showToast(`Daftar diurutkan berdasarkan kolom ${th.textContent.trim()}`, 'success');
        });
    });

    // =========================================================================
    // 4. QUICK VIEW MODAL CONTROLLER
    // =========================================================================
    function openModalWithData(rowElement) {
        if (!rowElement || !productModal) return;

        const id       = rowElement.getAttribute('data-id') || '-';
        const namaElem = rowElement.querySelector('.product-name-main');
        const nama     = namaElem ? namaElem.textContent.trim() : (rowElement.getAttribute('data-nama') || '-');
        const kategori = rowElement.getAttribute('data-kategori') || '-';
        const hargaFmt = rowElement.querySelector('.price-value') ? rowElement.querySelector('.price-value').textContent.trim() : '-';
        const stok     = rowElement.getAttribute('data-stok') || '0';
        const status   = rowElement.getAttribute('data-status') || '-';
        const desc     = rowElement.getAttribute('data-desc') || '-';
        const assetVal = rowElement.getAttribute('data-asset') || '-';

        // Cache current data for copy utility
        currentModalData = { id, nama, kategori, hargaFmt, stok, status, desc, assetVal };

        // Populate Modal Fields
        if (modalProductSku) modalProductSku.textContent = id;
        if (modalProductName) modalProductName.textContent = nama;
        if (modalProductCategory) modalProductCategory.textContent = kategori;
        if (modalProductPrice) modalProductPrice.textContent = hargaFmt;
        if (modalProductStock) modalProductStock.textContent = `${stok} Unit`;
        if (modalProductAssetVal) modalProductAssetVal.textContent = assetVal;
        if (modalProductDesc) modalProductDesc.textContent = desc;

        // Set status badge in modal
        if (modalProductBadge) {
            modalProductBadge.className = 'status-badge';
            let badgeClass = 'badge-aman';
            if (status === 'Habis') badgeClass = 'badge-habis';
            else if (status === 'Kritis') badgeClass = 'badge-kritis';
            else if (status === 'Menipis') badgeClass = 'badge-menipis';

            modalProductBadge.classList.add(badgeClass);
            modalProductBadge.innerHTML = `<span class="status-dot"></span> ${status}`;
        }

        // Open modal
        productModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        if (!productModal) return;
        productModal.classList.remove('active');
        document.body.style.overflow = '';
    }

    // Modal Trigger Delegations (Table Rows & Buttons)
    document.addEventListener('click', (e) => {
        // Klik tombol view detail
        const btnView = e.target.closest('.btn-view-detail');
        if (btnView) {
            const sku = btnView.getAttribute('data-id');
            const targetRow = initialRows.find(r => r.getAttribute('data-id') === sku);
            if (targetRow) {
                openModalWithData(targetRow);
            }
            return;
        }

        // Klik pada baris tabel (kecuali jika mengklik link/button lain)
        const tr = e.target.closest('tr.table-row');
        if (tr && !e.target.closest('button') && !e.target.closest('a')) {
            openModalWithData(tr);
        }
    });

    if (modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    if (modalDismissBtn) modalDismissBtn.addEventListener('click', closeModal);

    // Close when clicking overlay backdrop
    if (productModal) {
        productModal.addEventListener('click', (e) => {
            if (e.target === productModal) {
                closeModal();
            }
        });
    }

    // Close on Escape key press
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && productModal && productModal.classList.contains('active')) {
            closeModal();
        }
    });

    // Copy Product Info to Clipboard
    if (modalCopyBtn) {
        modalCopyBtn.addEventListener('click', () => {
            if (!currentModalData) return;

            const textToCopy = `[STOCKWISE PRODUCT SPEC]
ID: ${currentModalData.id}
Nama: ${currentModalData.nama}
Kategori: ${currentModalData.kategori}
Harga: ${currentModalData.hargaFmt}
Stok: ${currentModalData.stok} Unit (${currentModalData.status})
Total Nilai Persediaan: ${currentModalData.assetVal}
Deskripsi: ${currentModalData.desc}`;

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(textToCopy).then(() => {
                    showToast(`Spesifikasi ${currentModalData.id} berhasil disalin ke clipboard!`, 'success');
                }).catch(() => {
                    fallbackCopyText(textToCopy);
                });
            } else {
                fallbackCopyText(textToCopy);
            }
        });
    }

    function fallbackCopyText(text) {
        const tempTextArea = document.createElement('textarea');
        tempTextArea.value = text;
        tempTextArea.style.position = 'fixed';
        tempTextArea.style.left = '-9999px';
        document.body.appendChild(tempTextArea);
        tempTextArea.select();
        try {
            document.execCommand('copy');
            showToast('Informasi produk berhasil disalin!', 'success');
        } catch (err) {
            showToast('Gagal menyalin teks ke clipboard.', 'error');
        }
        document.body.removeChild(tempTextArea);
    }

    // =========================================================================
    // 5. CLIENT-SIDE CSV EXPORT UTILITY
    // =========================================================================
    if (btnExportCsv) {
        btnExportCsv.addEventListener('click', () => {
            // Get currently visible or all rows
            const rowsToExport = tableBody ? Array.from(tableBody.querySelectorAll('tr.table-row')) : initialRows;

            if (rowsToExport.length === 0) {
                showToast('Tidak ada data produk yang dapat diekspor.', 'warning');
                return;
            }

            // CSV Header
            const headers = ['ID Produk', 'Nama Produk', 'Kategori', 'Harga (IDR)', 'Stok (Unit)', 'Status Persediaan', 'Total Nilai Aset (IDR)', 'Deskripsi'];
            
            const csvRows = [];
            csvRows.push(headers.map(h => `"${h}"`).join(','));

            rowsToExport.forEach(row => {
                const id       = row.getAttribute('data-id') || '';
                const namaElem = row.querySelector('.product-name-main');
                const nama     = namaElem ? namaElem.textContent.trim() : (row.getAttribute('data-nama') || '');
                const kategori = row.getAttribute('data-kategori') || '';
                const harga    = row.getAttribute('data-harga') || '0';
                const stok     = row.getAttribute('data-stok') || '0';
                const status   = row.getAttribute('data-status') || '';
                const assetVal = (parseFloat(harga) * parseInt(stok, 10)) || 0;
                const desc     = (row.getAttribute('data-desc') || '').replace(/"/g, '""');

                const rowData = [
                    `"${id}"`,
                    `"${nama.replace(/"/g, '""')}"`,
                    `"${kategori}"`,
                    harga,
                    stok,
                    `"${status}"`,
                    assetVal,
                    `"${desc}"`
                ];
                csvRows.push(rowData.join(','));
            });

            // Create Blob and trigger download
            const csvContent = '\uFEFF' + csvRows.join('\r\n'); // Add BOM for Excel UTF-8 compatibility
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const downloadLink = document.createElement('a');
            
            const timestamp = new Date().toISOString().slice(0, 10);
            downloadLink.href = url;
            downloadLink.setAttribute('download', `STOCKWISE_Inventory_Report_${timestamp}.csv`);
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            URL.revokeObjectURL(url);

            showToast(`Berhasil mengekspor ${rowsToExport.length} data komoditas ke CSV!`, 'success');
        });
    }

    // =========================================================================
    // 6. PRINT REPORT HANDLER
    // =========================================================================
    if (btnPrintReport) {
        btnPrintReport.addEventListener('click', () => {
            showToast('Membuka dialog pencetakan dokumen...', 'success');
            setTimeout(() => {
                window.print();
            }, 300);
        });
    }

    // =========================================================================
    // 7. MOBILE SIDEBAR DRAWER TOGGLE
    // =========================================================================
    if (sidebarToggle && appSidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            appSidebar.classList.toggle('open');
        });

        // Close when clicking outside of sidebar on mobile
        document.addEventListener('click', (e) => {
            if (appSidebar.classList.contains('open') && !appSidebar.contains(e.target) && e.target !== sidebarToggle) {
                appSidebar.classList.remove('open');
            }
        });
    }

    // Highlight active anchor on scroll
    const navLinks = document.querySelectorAll('.sidebar-nav .nav-link');
    const sections = document.querySelectorAll('section[id]');

    function updateNavHighlight() {
        const scrollPosition = window.scrollY + 100;
        sections.forEach(section => {
            const top = section.offsetTop;
            const height = section.offsetHeight;
            const id = section.getAttribute('id');

            if (scrollPosition >= top && scrollPosition < top + height) {
                navLinks.forEach(link => {
                    const li = link.closest('.nav-item');
                    if (li) {
                        if (link.getAttribute('href') === `#${id}`) {
                            li.classList.add('active');
                        } else {
                            li.classList.remove('active');
                        }
                    }
                });
            }
        });
    }

    window.addEventListener('scroll', updateNavHighlight, { passive: true });
});
