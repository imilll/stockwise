# STOCKWISE – Product Inventory & Information System

![PHP Version](https://img.shields.io/badge/PHP-8.2%2B%20Native-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Frontend](https://img.shields.io/badge/Frontend-HTML5%20%7C%20CSS3%20%7C%20Vanilla%20JS-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-3--Tier%20Modular%20(No%20DB)-10B981?style=for-the-badge)
![Status](https://img.shields.io/badge/Project%20Status-Complete%20%2F%20Production%20Ready-059669?style=for-the-badge)

> **Mini Project 1 – Pemrograman Web**  
> Topik: *PHP Fundamental & Data Structure (Server-Side Processing, Data Management, & Modular Design)*  
> Repositori Portofolio Pengembangan Sistem Informasi Inventaris Berbasis PHP Murni.

---

## 📋 Daftar Isi

1. [Tentang Project](#-tentang-project)
2. [Tujuan dan Manfaat Sistem](#-tujuan-dan-manfaat-sistem)
3. [Fitur-Fitur Utama](#-fitur-fitur-utama)
4. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
5. [Struktur Folder & Berkas](#-struktur-folder--berkas)
6. [Arsitektur Sistem (Separation of Concerns)](#-arsitektur-sistem-separation-of-concerns)
   - [A. Data Layer (products.php)](#a-data-layer-productsphp)
   - [B. Processing Layer (functions.php)](#b-processing-layer-functionsphp)
   - [C. Presentation Layer (index.php & includes/)](#c-presentation-layer-indexphp--includes)
7. [Penjelasan Mendalam Logika Bisnis](#-penjelasan-mendalam-logika-bisnis)
   - [Perhitungan Nilai Aset: hitungTotalNilaiStok()](#1-perhitungan-total-nilai-aset-persediaan-hitungtotalnilaistok)
   - [Evaluasi Status & Logika Stok Kritis (< 3)](#2-evaluasi-kondisi-stok-kritis-tentukanstatusstok)
8. [Panduan Instalasi & Menjalankan Aplikasi](#-panduan-instalasi--menjalankan-aplikasi)
   - [Opsi A: Menggunakan XAMPP (Apache)](#opsi-a-menggunakan-xampp-apache)
   - [Opsi B: Menggunakan PHP Built-in Server](#opsi-b-menggunakan-php-built-in-cli-server)
9. [Tampilan Antarmuka (Preview & Screenshots)](#-tampilan-antarmuka-preview--screenshots)
10. [Pembahasan Evaluatif & Konseptual Kuliah](#-pembahasan-evaluatif--konseptual-kuliah)
11. [Lisensi & Penulis](#-lisensi--penulis)

---

## 📦 Tentang Project

**STOCKWISE** adalah aplikasi web inventaris dan sistem informasi produk enterprise yang dirancang khusus untuk memenuhi kebutuhan operasional perusahaan distributor komoditas teknologi (**PT Tech Nusantara Distribusi**). 

Aplikasi ini dibangun murni menggunakan **PHP Native** tanpa ketergantungan pada database relasional (RDBMS) seperti MySQL, melainkan memanfaatkan kecanggihan struktur data **Multidimensional Associative Array** dalam memori runtime PHP. Sistem ini mengadopsi standar desain *Modern SaaS Dashboard* kelas profesional yang menyajikan visualisasi data persediaan, pemantauan batas kritis stok barang, kalkulasi nilai aset buku secara instan, dan antarmuka manajemen barang yang responsif.

---

## 🎯 Tujuan dan Manfaat Sistem

1. **Struktur Informasi Komoditas**: Menyajikan katalog produk perangkat keras (hardware) dan periferal teknologi secara terorganisir lengkap dengan SKU, kategori, harga satuan, stok fisik, dan spesifikasi teknis.
2. **Kalkulasi Nilai Aset Otomatis**: Menghitung secara presisi total nilai kapitalisasi stok barang yang tersimpan di gudang menggunakan algoritma traversal PHP.
3. **Mitigasi Kekosongan Barang (Stock-out Risk)**: Mengidentifikasi produk dengan stok kritis (`< 3 unit`) atau habis (`0 unit`) untuk memicu peringatan dini tindakan pemesanan ulang (*Restock Purchase Order*).
4. **Pengalaman Pengguna Kelas Enterprise**: Menghadirkan dashboard SaaS modern dengan filter interaktif, pencarian instan, sorting dinamis, export data CSV, print report, dan detail drawer/modal tanpa me-reload halaman.

---

## 🚀 Fitur-Fitur Utama

### 1. Dynamic Summary KPI Cards
- **Total Varian Produk**: Menghitung total varian SKU yang terdaftar via `hitungTotalProduk($products)`.
- **Total Unit Stok Fisik**: Akumulasi seluruh unit komoditas riil di gudang via `hitungTotalStok($products)`.
- **Valuasi Aset Persediaan**: Akumulasi nilai nominal rupiah seluruh stok via `hitungTotalNilaiStok($products)` dan diformat dengan `formatRupiah()`.
- **Indikator Produk Kritis**: Jumlah komoditas dengan stok di bawah ambang batas `< 3 unit` via `hitungProdukKritis($products)`.

### 2. Visualisasi Kondisi Persediaan (Inventory Overview)
- **Status Health Distribution Bar**: Bar progress multi-segmen proporsional yang memvisualisasikan rasio produk Aman, Menipis, Kritis, dan Habis.
- **Rumpun Komoditas per Kategori**: Ringkasan jumlah SKU, kuantitas unit, dan total nilai kapitalisasi rupiah per kategori produk.

### 3. Tabel Manajemen Inventaris Cerdas
- **Pencarian Real-Time**: Instant search berdasarkan nama perangkat, SKU, maupun deskripsi spesifikasi.
- **Filter Multi-Kriteria**: Penyaringan berdasarkan rumpun kategori (Laptop, Peripherals, Display, Audio, Storage, Networking) dan status stok (Aman, Menipis, Kritis, Habis).
- **Pengurutan Fleksibel (Multi-Column Sorting)**: Mengurutkan berdasarkan ID, Nama Produk (A–Z / Z–A), Harga Satuan (Terendah / Tertinggi), dan Kuantitas Stok (Tersedikit / Terbanyak) baik melalui dropdown maupun klik langsung pada header tabel.
- **Pewarnaan Baris Kondisional (Visual Row Cue)**:
  - 🟢 **Stok Aman (> 5 unit)**: Baris beraksen hijau lembut (`row-aman`).
  - 🟡 **Stok Menipis (3–5 unit)**: Baris beraksen amber/kuning lembut (`row-menipis`).
  - 🔴 **Stok Kritis (< 3 unit)**: Baris beraksen rose/merah lembut (`row-kritis`).
  - ⛔ **Stok Habis (0 unit)**: Baris beraksen merah pekat dengan penanda darurat (`row-habis`).

### 4. Interactive Utilities & Tools
- **Product Quick View Modal**: Membuka dialog rincian teknis lengkap, status persediaan, nilai aset spesifik per produk, serta tombol salin spesifikasi ke clipboard.
- **Client-Side CSV Exporter**: Mengunduh dataset inventaris yang sedang aktif ke berkas `.csv` berstandar UTF-8 dengan BOM (kompatibel langsung dengan Microsoft Excel).
- **Print Friendly Sheet**: Layout cetak rapi yang otomatis menyembunyikan sidebar, topbar, dan tombol interaktif saat pengguna mencetak dokumen laporan.
- **Toast Notification Engine**: Umpan balik visual dinamis untuk setiap aksi pengguna.
- **Responsive Drawer**: Dukungan tampilan optimal pada desktop, tablet, dan smartphone dengan hamburger menu.

---

## 🛠️ Teknologi yang Digunakan

| Komponen | Teknologi | Keterangan |
| :--- | :--- | :--- |
| **Server-Side Engine** | **PHP 8.2+ Native** | Pemrosesan logika bisnis, kalkulasi nilai aset, traversal array, tanpa framework |
| **Markup Language** | **HTML5 Semantik** | Struktur dokumen aksesibel, meta viewport, tag semantik |
| **Styling & Design** | **CSS3 Murni** | CSS Custom Properties (Variables), Flexbox, CSS Grid, Media Queries, Dark Navy & Emerald theme |
| **Client-Side Script** | **Vanilla JavaScript (ES6+)** | Manipulasi DOM, search filter, sorting, modal dialog, export CSV, no libraries |
| **Data Structure** | **Multidimensional Associative Array** | Representasi relasional baris-kolom dalam memori runtime |
| **Security Layer** | **htmlspecialchars()** | Proteksi menyeluruh terhadap serangan *Cross-Site Scripting (XSS)* |

---

## 📁 Struktur Folder & Berkas

Struktur project dibangun secara modular dengan mematuhi prinsip *Separation of Concerns (SoC)*:

```text
stockwise/
│
├── index.php                 # Presentation Layer (Main entry point, integrasi & render UI)
├── products.php              # Data Layer (Multidimensional Associative Array katalog produk)
├── functions.php             # Processing Layer (Fungsi kalkulasi bisnis & helper formatting)
├── config.php                # Configuration (Konstanta global, error reporting, timezone)
│
├── includes/                 # Modular Layout Components
│   ├── header.php            # Head tag, Google Fonts, topbar navigasi & profile
│   ├── sidebar.php           # Navigasi Dark Navy, brand logo & status runtime PHP
│   └── footer.php            # Footer aplikasi, modal dialog markup & toast container
│
├── assets/                   # Static Frontend Assets
│   ├── css/
│   │   └── style.css         # Custom SaaS design system stylesheet
│   ├── js/
│   │   └── script.js         # Vanilla JS controller (search, sort, filter, export, modal)
│   └── images/               # Direktori aset gambar & media
│
├── README.md                 # Dokumentasi komprehensif repositori GitHub
└── .gitignore                # Berkas filter pengabaian Git (OS files, IDE configs)
```

---

## 🏛️ Arsitektur Sistem (Separation of Concerns)

Berdasarkan silabus **Pertemuan 2: PHP Fundamental & Data Structure (Slide 14 & 17)**, aplikasi dipecah menjadi tiga lapisan modular:

```
┌────────────────────────────────────────────────────────────────────────┐
│                   PRESENTATION LAYER (index.php)                       │
│  - Merajut komponen via require_once                                   │
│  - Traversal kolektif via foreach loop                                 │
│  - Sanitasi keamanan via htmlspecialchars()                            │
└─────────────────────────────────┬──────────────────────────────────────┘
                                  │
         ┌────────────────────────┴────────────────────────┐
         ▼                                                 ▼
┌──────────────────────────────────┐      ┌──────────────────────────────┐
│  DATA LAYER (products.php)       │      │ PROCESSING LAYER             │
│  - $products array multidimensi  │      │ (functions.php)              │
│  - ID, Nama, Kategori,           │      │ - hitungTotalNilaiStok()     │
│    Harga, Stok, Deskripsi        │      │ - hitungProdukKritis() (< 3) │
│  - Bebas dari logika tampilan    │      │ - tentukanStatusStok()       │
└──────────────────────────────────┘      └──────────────────────────────┘
```

### A. Data Layer (`products.php`)
Menyimpan koleksi data produk dalam bentuk array multidimensi asosiatif. Mengeliminasi dependensi database luar dan memfasilitasi penambahan komoditas baru secara modular tanpa perlu mengubah baris logika pemrosesan maupun tampilan antarmuka.

### B. Processing Layer (`functions.php`)
Pusat eksekusi aturan bisnis (*Business Logic*) yang menerapkan prinsip **Single Responsibility Principle (SRP)**. Setiap fungsi hanya memegang satu tugas spesifik yang terisolasi dan mengembalikan nilai (*return value*) murni.

### C. Presentation Layer (`index.php` & `includes/`)
Bertanggung jawab mengubah data mentah dan hasil kalkulasi menjadi representasi visual HTML5 yang aman dikonsumsi oleh peramban pengguna.

---

## 🧠 Penjelasan Mendalam Logika Bisnis

### 1. Perhitungan Total Nilai Aset Persediaan: `hitungTotalNilaiStok()`

Fungsi ini merealisasikan rumus matematika akumulasi nilai buku inventaris gudang:

$$\text{Total Nilai Aset} = \sum_{i=1}^{n} \left( \text{harga}_i \times \text{stok}_i \right)$$

#### Implementasi Kode:
```php
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
```

- **Mekanisme Kerja**: Menginisialisasi akumulator `$totalNilai = 0`. Melakukan traversal pada setiap baris produk, mengonversi nilai menjadi tipe data numerik (`float` dan `int`) demi menjaga ketelitian presisi aritmatika, mengalikan `harga * stok`, lalu menambahkan hasilnya ke dalam variabel akumulator.
- **Contoh Kasus**: Jika terdapat Laptop berharga Rp 32.500.000 dengan stok 8 unit, maka kontribusi nilai aset untuk produk tersebut adalah $32.500.000 \times 8 = \text{Rp } 260.000.000$. Seluruh nilai produk dijumlahkan secara linear.

---

### 2. Evaluasi Kondisi Stok Kritis: `tentukanStatusStok()`

Aturan perkuliahan mewajibkan penentuan stok kritis dievaluasi dengan kondisi tegas **`$stok < 3`**. 

Struktur percabangan linear `if-elseif-else` disusun secara berurutan dari kondisi yang paling restriktif:

```php
function tentukanStatusStok($stok) {
    $stok = (int)$stok;
    
    if ($stok === 0) {
        return "Habis";      // Kondisi 1: Stok kosong sama sekali
    } elseif ($stok < 3) {
        return "Kritis";     // Kondisi 2: Stok 1 atau 2 unit (Instruksi Dosen: $stok < 3)
    } elseif ($stok <= 5) {
        return "Menipis";    // Kondisi 3: Stok 3, 4, atau 5 unit
    } else {
        return "Aman";       // Kondisi 4: Stok lebih dari 5 unit
    }
}
```

#### Tabel Pengujian Nilai Ambang Batas (Boundary Value Testing):

| Kuantitas Stok ($stok) | Hasil Evaluasi | Status Baris Tabel | Keterangan Operasional |
| :---: | :---: | :---: | :--- |
| **0** | `Habis` | `row-habis` (Aksen Merah Pekat) | Barang kosong di gudang; transaksi jual beli terhenti |
| **1** | `Kritis` | `row-kritis` (Aksen Rose Lembut) | Berada di bawah batas minimal (< 3); harus segera PO |
| **2** | `Kritis` | `row-kritis` (Aksen Rose Lembut) | Berada di bawah batas minimal (< 3); prioritas pemesanan |
| **3** | `Menipis` | `row-menipis` (Aksen Kuning Lembut) | Batas awal zona peringatan (3–5 unit) |
| **5** | `Menipis` | `row-menipis` (Aksen Kuning Lembut) | Batas atas zona peringatan (3–5 unit) |
| **6** | `Aman` | `row-aman` (Aksen Hijau Lembut) | Pasokan aman (> 5 unit); operasional lancar |
| **18** | `Aman` | `row-aman` (Aksen Hijau Lembut) | Pasokan melimpah |

---

## 💻 Panduan Instalasi & Menjalankan Aplikasi

Aplikasi dapat dijalankan secara instan di lingkungan lokal menggunakan software web server populer seperti **XAMPP**, **Laragon**, maupun **PHP CLI bawaan**.

### Opsi A: Menggunakan XAMPP (Apache)

1. **Unduh / Salin Berkas**:
   Salin folder project `stockwise` ke dalam direktori publik web server XAMPP Anda:
   - **Windows**: `C:\xampp\htdocs\stockwise`
   - **macOS**: `/Applications/XAMPP/htdocs/stockwise`
   - **Linux**: `/opt/lampp/htdocs/stockwise`

2. **Jalankan Apache**:
   Buka **XAMPP Control Panel**, lalu klik tombol **Start** pada modul **Apache** (MySQL tidak perlu dijalankan).

3. **Buka di Browser**:
   Buka peramban web (Chrome, Edge, Firefox, Safari) dan akses tautan:
   ```
   http://localhost/stockwise/
   ```

---

### Opsi B: Menggunakan PHP Built-in CLI Server

Jika Anda telah menginstal PHP di komputer Anda, Anda dapat menjalankan server lokal langsung dari terminal tanpa perlu menginstal XAMPP:

1. Buka Terminal / PowerShell / Command Prompt.
2. Masuk ke direktori project:
   ```bash
   cd path/ke/stockwise
   ```
3. Jalankan server bawaan PHP:
   ```bash
   php -S localhost:8000
   ```
4. Buka browser dan akses alamat:
   ```
   http://localhost:8000
   ```

---

## 📸 Tampilan Antarmuka (Preview & Screenshots)

> *Area penempatan dokumentasi tangkapan layar antarmuka pengguna (UI) aplikasi:*

### 1. Dashboard Utama & KPI Metric Cards
*(Menampilkan 4 kartu statistik ringkasan, banner peringatan kritis, dan visualisasi distribusi kesehatan persediaan)*

```
[ Preview Screenshot Dashboard Utama ]
```

### 2. Tabel Katalog & Pengendalian Persediaan
*(Menampilkan tabel produk berpenanda warna kondisional, filter kategori, pencarian real-time, dan status badge)*

```
[ Preview Screenshot Tabel Inventaris ]
```

### 3. Modal Quick View & Monitoring Stok Kritis
*(Menampilkan drawer detail perangkat teknis, kalkulasi nilai aset produk tunggal, dan kartu tindakan restock logistik)*

```
[ Preview Screenshot Quick View Modal ]
```

---

## 🎓 Pembahasan Evaluatif & Konseptual Kuliah

Bagian ini membahas pertanyaan evaluatif penalaran analitis dari **Slide 18 (Pertemuan 2: PHP Fundamental & Data Structure)**:

### 1. Mengapa associative array dinilai jauh lebih representatif dan aman untuk memetakan spesifikasi detail atribut produk dibanding indexed array?
- **Semantik dan Keterbacaan (*Readability*)**: Pada *associative array*, setiap nilai dipetakan ke *string key* yang memiliki makna semantik (misalnya `$produk['harga']` atau `$produk['stok']`). Sebaliknya, *indexed array* hanya mengandalkan urutan bilangan bulat (`$produk[3]`).
- **Resistensi terhadap Perubahan Struktur**: Jika di masa mendatang developer menyisipkan atribut baru (misalnya `'garansi'`), kode yang menggunakan *associative array* tidak akan rusak karena pemanggilan atribut didasarkan pada nama *key*, bukan nomor indeks urutan yang bergeser.

### 2. Berikan analisis konsekuensi fatal yang terjadi jika seorang developer ceroboh menggunakan include dibandingkan require untuk memuat file konfigurasi atau database vendor!
- **Level Kesalahan**: Perintah `include` hanya memicu tingkat keparahan **WARNING** saat berkas target tidak ditemukan, dan PHP akan tetap memaksakan eksekusi baris-baris kode di bawahnya. Sebaliknya, `require` / `require_once` memiliki toleransi nol dan langsung memicu **FATAL ERROR** yang seketika menghentikan eksekusi script.
- **Konsekuensi Fatal**: Jika file konfigurasi kredensial koneksi gagal dimuat dengan `include`, instruksi query database berikutnya akan tetap dipanggil dengan variabel koneksi bernilai `NULL`. Hal ini akan memicu rentetan error sistem lanjutan, berpotensi membocorkan galat internal ke layar pengguna (*information disclosure*), atau merusak integritas alur logika program secara diam-diam (*silent failure*).

### 3. Mengapa penanganan galat logika (logic error) memakan durasi pencarian yang jauh lebih lama dan sulit dideteksi dibandingkan dengan kesalahan sintaksis (syntax error)?
- **Tidak Memiliki Jejak Laporan Mesin**: *Syntax error* dideteksi langsung oleh PHP parser pada tahap kompilasi (*compile-time*), lengkap dengan pesan galat, nama file, dan koordinat nomor baris yang presisi.
- **Sistem Berjalan Namun Cacat**: Pada *logic error*, kode memiliki sintaks yang valid 100% sehingga PHP mengeksekusinya tanpa peringatan apapun. Namun hasil kalkulasi atau alur bisnis yang dihasilkan keliru (misalnya salah menulis operator relasional `$stok > 3` alih-alih `$stok < 3`). Untuk melacaknya, developer harus melakukan *State Inspection* manual langkah demi langkah menggunakan `var_dump()` atau `print_r()`.

### 4. Tinjau dari sudut pandang optimasi memori: Apa bahaya struktural jangka panjang jika arsitektur database direplikasi ke dalam multidimensional array yang tingkat bersarangnya (nesting) terlalu dalam?
- **Konsumsi Memori Skala Besar (*Memory Overhead*)**: Setiap struktur array PHP di level internal C (*Zend Engine*) dibungkus dalam struktur *HashTable* dan `zval` yang membutuhkan alokasi memori metadata tersendiri.
- **Ketiadaan Fitur Indexing & Query Planner**: RDBMS memiliki *B-Tree Indexing* dan *Query Optimizer* yang efisien. Array PHP bersarang dalam membutuhkan operasi pencarian $O(N)$ atau bahkan $O(N^2)$ via loop bertingkat, yang akan membebani CPU server serta meningkatkan risiko melebihi batas konfigurasi `memory_limit` PHP saat dataset bertumbuh menjadi ribuan rekaman.

---

## 📄 Lisensi & Penulis

- **Mata Kuliah**: Pemrograman Web – Pertemuan 2 (PHP Fundamental & Data Structure)
- **Tahun Akademik**: 2026
- **Program Studi**: Sistem Informasi / Teknik Informatika
- **Lisensi**: Proyek ini dilisensikan di bawah lisensi [MIT License](https://opensource.org/licenses/MIT). Terbuka untuk sarana pembelajaran akademik dan referensi portofolio pemrograman web.
