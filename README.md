# 🎫 TixGo E-Ticketing System

> Sistem pemesanan tiket online multi-transportasi berbasis Laravel 12.
> Mendukung 3 role: **User**, **Manager**, **Super Admin**

---

## 📋 Panduan Setup untuk Anggota Tim

### Prasyarat (Harus Sudah Terinstall)
| Software | Versi Minimum | Download |
|----------|---------------|----------|
| PHP | 8.1+ | [php.net](https://www.php.net/) |
| Composer | 2.0+ | [getcomposer.org](https://getcomposer.org/) |
| MySQL | 5.7+ / MariaDB 10+ | Sudah include di Laragon |
| Node.js | 16+ | [nodejs.org](https://nodejs.org/) |
| Laragon | Terbaru | [laragon.org](https://laragon.org/) |
| Git | Terbaru | [git-scm.com](https://git-scm.com/) |

---

### 🚀 Langkah-Langkah Setup (Ikuti BERURUTAN!)

#### 1. Clone Repository
```bash
cd C:\laragon\www
git clone https://github.com/liataliana/TixGo---E-Ticketing-System.git
cd TixGo---E-Ticketing-System
```

#### 2. Install Dependency PHP (Composer)
```bash
composer install
```

#### 3. Install Dependency Frontend (NPM)
```bash
npm install
```

#### 4. Buat File Environment (.env)
```bash
copy .env.example .env
```

#### 5. Generate Application Key
```bash
php artisan key:generate
```

#### 6. Konfigurasi Database
Buka file `.env` dengan text editor (Notepad++ / VS Code), lalu **HILANGKAN tanda `#`** (uncomment) dan ubah bagian database menjadi:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=TixGo
DB_USERNAME=root
DB_PASSWORD=
```

> ⚠️ **PENTING:** Pastikan baris-baris di atas **TIDAK** diawali dengan tanda `#` (pagar). Jika ada `#` di depan, hapus `#` nya!

#### 7. Buat Database di MySQL

**Cara A — Via phpMyAdmin (Mudah):**
1. Buka `http://localhost/phpmyadmin`
2. Klik "New" / "Baru" di sidebar kiri
3. Ketik nama database: `TixGo`
4. Klik "Create" / "Buat"

**Cara B — Via Terminal MySQL:**
```sql
CREATE DATABASE TixGo;
```

#### 8. Jalankan Migrasi Database (PENTING!)
```bash
php artisan migrate
```
> Ini akan membuat semua 15+ tabel beserta constraint (foreign key, unique, dll) secara otomatis.

#### 9. Buat Akun Default untuk Testing
```bash
php artisan tinker
```
Lalu copy-paste SATU PER SATU:
```php
\App\Models\User::create(['name'=>'Super Admin','email'=>'admin@tixgo.com','password'=>bcrypt('password123'),'role'=>'super_admin']);

\App\Models\User::create(['name'=>'Manager TixGo','email'=>'manager@tixgo.com','password'=>bcrypt('password123'),'role'=>'manager']);

\App\Models\User::create(['name'=>'User Demo','email'=>'user@tixgo.com','password'=>bcrypt('password123'),'role'=>'user']);

\App\Models\Flight::create(['airline'=>'Garuda Indonesia','origin'=>'Jakarta','destination'=>'Bali','departure_time'=>'2026-10-15 08:00','arrival_time'=>'2026-10-15 09:30','price'=>1200000,'capacity'=>180,'available_seats'=>45,'status'=>'active']);

\App\Models\Flight::create(['airline'=>'Lion Air','origin'=>'Jakarta','destination'=>'Surabaya','departure_time'=>'2026-10-15 10:00','arrival_time'=>'2026-10-15 11:10','price'=>650000,'capacity'=>150,'available_seats'=>80,'status'=>'active']);

\App\Models\Category::create(['name'=>'Penerbangan','icon'=>'fa-plane','description'=>'Tiket pesawat']);

exit
```

#### 10. Jalankan Server
```bash
php artisan serve
```
Buka browser: **http://127.0.0.1:8000**

---

### 🔑 Akun Login Default (Setelah Langkah 9)

| Role | Email | Password | Halaman Setelah Login |
|------|-------|----------|----------------------|
| Super Admin | `admin@tixgo.com` | `password123` | `/superadmin/dashboard` |
| Manager | `manager@tixgo.com` | `password123` | `/manager/dashboard` |
| User Biasa | `user@tixgo.com` | `password123` | `/user/dashboard` |

---

### 📥 Cara Import Database dari Teman (Jika Mau Pakai Data yang Sudah Ada)

Jika teman sudah punya database TixGo dan ingin kamu pakai datanya:

#### Cara Export (Yang punya database):
1. Buka **phpMyAdmin** (`http://localhost/phpmyadmin`)
2. Klik database **TixGo** di sidebar kiri
3. Klik tab **"Export"** di atas
4. Pilih method: **Quick** (atau Custom untuk pilih tabel tertentu)
5. Format: **SQL**
6. Klik **"Go"** → file `.sql` akan terdownload (contoh: `TixGo.sql`)
7. Kirim file `.sql` ke teman

#### Cara Import (Yang mau pakai):
1. Pastikan sudah buat database `TixGo` (langkah 7 di atas)
2. Buka **phpMyAdmin** → klik database **TixGo**
3. Klik tab **"Import"** di atas
4. Klik **"Choose File"** → pilih file `.sql` yang dikirim teman
5. Klik **"Go"** → tunggu sampai selesai
6. **JANGAN** jalankan `php artisan migrate` lagi (karena tabel sudah ada dari import)

#### Atau Via Terminal (Lebih Cepat):
```bash
# Export:
mysqldump -u root TixGo > TixGo_backup.sql

# Import:
mysql -u root TixGo < TixGo_backup.sql
```

> ⚠️ **PENTING:** Jika pakai import SQL, pastikan TIDAK jalankan `php artisan migrate` karena tabel sudah ada. Kalau mau reset total: `php artisan migrate:fresh` (HATI-HATI: hapus semua data!)

---

## 📊 Struktur Database & Constraints (DDL)

### Diagram Relasi Antar Tabel

```
┌──────────┐     ┌──────────────┐     ┌──────────────┐
│  users   │────<│   bookings   │────<│   payments   │
│──────────│  1:N│──────────────│  1:1│──────────────│
│ id (PK)  │     │ id (PK)      │     │ id (PK)      │
│ name     │     │ user_id (FK) │     │ booking_id   │
│ email(UQ)│     │ flight_id(FK)│     │  (FK)        │
│ password │     │ booking_code │     │ status       │
│ role     │     │  (UNIQUE)    │     │ method       │
└──────────┘     │ total_price  │     │ proof_image  │
                 │ status       │     └──────────────┘
                 └──────┬───────┘
                        │ N:1
                 ┌──────┴───────┐
                 │   flights    │
                 │──────────────│
                 │ id (PK)      │
                 │ airline      │
                 │ origin       │
                 │ destination  │
                 │ price        │
                 └──────────────┘

┌──────────────┐     ┌──────────────────┐
│  categories  │────<│  tixgo_tickets   │
│──────────────│  1:N│──────────────────│
│ id (PK)      │     │ id (PK)          │
│ name         │     │ category_id (FK) │
│ icon         │     │ ticket_code (UQ) │
│ description  │     │ name             │
└──────────────┘     │ price (CHECK>0)  │
                     │ stock            │
                     │ is_active        │
                     └──────────────────┘
```

### Daftar Constraints (PENTING untuk Tugas RDBMS!)

#### File: `database/migrations/` — Screenshot semua file di folder ini

| Tabel | Constraint | Jenis | Penjelasan | File Migration |
|-------|-----------|-------|------------|----------------|
| `users` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik setiap user | Bawaan Laravel |
| `users` | `email` | **UNIQUE** | Email tidak boleh duplikat | Bawaan Laravel |
| `users` | `role` | **DEFAULT 'user'** | Role default = user biasa | `2026_08_07_021828_alter_role_column_in_users_table.php` |
| `flights` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik penerbangan | `2026_07_24_010700_create_flights_table.php` |
| `flights` | `price` | **DECIMAL(12,2)** | Harga max 12 digit, 2 desimal | `2026_07_24_010700_create_flights_table.php` |
| `flights` | `status` | **DEFAULT 'active'** | Status default aktif | `2026_07_24_010700_create_flights_table.php` |
| `bookings` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik booking | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `user_id` | **FOREIGN KEY** → `users.id` | Siapa yang booking | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `flight_id` | **FOREIGN KEY** → `flights.id` | Penerbangan mana | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `booking_code` | **UNIQUE** | Kode booking unik (TIX-XXXXX) | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `user_id` | **ON DELETE CASCADE** | Hapus user → hapus booking-nya | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `flight_id` | **ON DELETE SET NULL** | Hapus flight → booking tetap ada | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `status` | **ENUM('pending','confirmed','cancelled')** | Hanya 3 nilai yang valid | `2026_07_24_010702_create_bookings_table.php` |
| `bookings` | `jumlah_penumpang` | **DEFAULT 1** | Minimal 1 penumpang | `2026_08_02_134456_add_train_columns_to_bookings_table.php` |
| `payments` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik pembayaran | `2026_07_24_010704_create_payments_table.php` |
| `payments` | `booking_id` | **FOREIGN KEY** → `bookings.id` | Untuk booking mana | `2026_08_02_105114_add_booking_id_to_payments_table.php` |
| `payments` | `booking_id` | **ON DELETE CASCADE** | Hapus booking → hapus payment | `2026_08_02_105114_add_booking_id_to_payments_table.php` |
| `payments` | `status` | **DEFAULT 'pending'** | Status default pending | `2026_08_02_093513_fix_payments_columns.php` |
| `categories` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik kategori | `2026_08_07_010001_create_categories_table.php` |
| `categories` | `name` | **VARCHAR(100)** | Max 100 karakter | `2026_08_07_010001_create_categories_table.php` |
| `tixgo_tickets` | `id` | **PRIMARY KEY** (Auto Increment) | ID unik tiket | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `category_id` | **FOREIGN KEY** → `categories.id` | Kategori tiket | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `category_id` | **ON DELETE CASCADE** | Hapus kategori → hapus tiket | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `ticket_code` | **UNIQUE, VARCHAR(20)** | Kode tiket unik | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `price` | **CHECK (price > 0)** | Harga harus lebih dari 0 | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `is_active` | **BOOLEAN, DEFAULT true** | Tiket aktif/tidak | `2026_08_07_010002_create_tixgo_tickets_table.php` |
| `tixgo_tickets` | `stock` | **DEFAULT 0** | Stok default = 0 | `2026_08_07_010002_create_tixgo_tickets_table.php` |

> 💡 **Untuk screenshot constraints:** Buka phpMyAdmin → Klik tabel → Tab "Structure" (lihat kolom & tipe data) dan Tab "Relation view" (lihat Foreign Key)

---

## 🗂️ Kolom Aktual Setiap Tabel di Database

| Tabel | Kolom |
|-------|-------|
| **users** | `id, name, email, email_verified_at, password, role, airline_id, remember_token, created_at, updated_at` |
| **flights** | `id, airline, origin, destination, departure_time, arrival_time, price, capacity, available_seats, status, created_at, updated_at` |
| **bookings** | `id, booking_code, user_id, flight_id, total_price, status, category, nama_penumpang, nomor_ktp, email, no_telp, jumlah_penumpang, created_at, updated_at` |
| **payments** | `id, booking_id, status, method, proof_image, created_at, updated_at` |
| **categories** | `id, name, icon, description, created_at, updated_at` |
| **tixgo_tickets** | `id, category_id, ticket_code, name, description, price, stock, location, event_date, image, is_active, created_at, updated_at` |

---

## 👥 Tugas & Hak Akses Per Role

### 👤 USER (Pengguna Biasa)
**Tugas utama:** Mencari dan memesan tiket transportasi

| No | Fitur | URL | Keterangan |
|----|-------|-----|------------|
| 1 | Dashboard Pribadi | `/user/dashboard` | Lihat statistik & riwayat booking |
| 2 | Cari Penerbangan | `/flights` | Cari berdasarkan asal, tujuan, tanggal |
| 3 | Cari Hotel | `/hotels` | Cari & lihat hotel tersedia |
| 4 | Cari Villa | `/villas` | Cari & lihat villa tersedia |
| 5 | Cari Kereta Api | `/trains` | Cari jadwal kereta |
| 6 | Cari Bus & Travel | `/buses` | Cari jadwal bus |
| 7 | Booking Tiket | `/bookings/create/{id}` | Isi data penumpang & pesan |
| 8 | Checkout & Bayar | `/bookings/checkout/{id}` | Pilih metode pembayaran |
| 9 | Pesanan Saya | `/user/orders` | Lihat semua pesanan & status |
| 10 | Download E-Ticket | `/bookings/download/{id}` | Download setelah dikonfirmasi Manager |

**❌ User TIDAK BISA:**
- Menambah/edit/hapus penerbangan
- Konfirmasi pembayaran
- Kelola user lain
- Akses halaman Manager atau Super Admin

---

### 👨‍💼 MANAGER
**Tugas utama:** Mengelola jadwal penerbangan & memverifikasi pembayaran

| No | Fitur | URL | Keterangan |
|----|-------|-----|------------|
| 1 | Dashboard Manager | `/manager/dashboard` | Statistik: jumlah penerbangan, pembayaran pending, total user |
| 2 | Kelola Penerbangan | `/manager/flights` | **TAMBAH** jadwal baru (asal, tujuan, waktu, harga) + lihat daftar |
| 3 | Konfirmasi Pembayaran | `/manager/payments` | **VERIFIKASI** pembayaran user yang pending → ubah jadi confirmed |
| 4 | Lihat Data User | `/manager/users` | Lihat daftar user terdaftar (read-only) |
| 5 | Kelola Tiket TixGo | `/manager/tickets` | **CRUD** tiket (tambah, edit, hapus tiket) |

**❌ Manager TIDAK BISA:**
- Ubah role user
- Hapus user
- Akses halaman Super Admin
- Lihat laporan keseluruhan sistem

---

### 🛡️ SUPER ADMIN
**Tugas utama:** Mengelola seluruh sistem, user, dan melihat laporan

| No | Fitur | URL | Keterangan |
|----|-------|-----|------------|
| 1 | Dashboard Super Admin | `/superadmin/dashboard` | Statistik lengkap: pendapatan, tiket terjual, total user, pembayaran pending |
| 2 | Kelola User | `/superadmin/users` | **CRUD User**: lihat, ubah role, hapus user |
| 3 | Ubah Role User | `/superadmin/users` | Ganti role: user ↔ manager ↔ super_admin |
| 4 | Lihat Penerbangan | `/superadmin/flights` | Lihat semua penerbangan (read-only) |
| 5 | Lihat Semua Pembayaran | `/superadmin/payments` | Lihat SEMUA transaksi (pending + confirmed + cancelled) |
| 6 | Laporan Sistem | `/superadmin/reports` | Statistik per role, total pendapatan, tingkat konfirmasi, daftar user |
| 7 | Kelola Tiket TixGo | `/superadmin/tickets` | **CRUD** tiket (sama seperti Manager) |

**✅ Super Admin BISA SEMUA** — akses penuh ke seluruh sistem

---

## 🔄 Alur Kerja Sistem (User Manual)

### Alur Pemesanan Tiket (User)
```
1. User LOGIN
      ↓
2. Pilih kategori di halaman utama
   (Penerbangan / Hotel / Villa / Kereta / Bus)
      ↓
3. Cari berdasarkan kota asal, tujuan, tanggal
      ↓
4. Pilih jadwal/penginapan yang diinginkan
      ↓
5. Isi form booking (nama, KTP, email, telepon, jumlah)
      ↓
6. Checkout → Pilih metode pembayaran (Transfer Bank / E-Wallet)
      ↓
7. Bayar → Status booking = PENDING 🟡
      ↓
8. ⏳ Menunggu Manager konfirmasi...
      ↓
9. Setelah dikonfirmasi → Status = CONFIRMED 🟢
      ↓
10. Download E-Ticket ✈️ di halaman "Pesanan Saya"
```

### Alur Konfirmasi Pembayaran (Manager)
```
1. Manager LOGIN → Dashboard
      ↓
2. Lihat berapa pembayaran yang menunggu konfirmasi
      ↓
3. Buka halaman "Konfirmasi Pembayaran"
      ↓
4. Cek data: Pemesan, Kode Booking, Jumlah bayar, Metode
      ↓
5. Klik tombol "Konfirmasi" ✅
      ↓
6. Otomatis:
   • Payment.status → confirmed
   • Booking.status → confirmed
      ↓
7. User sekarang bisa download E-Ticket
```

### Alur Kelola Sistem (Super Admin)
```
1. Super Admin LOGIN → Dashboard (lihat ringkasan seluruh sistem)
      ↓
2. Kelola User:
   • Lihat semua user terdaftar
   • Ubah role (user → manager, manager → super_admin, dll)
   • Hapus user yang tidak diperlukan
      ↓
3. Pantau Pembayaran:
   • Lihat SEMUA transaksi (pending, confirmed, cancelled)
   • Monitor jumlah transaksi
      ↓
4. Lihat Laporan:
   • Total admin, manager, user
   • Total pendapatan (hanya yang confirmed)
   • Tingkat konfirmasi (%)
   • Detail tabel semua user + jumlah pemesanan
```

---

## 📁 Struktur Folder Penting

```
TixGo---E-Ticketing-System/
├── app/
│   ├── Http/Controllers/       ← Semua logika backend
│   │   ├── BookingController.php    ← Proses pemesanan & pembayaran
│   │   ├── FlightController.php     ← Halaman pencarian penerbangan
│   │   ├── HotelController.php      ← Halaman hotel
│   │   ├── VillaController.php      ← Halaman villa
│   │   ├── TrainController.php      ← Halaman kereta api
│   │   ├── BusController.php        ← Halaman bus & travel
│   │   ├── ManagerController.php    ← Dashboard Manager
│   │   ├── SuperAdminController.php ← Dashboard Super Admin
│   │   ├── UserController.php       ← Dashboard User
│   │   └── TicketController.php     ← CRUD Tiket
│   └── Models/                 ← Model database
│       ├── User.php            ← Model user + relasi bookings()
│       ├── Flight.php          ← Model penerbangan
│       ├── Booking.php         ← Model booking + relasi user(), flight(), payment()
│       ├── Payment.php         ← Model pembayaran + relasi booking()
│       ├── Category.php        ← Model kategori tiket
│       ├── TixgoTicket.php     ← Model tiket TixGo
│       └── ActivityLog.php     ← Model log aktivitas manager/admin [BARU]
│
├── database/
│   └── migrations/             ← 26 file migrasi (DDL + constraints)
│       ├── create_flights_table        ← Tabel penerbangan
│       ├── create_bookings_table       ← Tabel booking (FK ke users, flights)
│       ├── create_payments_table       ← Tabel pembayaran (FK ke bookings)
│       ├── create_categories_table     ← Tabel kategori
│       ├── create_tixgo_tickets_table  ← Tabel tiket (FK ke categories)
│       ├── create_activity_logs_table  ← Tabel log aktivitas [BARU]
│       └── ... (lihat tabel constraints di atas)
│
├── resources/views/            ← Semua halaman tampilan
│   ├── layouts/
│   │   ├── app.blade.php       ← Layout admin (sidebar Manager & SuperAdmin)
│   │   └── user.blade.php      ← Layout user (navbar hijau premium)
│   ├── home.blade.php          ← Landing page (5 kategori card 3D)
│   ├── user/                   ← Halaman khusus role User
│   ├── manager/                ← Halaman khusus role Manager
│   │   └── tickets/index.blade.php  ← Tab filter: Hotel/Villa/Bus/Kereta
│   ├── superadmin/             ← Halaman khusus role Super Admin
│   │   ├── create-manager.blade.php ← Form tambah akun manager [BARU]
│   │   ├── activity-log.blade.php   ← Log aktivitas manager [BARU]
│   │   └── tickets/index.blade.php  ← Tab filter: Hotel/Villa/Bus/Kereta
│   ├── flights/                ← Halaman penerbangan (publik)
│   ├── hotels/, villas/, trains/, buses/  ← Halaman kategori lain
│   └── bookings/               ← Alur booking (create → checkout → success → eticket)
│
├── routes/
│   └── web.php                 ← Semua URL route + middleware role
│
├── .env.example                ← Template konfigurasi
├── alur_kerja.md               ← Dokumentasi alur kerja (Mermaid diagrams)
└── README.md                   ← File ini!
```

---

## 🗄️ Panduan Export & Import Database (SQL)

> Bagian ini untuk teman tim agar bisa menyambungkan database dengan project ini.

### 📤 Export Database (dari komputer kamu)

#### Cara 1: Via phpMyAdmin (mudah)
1. Buka `http://localhost/phpmyadmin`
2. Pilih database **TixGo** di sidebar kiri
3. Klik tab **Export**
4. Format: **SQL** → centang "Add DROP TABLE"
5. Klik **Go** → file `.sql` akan ter-download
6. Kirim file `.sql` ke teman (via Google Drive, WhatsApp, dll)

#### Cara 2: Via Command Line (lebih cepat)
```bash
# Export seluruh database
mysqldump -u root -p TixGo > TixGo_backup.sql

# Atau tanpa password (Laragon default):
mysqldump -u root TixGo > TixGo_backup.sql
```

---

### 📥 Import Database (di komputer teman)

#### Cara 1: Via phpMyAdmin
1. Buka `http://localhost/phpmyadmin`
2. Buat database baru bernama **TixGo** (klik "New" di sidebar)
3. Klik database **TixGo** → tab **Import**
4. Pilih file `.sql` yang diterima → klik **Go**
5. Selesai! Semua tabel + data sudah masuk.

#### Cara 2: Via Command Line
```bash
# Buat database dulu
mysql -u root -e "CREATE DATABASE TixGo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Import file SQL
mysql -u root TixGo < TixGo_backup.sql
```

#### Cara 3: Via Laravel Migration (tanpa file SQL)
```bash
# Clone project terlebih dahulu, lalu:
php artisan migrate
php artisan db:seed   # (jika ada seeder)
```

---

### 🗂️ Tabel Database & Constraints

| Tabel | Constraint Utama | Migration File |
|-------|-----------------|----------------|
| `users` | PK: id, UNIQUE: email, ENUM: role | `create_users_table` |
| `flights` | PK: id, NOT NULL: origin, destination, price | `create_flights_table` |
| `bookings` | PK: id, FK: user_id→users, FK: flight_id→flights (SET NULL), UNIQUE: booking_code | `create_bookings_table` |
| `payments` | PK: id, FK: booking_id→bookings (CASCADE), ENUM: status | `create_payments_table` |
| `categories` | PK: id, UNIQUE: name | `create_categories_table` |
| `tixgo_tickets` | PK: id, FK: category_id→categories (CASCADE), UNIQUE: ticket_code | `create_tixgo_tickets_table` |
| **`activity_logs`** | PK: id, FK: user_id→users (CASCADE) | `2026_09_30_200000_create_activity_logs_table` |

### Penjelasan Relasi (ERD Sederhana)
```
users ──< bookings >── flights
           │
           └──< payments

categories ──< tixgo_tickets

users ──< activity_logs
```

---

## 👥 Role & Tugas Masing-Masing

| Fitur | 👤 User | 👔 Manager | 🛡️ Super Admin |
|-------|---------|-----------|----------------|
| Cari & Pesan Tiket (5 kategori) | ✅ | ❌ | ❌ |
| Checkout & Bayar | ✅ | ❌ | ❌ |
| Lihat Pesanan & E-Ticket | ✅ | ❌ | ❌ |
| Konfirmasi Pembayaran | ❌ | ✅ | ❌ |
| Tambah Jadwal Penerbangan | ❌ | ✅ | ❌ |
| Kelola Tiket (per kategori) | ❌ | ✅ | ✅ |
| Lihat Daftar Member (role=user saja) | ❌ | ✅ | ❌ |
| Lihat SEMUA User (semua role) | ❌ | ❌ | ✅ |
| Tambah Akun Manager / Admin | ❌ | ❌ | ✅ |
| Ubah Role User | ❌ | ❌ | ✅ |
| Hapus User | ❌ | ❌ | ✅ |
| Log Aktivitas Manager | ❌ | ❌ | ✅ |
| Pantau Pembayaran (semua) | ❌ | ❌ | ✅ |
| Laporan & Statistik | ❌ | ❌ | ✅ |

---

## ⚠️ Troubleshooting Umum

| Error | Penyebab | Solusi |
|-------|----------|--------|
| `500 Server Error` | APP_KEY belum ada | `php artisan key:generate` |
| `Table doesn't exist` | Migrasi belum dijalankan | `php artisan migrate` |
| `Database 'laravel' not found` | DB_DATABASE di .env salah | Ubah jadi `DB_DATABASE=TixGo` |
| `419 Page Expired` | CSRF token expired | Refresh halaman (F5) |
| `Class not found` | Autoload belum update | `composer dump-autoload` |
| `View not found` | Cache lama | `php artisan optimize:clear` |
| `Column not found` | Kolom salah di code | Jalankan `php artisan migrate` |
| `activity_logs table not found` | Migration baru belum jalan | `php artisan migrate` |

---

### 🤝 Kontributor
- **Magfi Adi Radza Putra** (Heikkakeren) — Lead Developer

---

© 2026 TixGo E-Ticketing System
