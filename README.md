# 🎫 TixGo E-Ticketing System

> Sistem pemesanan tiket online multi-transportasi berbasis Laravel.

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
Buka terminal MySQL (lewat Laragon > Menu > MySQL > Console), lalu:
```sql
CREATE DATABASE TixGo;
```
Atau buka **phpMyAdmin** (`http://localhost/phpmyadmin`), lalu buat database baru bernama `TixGo`.

#### 8. Jalankan Migrasi Database
```bash
php artisan migrate
```

#### 9. (Opsional) Buat Akun Default untuk Testing
```bash
php artisan tinker
```
Lalu ketik satu per satu:
```php
// Buat Super Admin
\App\Models\User::create(['name'=>'Super Admin','email'=>'admin@tixgo.com','password'=>bcrypt('password123'),'role'=>'super_admin']);

// Buat Manager
\App\Models\User::create(['name'=>'Manager TixGo','email'=>'manager@tixgo.com','password'=>bcrypt('password123'),'role'=>'manager']);

// Buat User Biasa
\App\Models\User::create(['name'=>'User Demo','email'=>'user@tixgo.com','password'=>bcrypt('password123'),'role'=>'user']);

// Tambah data penerbangan demo
\App\Models\Flight::create(['airline'=>'Garuda Indonesia','origin'=>'Jakarta','destination'=>'Bali','departure_time'=>'2026-10-15 08:00','arrival_time'=>'2026-10-15 09:30','price'=>1200000,'capacity'=>180,'available_seats'=>45,'status'=>'active']);

\App\Models\Flight::create(['airline'=>'Lion Air','origin'=>'Jakarta','destination'=>'Surabaya','departure_time'=>'2026-10-15 10:00','arrival_time'=>'2026-10-15 11:10','price'=>650000,'capacity'=>150,'available_seats'=>80,'status'=>'active']);

exit
```

#### 10. Jalankan Server
```bash
php artisan serve
```
Buka browser: **http://127.0.0.1:8000**

---

### 🔑 Akun Login Default (Setelah Langkah 9)

| Role | Email | Password |
|------|-------|----------|
| Super Admin | `admin@tixgo.com` | `password123` |
| Manager | `manager@tixgo.com` | `password123` |
| User Biasa | `user@tixgo.com` | `password123` |

---

### 📁 Struktur Folder Penting

```
TixGo---E-Ticketing-System/
├── app/
│   ├── Http/Controllers/       ← Semua logika backend (controller)
│   │   ├── BookingController.php    ← Proses pemesanan & pembayaran
│   │   ├── FlightController.php     ← Halaman pencarian penerbangan
│   │   ├── HotelController.php      ← Halaman hotel
│   │   ├── VillaController.php      ← Halaman villa
│   │   ├── TrainController.php      ← Halaman kereta api
│   │   ├── BusController.php        ← Halaman bus & travel
│   │   ├── ManagerController.php    ← Dashboard Manager (CRUD + verifikasi)
│   │   ├── SuperAdminController.php ← Dashboard Super Admin
│   │   ├── UserController.php       ← Dashboard User biasa
│   │   └── TicketController.php     ← CRUD Tiket Umum
│   └── Models/                 ← Model database
│       ├── Booking.php, Flight.php, Payment.php, User.php
│
├── database/
│   └── migrations/             ← File-file migrasi database (25 file)
│
├── resources/views/            ← Semua halaman tampilan (Blade)
│   ├── layouts/
│   │   ├── app.blade.php       ← Layout admin (Manager & SuperAdmin)
│   │   └── user.blade.php      ← Layout user (dengan navbar hijau premium)
│   ├── home.blade.php          ← Landing page (5 kategori card 3D)
│   ├── flights/                ← Halaman penerbangan (index, search, show)
│   ├── hotels/                 ← Halaman hotel (index, search)
│   ├── villas/                 ← Halaman villa (index, search)
│   ├── trains/                 ← Halaman kereta api (index, show, search)
│   ├── buses/                  ← Halaman bus (index, search)
│   ├── bookings/               ← Alur booking (create, checkout, success)
│   ├── user/                   ← Dashboard user (dashboard, orders)
│   ├── manager/                ← Dashboard manager
│   └── superadmin/             ← Dashboard super admin
│
├── routes/
│   └── web.php                 ← Semua definisi URL/route
│
├── .env.example                ← Template konfigurasi environment
└── alur_kerja.md               ← Dokumentasi alur kerja per role
```

---

### 📊 Daftar Tabel Database (25 Migrasi)

| No | Tabel | Fungsi |
|----|-------|--------|
| 1 | `users` | Data pengguna (nama, email, password, **role**) |
| 2 | `flights` | Jadwal penerbangan (maskapai, rute, harga, kapasitas) |
| 3 | `bookings` | Data pemesanan tiket (kode booking, penumpang, total harga, status) |
| 4 | `payments` | Data pembayaran (metode, status, bukti bayar) |
| 5 | `categories` | Kategori tiket (penerbangan, kereta, bus, dll) |
| 6 | `tixgo_tickets` | Tiket umum TixGo (CRUD oleh Manager/SuperAdmin) |
| 7 | `carts` | Keranjang belanja |
| 8 | `transactions` | Data transaksi |
| 9 | `transaction_details` | Detail per transaksi |
| 10 | `payment_methods` | Metode pembayaran tersedia |
| 11 | `airlines` | Data maskapai |
| 12 | `airplanes` | Data pesawat |
| 13 | `airports` | Data bandara |
| 14 | `flight_prices` | Harga penerbangan per kelas |
| 15 | `booking_passengers` | Detail penumpang per booking |

---

### 🔄 Alur Kerja Sistem (Ringkasan)

```
👤 USER BIASA                    👨‍💼 MANAGER                   🛡️ SUPER ADMIN
━━━━━━━━━━━━━━━                  ━━━━━━━━━━━━━━               ━━━━━━━━━━━━━━━━
1. Cari tiket                    1. Tambah jadwal             1. Kelola semua akun
2. Pilih jadwal                  2. Edit/hapus jadwal         2. Ubah role pengguna
3. Isi data penumpang            3. Verifikasi pembayaran     3. Lihat laporan
4. Checkout & bayar              4. Kelola data tiket         4. Akses penuh ke semua fitur
5. Tunggu verifikasi Manager
6. Download E-Ticket (setelah dikonfirmasi)
```

---

### ⚠️ Troubleshooting Umum

| Error | Penyebab | Solusi |
|-------|----------|--------|
| `500 Server Error` | APP_KEY belum ada | Jalankan `php artisan key:generate` |
| `Table doesn't exist` | Migrasi belum dijalankan | Jalankan `php artisan migrate` |
| `Database laravel not found` | DB_DATABASE di .env salah | Ubah menjadi `DB_DATABASE=TixGo` dan **uncomment** baris MySQL |
| `419 Page Expired` | CSRF token expired | Refresh halaman (F5), lalu coba lagi |
| `Class not found` | Autoload belum update | Jalankan `composer dump-autoload` |

---

### 🤝 Kontributor
- **Magfi Adi Radza Putra** (Heikkakeren) — Lead Developer

---

© 2026 TixGo E-Ticketing System
