<?php
/**
 * STOCKWISE – Product Inventory & Information System
 * 
 * products.php
 * Data Layer: Merepresentasikan struktur data katalog dan stok produk
 * menggunakan Multidimensional Associative Array (Slide 10-11 & Slide 17).
 * 
 * Setiap elemen array merepresentasikan entitas tunggal komoditas teknologi
 * dengan atribut kunci: id, nama, kategori, harga, stok, dan deskripsi.
 * 
 * @package STOCKWISE
 * @author Tim Pengembang Mahasiswa Sistem Informasi
 * @version 1.0.0
 */

// Mencegah akses langsung ke file jika diperlukan, atau menjamin array terdefinisi
$products = [
    [
        'id'        => 'PRD-001',
        'nama'      => 'ASUS ROG Zephyrus G16 (2024)',
        'kategori'  => 'Laptop',
        'harga'     => 32500000,
        'stok'      => 8,
        'deskripsi' => 'Laptop gaming ultra-tipis ditenagai Intel Core Ultra 9 185H, GPU RTX 4070 8GB GDDR6, 32GB LPDDR5X, layar 16 inci 2.5K OLED 240Hz.'
    ],
    [
        'id'        => 'PRD-002',
        'nama'      => 'Lenovo ThinkPad X1 Carbon Gen 11',
        'kategori'  => 'Laptop',
        'harga'     => 27900000,
        'stok'      => 2,
        'deskripsi' => 'Laptop bisnis enterprise berbobot 1.12kg dengan sasis serat karbon, Intel Core i7-1365U vPro, 32GB RAM, SSD 1TB NVMe Opal2, baterai 57Wh.'
    ],
    [
        'id'        => 'PRD-003',
        'nama'      => 'Apple MacBook Air M2 13.6-inch',
        'kategori'  => 'Laptop',
        'harga'     => 16499000,
        'stok'      => 0,
        'deskripsi' => 'Notebook tipis performa tinggi dengan chip Apple M2 8-core CPU 10-core GPU, Liquid Retina Display 500 nits, MagSafe 3, fanless design.'
    ],
    [
        'id'        => 'PRD-004',
        'nama'      => 'Keychron Q1 Pro Wireless Custom Keyboard',
        'kategori'  => 'Peripherals',
        'harga'     => 2850000,
        'stok'      => 14,
        'deskripsi' => 'Mechanical keyboard 75% CNC full aluminium dengan QMK/VIA support, konektivitas Bluetooth 5.1 & Type-C, hot-swappable K Pro Red Switches.'
    ],
    [
        'id'        => 'PRD-005',
        'nama'      => 'Logitech MX Master 3S Performance Mouse',
        'kategori'  => 'Peripherals',
        'harga'     => 1450000,
        'stok'      => 4,
        'deskripsi' => 'Mouse ergonomis nirkabel profesional dengan sensor optik 8.000 DPI yang melacak di atas kaca, MagSpeed electromagnetic scroll, Quiet Clicks.'
    ],
    [
        'id'        => 'PRD-006',
        'nama'      => 'Razer DeathAdder V3 Pro Wireless Gaming',
        'kategori'  => 'Peripherals',
        'harga'     => 2199000,
        'stok'      => 1,
        'deskripsi' => 'Mouse esports kompetitif ultra-ringan 63 gram, sensor Focus Pro 30K Optical, Optical Mouse Switches Gen-3, polling rate hingga 4000Hz.'
    ],
    [
        'id'        => 'PRD-007',
        'nama'      => 'LG UltraGear 27GP850-B Gaming Monitor',
        'kategori'  => 'Display',
        'harga'     => 5750000,
        'stok'      => 7,
        'deskripsi' => 'Monitor 27 inci Nano IPS QHD (2560x1440), refresh rate 165Hz (O/C 180Hz), 1ms GtG, VESA DisplayHDR 400, kompatibel NVIDIA G-SYNC.'
    ],
    [
        'id'        => 'PRD-008',
        'nama'      => 'Dell UltraSharp 32 4K USB-C Hub (U3223QE)',
        'kategori'  => 'Display',
        'harga'     => 12800000,
        'stok'      => 3,
        'deskripsi' => 'Monitor profesional 31.5 inci 4K UHD teknologi IPS Black dengan rasio kontras 2000:1, 90W Power Delivery, RJ45 LAN port terintegrasi.'
    ],
    [
        'id'        => 'PRD-009',
        'nama'      => 'Samsung Odyssey Neo G9 49" DQHD Curved',
        'kategori'  => 'Display',
        'harga'     => 24500000,
        'stok'      => 0,
        'deskripsi' => 'Super ultra-wide 49 inci Dual QHD (5120x1440) Mini-LED dengan kelengkungan 1000R, refresh rate 240Hz, 1ms respons time, Quantum HDR 2000.'
    ],
    [
        'id'        => 'PRD-010',
        'nama'      => 'Sony WH-1000XM5 Wireless Noise Cancelling',
        'kategori'  => 'Audio',
        'harga'     => 4999000,
        'stok'      => 11,
        'deskripsi' => 'Headphone flagship industri dengan dual processor V1 & QN1, 8 mikrofon pengurang derau aktif, driver 30mm karbon, baterai tahan 30 jam.'
    ],
    [
        'id'        => 'PRD-011',
        'nama'      => 'Audio-Technica ATH-M50xBT2 Professional',
        'kategori'  => 'Audio',
        'harga'     => 2650000,
        'stok'      => 5,
        'deskripsi' => 'Headphone monitor studio legendaris versi nirkabel dengan driver proprietary 45mm aperture besar, DAC audio premium AK4331, baterai 50 jam.'
    ],
    [
        'id'        => 'PRD-012',
        'nama'      => 'Shure MV7 USB/XLR Dynamic Podcast Mic',
        'kategori'  => 'Audio',
        'harga'     => 3850000,
        'stok'      => 2,
        'deskripsi' => 'Mikrofon vokal dinamik hybrid USB dan XLR bersertifikasi broadcast, Voice Isolation Technology, touch panel control, kompatibel ShurePlus MOTIV.'
    ],
    [
        'id'        => 'PRD-013',
        'nama'      => 'Samsung 990 PRO NVMe M.2 SSD 2TB Heatsink',
        'kategori'  => 'Storage',
        'harga'     => 2950000,
        'stok'      => 18,
        'deskripsi' => 'Solid State Drive PCIe 4.0 NVMe berkecepatan baca sekuensial hingga 7.450 MB/s, kontrol termal pintar dengan heatsink terintegrasi untuk PS5 & PC.'
    ],
    [
        'id'        => 'PRD-014',
        'nama'      => 'Synology DiskStation DS923+ 4-Bay NAS',
        'kategori'  => 'Storage',
        'harga'     => 9850000,
        'stok'      => 4,
        'deskripsi' => 'Server penyimpanan jaringan enterprise 4-bay bertenaga AMD Ryzen R1600 dual-core, 4GB DDR4 ECC RAM, slot dual M.2 NVMe cache, port 10GbE ready.'
    ],
    [
        'id'        => 'PRD-015',
        'nama'      => 'Ubiquiti UniFi Dream Machine Pro (UDM-Pro)',
        'kategori'  => 'Networking',
        'harga'     => 7600000,
        'stok'      => 1,
        'deskripsi' => 'Perangkat gateway jaringan all-in-one 1U rackmount dengan switch 8-port gigabit, dual SFP+ 10G uplink, IPS/IDS throughput 3.5 Gbps, UniFi OS controller.'
    ],
    [
        'id'        => 'PRD-016',
        'nama'      => 'ASUS ROG Rapture GT-AXE16000 Quad-Band',
        'kategori'  => 'Networking',
        'harga'     => 11200000,
        'stok'      => 6,
        'deskripsi' => 'Router gaming Wi-Fi 6E quad-band pertama di dunia dengan kecepatan agregat hingga 16.000 Mbps, dual port 10G, port 2.5G WAN, prosesor quad-core 2.0 GHz.'
    ]
];
