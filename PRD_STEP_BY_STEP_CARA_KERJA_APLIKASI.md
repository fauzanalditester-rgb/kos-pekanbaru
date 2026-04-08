# PRD - STEP BY STEP CARA KERJA APLIKASI
## Aplikasi Manajemen Kos (SewaVIP)

---

## 1. PENDAHULUAN

### 1.1 Deskripsi Aplikasi
**SewaVIP** adalah aplikasi manajemen kos berbasis web yang dirancang untuk membantu pengelola kos dalam mengelola properti, kamar, penyewa, tagihan, pembayaran, dan laporan keuangan. Aplikasi ini memiliki 3 level akses: **Super Admin**, **Admin**, dan **Customer**.

### 1.2 Fitur Utama
- **Multi-role system** (Super Admin, Admin, Customer)
- **Manajemen Properti & Kamar**
- **Manajemen Penyewa**
- **Sistem Tagihan & Pembayaran**
- **Laporan Keuangan**
- **Booking Online (Frontend)**
- **Notifikasi WhatsApp**
- **Reset Password & Ganti Email**

---

## 2. STRUKTUR DATABASE

### 2.1 Tabel Utama

| Tabel | Fungsi |
|-------|--------|
| **users** | Data login untuk Super Admin, Admin, dan Customer |
| **properties** | Data properti/kost |
| **rooms** | Data kamar per properti |
| **tenants** | Data penyewa |
| **invoices** | Data tagihan |
| **payments** | Data pembayaran |
| **finances** | Data pemasukan & pengeluaran |
| **bookings** | Data booking dari frontend |
| **settings** | Konfigurasi sistem |
| **password_resets** | Token reset password |

### 2.2 Relasi Database
```
users (role: customer) ──→ tenants ──→ rooms ──→ properties
                              ↓
                         invoices ←────→ payments
                              ↓
                          finances (laporan)
```

---

## 3. CARA KERJA APLIKASI - STEP BY STEP

### 3.1 TAHAP 1: SETUP AWAL (Super Admin)

#### Langkah 1: Login sebagai Super Admin
```
URL: http://localhost:8000/login-superadmin
Email: (buat baru)
Password: (buat baru)
```

#### Langkah 2: Buat Property (Kost)
1. Masuk menu **Properti**
2. Klik "Tambah Property"
3. Isi data:
   - Nama Property (contoh: "Kost Harmoni Residence")
   - Alamat lengkap
   - Deskripsi
   - Status: Active
4. Klik "Simpan"

#### Langkah 3: Buat Kamar
1. Masuk menu **Kamar**
2. Pilih Property yang sudah dibuat
3. Klik "Tambah Kamar"
4. Isi data per kamar:
   - Kode Kamar (contoh: "A-101", "A-102")
   - Tipe (Standard, Deluxe, Suite)
   - Harga Bulanan
   - Fasilitas (AC, TV, WiFi, dll)
   - Status: Available
5. Klik "Simpan"

**Hasil:** Properti dan kamar sudah tersedia untuk ditempati.

---

### 3.2 TAHAP 2: PENDAFTARAN PENYEWA (Admin/Super Admin)

#### Langkah 1: Tambah Penyewa Baru
1. Masuk menu **Penyewa**
2. Klik "Tambah Penyewa"
3. Isi data penyewa:
   - Nama Lengkap
   - Email (untuk login customer)
   - Nomor Telepon
   - Pilih Kamar (dropdown)
   - Tanggal Masuk
   - Deposit
   - Kontak Darurat
   - Alamat
4. Klik "Simpan"

**Otomatis:**
- Sistem membuat akun Customer dengan email penyewa
- Password default: `password123`
- Kamar status berubah jadi "Occupied"

#### Langkah 2: Buat Tagihan Pertama
1. Masuk menu **Tagihan**
2. Klik "Buat Tagihan"
3. Pilih Penyewa
4. Isi tagihan:
   - Tanggal Terbit: hari ini
   - Jatuh Tempo: 7 hari dari sekarang
   - Harga Sewa (auto-fill dari harga kamar)
   - Tambahan: biaya lain jika ada
   - Deskripsi
5. Status: "Sent" (langsung kirim)
6. Klik "Simpan"

**Otomatis:**
- Nomor invoice generate otomatis (contoh: INV-20250408-0001)
- Total tagihan = sewa + tambahan

#### Langkah 3: Kirim Notifikasi WhatsApp
1. Di daftar tagihan, klik ikon WhatsApp
2. Edit pesan jika perlu:
   ```
   Halo [Nama],
   
   Tagihan Anda:
   No: INV-20250408-0001
   Total: Rp 1.500.000
   Jatuh Tempo: 15 Apr 2026
   
   Mohon segera dibayar.
   Terima kasih.
   ```
3. Klik "Kirim"
4. Sistem redirect ke WhatsApp Web

---

### 3.3 TAHAP 3: PEMBAYARAN (Customer → Admin)

#### A. Cara Bayar (Customer)

##### Langkah 1: Login sebagai Customer
```
URL: http://localhost:8000/login-customer
Email: (email yang didaftarkan admin)
Password: password123
```

##### Langkah 2: Cek Tagihan
1. Masuk menu **Tagihan Saya**
2. Lihat tagihan dengan status "Belum Lunas"
3. Klik "Bayar Sekarang"

##### Langkah 3: Input Pembayaran
1. Pilih metode pembayaran:
   - Transfer Bank
   - Cash (bayar langsung)
   - QRIS
2. Input jumlah pembayaran
3. Upload bukti transfer (jika transfer)
4. Klik "Submit"

**Status Pembayaran:** "Pending" (menunggu verifikasi admin)

#### B. Verifikasi Pembayaran (Admin)

##### Langkah 1: Notifikasi Masuk
- Admin menerima notifikasi: "Pembayaran baru menunggu verifikasi"

##### Langkah 2: Cek Pembayaran
1. Masuk menu **Pembayaran**
2. Filter status: "Pending"
3. Lihat bukti transfer
4. Cek kecocokan data:
   - Nama penyewa
   - Jumlah transfer
   - Tanggal transfer

##### Langkah 3: Verifikasi
1. Klik "Verifikasi"
2. Pilih status: "Verified"
3. Klik "Simpan"

**Otomatis:**
- Tagihan status berubah jadi "Paid"
- Customer dapat notifikasi: "Pembayaran terverifikasi"

---

### 3.4 TAHAP 4: LAPORAN KEUANGAN (Super Admin)

#### Langkah 1: Akses Laporan
1. Login sebagai Super Admin
2. Masuk menu **Laporan**

#### Langkah 2: Filter Data
- Pilih rentang tanggal
- Pilih jenis: Pemasukan / Pengeluaran / Semua

#### Langkah 3: Export Data
1. Klik "Export CSV"
2. File download otomatis
3. Format file:
   ```
   Tanggal, Jenis, Nominal, Keterangan
   2026-04-08, Pemasukan, 1500000, Sewa A-101
   2026-04-08, Pengeluaran, 500000, Maintenance AC
   ```

#### Langkah 4: Analisis
- Grafik pemasukan vs pengeluaran
- Total profit per bulan
- Outstanding (tagihan belum bayar)

---

### 3.5 TAHAP 5: BOOKING ONLINE (Frontend → Admin)

#### A. Customer Booking (Public/Frontend)

##### Langkah 1: Buka Website
```
URL: http://localhost:8000
```

##### Langkah 2: Cek Ketersediaan
1. Scroll ke bagian **Jadwal Ketersediaan**
2. Lihat kalender:
   - 🟢 Hijau: Tersedia
   - 🔴 Merah: Sudah dibooking

##### Langkah 3: Kalkulasi Harga
1. Scroll ke bagian **Estimasi & Booking**
2. Pilih tanggal check-in
3. Pilih tanggal check-out
4. Sistem auto-calculate:
   - Total hari
   - Harga: (minggu × Rp 2jt) + (hari × Rp 350rb)
5. Lihat total estimasi

##### Langkah 4: Booking via WhatsApp
1. Klik "Pesan via WhatsApp"
2. Sistem redirect ke WhatsApp dengan pesan otomatis:
   ```
   Halo, saya ingin booking Kamar VIP:
   📅 Check-in: 10/04/2026
   📅 Check-out: 17/04/2026
   ⏰ Durasi: 7 hari
   💰 Total: Rp 2.000.000
   
   Mohon konfirmasinya. Terima kasih!
   ```
3. Chat dengan admin untuk konfirmasi

#### B. Proses Booking (Admin)

##### Langkah 1: Terima Chat WhatsApp
- Customer kirim pesan booking

##### Langkah 2: Buat Booking di Sistem
1. Masuk menu **Booking**
2. Klik "Tambah Booking"
3. Isi data:
   - Nama Tamu
   - Telepon
   - Check-in & Check-out
   - Status: Confirmed
4. Sistem auto-calculate harga
5. Klik "Simpan"

**Otomatis:**
- Kalender frontend update (tanggal terbooking jadi merah)
- Finance record pemasukan auto-create

---

### 3.6 TAHAP 6: MANAJEMEN PENGGUNA (Super Admin)

#### A. Buat Admin Baru

##### Langkah 1: Akses Manajemen User
1. Login sebagai Super Admin
2. Masuk menu **Users**

##### Langkah 2: Tambah User
1. Klik "Tambah User"
2. Isi data:
   - Nama
   - Email
   - Password
   - Role: Admin
3. Klik "Simpan"

**Hasil:** Admin baru bisa login dengan email tersebut.

#### B. Reset Password User

##### Langkah 1: Cari User
1. Di daftar users, cari user yang lupa password
2. Klik "Reset Password"

##### Langkah 2: Password Baru
1. Sistem generate password random
2. Copy password
3. Kirim ke user via WhatsApp/email

---

### 3.7 TAHAP 7: GANTI PASSWORD & EMAIL (Semua Role)

#### A. Ganti Password (Setelah Login)

##### Langkah 1: Akses Menu Keamanan
- **Customer:** Profil → Keamanan Akun
- **Admin:** Klik avatar di header → dropdown
- **SuperAdmin:** Sidebar → Keamanan

##### Langkah 2: Ganti Password
1. Klik "Ganti Password"
2. Masukkan password saat ini
3. Masukkan password baru (min 8 karakter)
4. Konfirmasi password baru
5. Klik "Simpan"

**Validasi:**
- Password lama harus benar
- Password baru minimal 8 karakter
- Password baru ≠ password lama

#### B. Ganti Email (Setelah Login)

##### Langkah 1: Akses Menu Keamanan
Sama seperti ganti password

##### Langkah 2: Ganti Email
1. Klik "Ganti Email"
2. Masukkan password saat ini (verifikasi)
3. Masukkan email baru
4. Klik "Simpan"

**Validasi:**
- Email baru belum terdaftar di sistem
- Password harus benar

---

### 3.8 TAHAP 8: RESET PASSWORD (Lupa Password)

#### A. Request Reset Password

##### Langkah 1: Akses Halaman Lupa Password
1. Di halaman login, klik "Lupa Password?"
2. Masukkan email terdaftar
3. Klik "Kirim Link Reset"

##### Langkah 2: Cek Email (Simulasi)
1. Link reset dikirim ke email
2. Link valid 60 menit
3. Format link: `/reset-password/{token}?email=user@email.com`

#### B. Reset Password Baru

##### Langkah 1: Buka Link
1. Klik link dari email
2. Masuk ke halaman reset password

##### Langkah 2: Input Password Baru
1. Email auto-fill
2. Masukkan password baru
3. Konfirmasi password
4. Klik "Reset Password"

**Hasil:** Password berhasil diubah, redirect ke halaman login.

---

## 4. ALUR KERJA END-TO-END

### 4.1 Skenario 1: Penyewa Baru (Dari Awal Sampai Aktif)

```
┌─────────────┐    ┌─────────────┐    ┌─────────────┐
│ SUPER ADMIN │    │    ADMIN    │    │   CUSTOMER  │
└──────┬──────┘    └──────┬──────┘    └──────┬──────┘
       │                  │                  │
       ├─[1] Buat Properti                 │
       │   & Kamar                         │
       │                  │                  │
       │                  ├─[2] Tambah      │
       │                  │   Penyewa        │
       │                  │   (auto create   │
       │                  │   akun customer) │
       │                  │                  │
       │                  ├─[3] Buat         │
       │                  │   Tagihan        │
       │                  │                  │
       │                  │─[4] Kirim WA───▶│
       │                  │   Tagihan        │
       │                  │                  │
       │                  │◄─[5] Bayar───────┤
       │                  │   (via portal)   │
       │                  │                  │
       │                  ├─[6] Verifikasi───┤
       │                  │   Pembayaran     │
       │                  │                  │
       │                  │─[7] Notif───────▶│
       │                  │   "Terverifikasi"│
       │                  │                  │
       │                  │                  ├─[8] Cetak
       │                  │                  │   Kwitansi
```

### 4.2 Skenario 2: Booking Online (Frontend)

```
┌─────────────┐    ┌─────────────┐
│    PUBLIC   │    │    ADMIN    │
└──────┬──────┘    └──────┬──────┘
       │                  │
       ├─[1] Buka Website │
       │   Halaman Utama  │
       │                  │
       ├─[2] Cek Kalender│
       │   Ketersediaan   │
       │                  │
       ├─[3] Pilih Tgl   │
       │   Kalkulasi      │
       │                  │
       │─[4] WA Chat─────▶│
       │   Booking        │
       │                  │
       │                  ├─[5] Terima
       │                  │   Chat
       │                  │
       │                  ├─[6] Buat
       │                  │   Booking di
       │                  │   Sistem
       │                  │
       │◄─[7] Kalender───┤
       │   Update (merah) │
```

---

## 5. STATUS FLOW

### 5.1 Status Kamar
```
available ──→ occupied ──→ maintenance ──→ available
              (ditempati)   (perbaikan)
```

### 5.2 Status Penyewa
```
active ──→ completed ──→ terminated
              (selesai)     (berhenti)
```

### 5.3 Status Tagihan
```
draft ──→ sent ──→ paid ──→ cancelled
              │      │
              └── overdue (jatuh tempo)
```

### 5.4 Status Pembayaran
```
pending ──→ verified ──→ rejected
  (input)     (diterima)   (ditolak)
```

---

## 6. FITUR KEAMANAN

### 6.1 Password Security
- Password di-hash dengan bcrypt
- Minimal 8 karakter
- Wajib verifikasi password lama saat ganti
- Token reset password expired dalam 60 menit

### 6.2 Role-Based Access Control (RBAC)
| Fitur | Super Admin | Admin | Customer |
|-------|-------------|-------|----------|
| Dashboard All Stats | ✅ | ❌ | ❌ |
| Manajemen Property | ✅ | ✅ | ❌ |
| Manajemen Kamar | ✅ | ✅ | ❌ |
| Manajemen Penyewa | ✅ | ✅ | ❌ |
| Buat Tagihan | ✅ | ✅ | ❌ |
| Verifikasi Pembayaran | ✅ | ✅ | ❌ |
| Laporan Keuangan | ✅ | ❌ | ❌ |
| Manajemen Users | ✅ | ❌ | ❌ |
| Lihat Tagihan Sendiri | ✅ | ✅ | ✅ |
| Bayar Tagihan | ❌ | ❌ | ✅ |
| Lihat Riwayat Pembayaran | ✅ | ✅ | ✅ |
| Edit Profil | ✅ | ✅ | ✅ |
| Ganti Password | ✅ | ✅ | ✅ |
| Ganti Email | ✅ | ✅ | ✅ |

### 6.3 Middleware Protection
- `auth` - Harus login
- `role:super_admin` - Hanya Super Admin
- `role:admin,super_admin` - Admin & Super Admin
- `role:customer` - Hanya Customer

---

## 7. DEPLOYMENT KE HOSTINGER

### 7.1 Persiapan File
```bash
# Compress project (exclude: node_modules, vendor, .env)
zip -r kos4lokaso.zip kos4lokaso -x "*/node_modules/*" "*/vendor/*" "*/.env"
```

### 7.2 Upload ke Hostinger
1. Login cPanel Hostinger
2. File Manager → public_html
3. Upload kos4lokaso.zip
4. Extract zip

### 7.3 Setup Database
1. MySQL Database Wizard
2. Buat database baru
3. Buat user database
4. Assign user ke database

### 7.4 Konfigurasi .env
```env
APP_NAME=SewaVIP
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u353387484_namadb
DB_USERNAME=u353387484_userdb
DB_PASSWORD=password_db_anda
```

### 7.5 Command Setup (via SSH)
```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 7.6 Setup Email (Untuk Reset Password)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=admin@domain-anda.com
MAIL_PASSWORD=password_email
MAIL_ENCRYPTION=tls
```

---

## 8. TROUBLESHOOTING

### 8.1 Tidak Bisa Login
| Masalah | Solusi |
|---------|--------|
| "Invalid credentials" | Cek email & password, coba reset password |
| "Access denied" | Cek role user di database |
| "Account not found" | User belum terdaftar, hubungi admin |

### 8.2 Database Error
| Masalah | Solusi |
|---------|--------|
| "No such table" | Jalankan `php artisan migrate` |
| "Access denied" | Cek kredensial .env |
| "Connection refused" | Cek DB_HOST (localhost/127.0.0.1) |

### 8.3 Fitur Error
| Masalah | Solusi |
|---------|--------|
| Kalender tidak update | Refresh halaman (data real-time) |
| WA tidak kirim | Cek format nomor (628... bukan 08...) |
| Upload gagal | Cek permission folder storage (chmod 775) |
| Email tidak terkirim | Cek konfigurasi SMTP |

---

## 9. CHECKLIST IMPLEMENTASI

### 9.1 Setup Awal
- [ ] Upload file ke hosting
- [ ] Setup database MySQL
- [ ] Konfigurasi .env
- [ ] Jalankan migration
- [ ] Buat Super Admin pertama

### 9.2 Konfigurasi Sistem
- [ ] Buat Property
- [ ] Buat Kamar
- [ ] Set harga sewa
- [ ] Set nomor WhatsApp admin
- [ ] Set deskripsi kamar (frontend)

### 9.3 Operasional
- [ ] Daftar penyewa pertama
- [ ] Buat tagihan pertama
- [ ] Test pembayaran customer
- [ ] Test verifikasi admin
- [ ] Test laporan keuangan
- [ ] Test reset password

---

## 10. KONTAK & DUKUNGAN

### Developer
- **GitHub:** https://github.com/fauzanalditester-rgb/kos-sudah-jadi
- **Framework:** Laravel 13.2.0 + Livewire 3 + Tailwind CSS

### Dokumentasi Ini
- **Versi:** 1.0
- **Tanggal:** April 2026
- **Status:** Production Ready

---

**CATATAN PENTING:**
- Selalu backup database sebelum update sistem
- Jangan hapus folder storage/ (berisi upload file)
- Ganti password default segera setelah login pertama

---

**END OF DOCUMENT**
