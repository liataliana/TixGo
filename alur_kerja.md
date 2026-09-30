# Alur Kerja (Workflow) Sistem TixGo E-Ticketing

Berikut adalah panduan alur kerja untuk masing-masing role (User Biasa, Manager, dan Super Admin) dalam sistem TixGo. Alur ini menggambarkan bagaimana setiap pengguna berinteraksi dengan sistem mulai dari awal hingga akhir.

---

## 1. Alur Kerja: User Biasa (Pelanggan)

User biasa adalah pelanggan yang ingin memesan tiket. Alur utamanya berpusat pada pencarian, pemesanan, pembayaran, dan mendapatkan E-Ticket.

```mermaid
flowchart TD
    A[Buka Halaman Utama / Landing Page] --> B{Sudah Punya Akun?};
    B -- Belum --> C[Register Akun Baru];
    C --> D[Login sebagai User];
    B -- Sudah --> D;
    
    D --> E[Cari Tiket di Form Pencarian];
    E --> F[Pilih Jadwal yang Tersedia];
    F --> G[Isi Data Penumpang];
    G --> H[Masuk ke Halaman Checkout];
    H --> I[Pilih Metode Pembayaran & Klik Bayar];
    
    I --> J[Status Tiket: PENDING];
    J --> K[Tunggu Manager Mengkonfirmasi Pembayaran];
    
    K --> L[Status Berubah: LUNAS / SUCCESS];
    L --> M[Buka Menu 'Pesanan Saya' di Dashboard];
    M --> N((Download E-Ticket PDF));
```

---

## 2. Alur Kerja: Manager (Admin Operasional)

Manager bertanggung jawab penuh atas operasional sehari-hari. Mulai dari menambah data jadwal transportasi hingga memverifikasi pembayaran dari pelanggan.

```mermaid
flowchart TD
    A[Login sebagai Manager] --> B[Masuk ke Manager Dashboard];
    
    B --> C{Pilih Menu Operasional};
    
    C -- Manajemen Penerbangan --> D[Tambah, Edit, atau Hapus Jadwal Penerbangan];
    C -- Manajemen Tiket Umum --> E[Tambah, Edit, atau Hapus Data Tiket Lainnya];
    
    C -- Verifikasi Pembayaran --> F[Buka Menu Transaksi & Pembayaran];
    F --> G[Lihat Daftar Transaksi User berstatus 'PENDING'];
    G --> H[Cek Bukti Pembayaran User];
    H --> I[Klik Tombol Konfirmasi];
    
    I --> J[Status Transaksi berubah menjadi CONFIRMED];
    J --> K((Sistem Otomatis Menerbitkan E-Ticket User));
```

---

## 3. Alur Kerja: Super Admin (Owner / Sistem Admin)

Super Admin memiliki akses mutlak ke seluruh sistem. Selain bisa melakukan semua tugas Manager, Super Admin juga berhak mengelola hak akses akun pengguna dan melihat laporan pendapatan keseluruhan.

```mermaid
flowchart TD
    A[Login sebagai Super Admin] --> B[Masuk ke Super Admin Dashboard];
    
    B --> C{Pilih Menu Manajemen};
    
    C -- Pantau Statistik --> D[Lihat Laporan Pendapatan, Tiket Terjual, dan Jumlah User];
    
    C -- Manajemen Akses --> E[Buka Menu Manajemen Akun User];
    E --> F[Ubah Role User Biasa menjadi 'Manager' atau 'Super Admin'];
    F --> G[Hapus Akun jika Melanggar Aturan];
    
    C -- Kendali Master Data --> H[Akses Penuh ke CRUD Semua Jadwal & Tiket];
    H --> I((Hapus Data Master jika diperlukan));
```

---

### Ringkasan Relasi Kerja Sama Ketiga Role:
1. **Manager** membuat jadwal tiket.
2. **User Biasa** memesan tiket tersebut dan membayar.
3. **Manager** memverifikasi uang yang masuk dan menerbitkan tiket.
4. **Super Admin** mengawasi seluruh proses (melihat total pendapatan, mendaftarkan Manager baru, atau menghapus pengguna nakal).
