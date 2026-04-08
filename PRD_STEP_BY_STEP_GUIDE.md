# PRD - STEP BY STEP GUIDE
## Aplikasi Manajemen Kos (SewaVIP)

---

## 1. LOGIN & AKSES

### 1.1 URL Login

| Role | URL | Email | Password |
|------|-----|-------|----------|
| **Super Admin** | `http://localhost:8000/login-superadmin` | `superadmin@sewavip.com` | `password123` |
| **Admin** | `http://localhost:8000/login-admin` | `admin@sewavip.com` | `password123` |
| **Customer** | `http://localhost:8000/login-customer` | `customer@sewavip.com` | `password123` |

### 1.2 Setelah Login
- Super Admin → Dashboard Super Admin
- Admin → Dashboard Admin
- Customer → Dashboard Customer

---

## 2. SUPER ADMIN WORKFLOW

### 2.1 Dashboard (`/super-admin`)
**Fungsi:** Melihat overview seluruh sistem

**Data yang ditampilkan:**
- Total Users, Customers, Admins, Super Admins
- Total Tenants (aktif/total)
- Total Invoices (paid/pending/overdue)
- Total Payments (verified/pending)
- Financial Summary (hari ini/bulan ini/total)
- Recent Activity (Users, Tenants, Payments)

### 2.2 Manajemen Property (`/super-admin/properties`)
**Fungsi:** Kelola data properti/kost

**Langkah:**
1. Klik "Tambah Property"
2. Isi: Nama Property, Alamat, Deskripsi, Status
3. Klik "Simpan"
4. Property muncul di daftar

**Edit/Delete:**
- Klik ikon edit untuk ubah data
- Klik ikon delete untuk hapus (konfirmasi dulu)

### 2.3 Manajemen Kamar (`/super-admin/kamar`)
**Fungsi:** Kelola data kamar per property

**Langkah:**
1. Pilih Property dari dropdown
2. Klik "Tambah Kamar"
3. Isi: Kode Kamar, Tipe, Harga Bulanan, Fasilitas, Status
4. Klik "Simpan"

**Status Kamar:**
- `available` = Tersedia
- `occupied` = Terisi
- `maintenance` = Perbaikan

### 2.4 Manajemen Penyewa (`/super-admin/penyewa`)
**Fungsi:** Kelola data tenant/penyewa

**Langkah:**
1. Klik "Tambah Penyewa"
2. Isi data:
   - Nama Lengkap
   - Email & Telepon
   - Kamar (pilih dari dropdown)
   - Tanggal Masuk
   - Deposit
   - Kontak Darurat
3. Klik "Simpan"

**Status Penyewa:**
- `active` = Aktif
- `completed` = Selesai kontrak
- `terminated` = Berhenti

### 2.5 Manajemen Tagihan (`/super-admin/tagihan`)
**Fungsi:** Buat dan kelola invoice/tagihan

**Langkah Buat Tagihan:**
1. Klik "Buat Tagihan"
2. Pilih Penyewa (otomatis load kamar & harga)
3. Isi:
   - Tanggal Terbit
   - Jatuh Tempo
   - Harga Sewa
   - Tambahan (jika ada)
   - Deskripsi
4. Klik "Simpan"

**Kirim Tagihan via WhatsApp:**
1. Klik tombol WhatsApp di tagihan
2. Edit pesan jika perlu
3. Klik "Kirim"
4. Sistem redirect ke WhatsApp Web/App

**Status Tagihan:**
- `draft` = Draft
- `sent` = Terkirim
- `paid` = Lunas
- `overdue` = Jatuh tempo

### 2.6 Manajemen Pembayaran (`/super-admin/pembayaran`)
**Fungsi:** Verifikasi pembayaran dari customer

**Langkah Verifikasi:**
1. Lihat daftar pembayaran dengan status `pending`
2. Klik "Verifikasi"
3. Cek bukti transfer (jika ada)
4. Ubah status menjadi `verified`
5. Klik "Simpan"

**Otomatis:**
- Invoice terkait update status jadi `paid`
- Finance record auto-create untuk laporan

### 2.7 Laporan Keuangan (`/super-admin/laporan`)
**Fungsi:** Lihat laporan pemasukan & pengeluaran (HANYA SUPER ADMIN)

**Fitur:**
- Filter per tanggal/bulan/tahun
- Export CSV
- Grafik pemasukan vs pengeluaran
- Detail transaksi

### 2.8 Manajemen Users (`/super-admin/users`)
**Fungsi:** Kelola semua user (Admin & Customer)

**Langkah:**
1. Klik "Tambah User"
2. Isi: Nama, Email, Password, Role
3. Jika Customer: Hubungkan dengan Tenant
4. Klik "Simpan"

---

## 3. ADMIN WORKFLOW

### 3.1 Dashboard (`/admin`)
**Fungsi:** Overview operasional harian

**Data:**
- Pemasukan hari ini/bulan ini
- Total profit
- Booking aktif
- Booking terbaru

### 3.2 Manajemen Booking (`/admin/bookings`)
**Fungsi:** Kelola reservasi/Booking kamar VIP (frontend)

**Langkah:**
1. Klik "Tambah Booking"
2. Isi:
   - Nama Tamu
   - Telepon
   - Check-in & Check-out
   - Status (confirmed/pending/completed)
3. Sistem auto-calculate harga
4. Klik "Simpan"

**Otomatis:**
- Kalender frontend update (tanggal terbooking)
- Jika confirmed: Finance record pemasukan auto-create

### 3.3 Manajemen Property, Kamar, Penyewa
Sama dengan Super Admin (lihat 2.2, 2.3, 2.4)

### 3.4 Manajemen Tagihan & Pembayaran
Sama dengan Super Admin (lihat 2.5, 2.6)

### 3.5 Pengeluaran (`/admin/pengeluaran`)
**Fungsi:** Catat pengeluaran operasional

**Langkah:**
1. Klik "Tambah Pengeluaran"
2. Isi:
   - Tanggal
   - Kategori (maintenance, utilities, dll)
   - Jumlah
   - Deskripsi
   - Bukti (opsional)
3. Klik "Simpan"

**Catatan:**
- Pengeluaran masuk ke laporan keuangan
- Hanya Super Admin yang bisa lihat laporan lengkap

### 3.6 Inventaris (`/admin/inventaris`)
**Fungsi:** Kelola inventaris kamar

**Langkah:**
1. Klik "Tambah Item"
2. Isi: Nama Item, Kategori, Kondisi Default
3. Klik "Simpan"

**Gunakan untuk:**
- Checklist inventaris saat check-in/check-out
- Track kondisi barang

### 3.7 WhatsApp Manager (`/admin/whatsapp`)
**Fungsi:** Kirim notifikasi via WhatsApp

**Langkah:**
1. Pilih template pesan
2. Pilih penerima (penyewa)
3. Edit pesan jika perlu
4. Klik "Kirim"

### 3.8 Settings (`/admin/settings`)
**Fungsi:** Pengaturan sistem

**Data yang bisa diubah:**
- Harga harian & mingguan (untuk booking VIP)
- Nomor WhatsApp
- Deskripsi kamar
- Status ketersediaan

---

## 4. CUSTOMER WORKFLOW

### 4.1 Dashboard Customer (`/customer`)
**Fungsi:** Overview data penyewa

**Data yang ditampilkan:**
- Info kamar yang ditempati
- Tagihan aktif
- Riwayat pembayaran
- Statistik (total dibayar, pending, overdue)

### 4.2 Tagihan Saya (`/customer/tagihan`)
**Fungsi:** Lihat dan bayar tagihan

**Langkah Bayar:**
1. Klik tagihan yang statusnya `sent` atau `overdue`
2. Klik "Bayar Sekarang"
3. Isi:
   - Jumlah Pembayaran
   - Metode (transfer/cash/qris)
   - Upload Bukti Transfer (jika transfer)
4. Klik "Submit"

**Status Pembayaran:**
- `pending` = Menunggu verifikasi admin
- `verified` = Terverifikasi
- `rejected` = Ditolak

**Notifikasi:**
- Admin otomatis dapat notifikasi pembayaran baru

### 4.3 Pembayaran (`/customer/pembayaran`)
**Fungsi:** Lihat riwayat semua pembayaran

**Filter:**
- Semua
- Terverifikasi
- Pending

### 4.4 Info Kamar (`/customer/kamar`)
**Fungsi:** Lihat detail kamar yang ditempati

**Data:**
- Nama Property
- Kode Kamar
- Fasilitas
- Harga Sewa
- Tagihan yang belum lunas

### 4.5 Profil (`/customer/profil`)
**Fungsi:** Edit data pribadi

**Bisa diubah:**
- Nama
- Email
- Telepon
- Alamat
- Kontak Darurat
- Password
- Foto KTP

---

## 5. FRONTEND / PUBLIC ACCESS

### 5.1 Halaman Utama (`/`)
**Fungsi:** Landing page untuk calon penyewa

**Bagian:**
1. **Hero Section** - Deskripsi kamar VIP + CTA "Pesan Sekarang"
2. **Fitur** - WiFi, AC, TV, Akses
3. **Harga** - Harian & Mingguan
4. **Kalender Ketersediaan** - Lihat tanggal yang sudah terbooking
5. **Kalkulator Booking** - Hitung estimasi harga
6. **Komentar** - Testimoni & diskusi

### 5.2 Kalender Ketersediaan (`#calendar`)
**Fungsi:** Cek tanggal yang tersedia

**Visual:**
- Tanggal terbooking = warna merah/orange
- Tanggal tersedia = warna hijau
- Tanggal sudah lewat = disabled

**Update:** Real-time dari data Booking admin

### 5.3 Kalkulator Booking (`#booking`)
**Fungsi:** Estimasi biaya menginap

**Langkah:**
1. Pilih tanggal check-in
2. Pilih tanggal check-out
3. Sistem auto-calculate:
   - Total hari
   - Breakdown minggu + hari
   - Total biaya
4. Klik "Pesan via WhatsApp"
5. Sistem redirect ke WhatsApp dengan pesan otomatis

**Harga:**
- Harian: Rp 350.000
- Mingguan: Rp 2.000.000

### 5.4 Komentar/Testimoni (`#comments`)
**Fungsi:** Interaksi publik

**Fitur:**
- Tambah komentar
- Balas komentar
- Moderasi oleh admin

---

## 6. ALUR KERJA END-TO-END

### Alur 1: Penyewa Baru (Admin/SuperAdmin)
```
1. Login sebagai Admin/SuperAdmin
2. Tambah Property (jika belum ada)
3. Tambah Kamar (jika belum ada)
4. Tambah Penyewa → pilih kamar
5. Buat Tagihan (invoice)
6. Kirim tagihan via WhatsApp
7. Tunggu pembayaran dari penyewa
```

### Alur 2: Pembayaran (Customer → Admin)
```
1. Customer login
2. Cek tagihan di menu "Tagihan"
3. Klik "Bayar" → upload bukti transfer
4. Admin dapat notifikasi pembayaran baru
5. Admin verifikasi pembayaran
6. Invoice status update jadi "paid"
7. Customer lihat status pembayaran = "verified"
```

### Alur 3: Booking VIP (Public → Admin)
```
1. Calon tamu buka halaman utama
2. Cek kalender ketersediaan
3. Gunakan kalkulator untuk estimasi
4. Klik "Pesan via WhatsApp"
5. Konfirmasi via WhatsApp
6. Admin buat Booking di sistem
7. Tanggal booking muncul di kalender (tidak bisa dipesan orang lain)
```

---

## 7. KETERHUBUNGAN DATA

### Relasi Database:
```
Users (role: customer) → Tenant → Room → Property
                        ↓
                     Invoice → Payment
                        ↓
                     Finance (laporan)
```

### Sinkronisasi Real-time:
| Aksi Admin | Efek di Customer | Efek di Frontend |
|------------|------------------|------------------|
| Buat tagihan | Muncul di dashboard | - |
| Verifikasi pembayaran | Status update | - |
| Buat booking | - | Kalender update |
| Update harga | - | Kalkulator update |

---

## 8. PANDUAN DEPLOY

### 8.1 Persiapan Database Hostinger:
```
MySQL database name: u353387484_harsasetialivi
MySQL username: u353387484_harsasetialivi
Password: YajsZ:CkC+2
```

### 8.2 File .env Production:
```
APP_NAME=SewaVIP
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u353387484_harsasetialivi
DB_USERNAME=u353387484_harsasetialivi
DB_PASSWORD=YajsZ:CkC+2
```

### 8.3 Command Setelah Deploy:
```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

---

## 9. TIPS PENGGUNAAN

### Untuk Admin:
1. **Rutin cek pembayaran pending** - Customer menunggu verifikasi
2. **Kirim pengingat tagihan** - Gunakan WhatsApp manager
3. **Update status kamar** - Pastikan data ketersediaan akurat
4. **Backup data berkala** - Export laporan keuangan

### Untuk Customer:
1. **Simpan bukti transfer** - Diperlukan untuk verifikasi
2. **Cek tagihan rutin** - Hindari overdue
3. **Update profil** - Pastikan kontak aktif
4. **Gunakan WhatsApp** - Cara tercepat komunikasi

### Untuk Super Admin:
1. **Monitor laporan keuangan** - Cek profit/loss
2. **Kelola akses user** - Beri akses sesuai role
3. **Audit pengeluaran** - Pastikan semua tercatat
4. **Review aktivitas** - Cek log pembayaran & booking

---

## 10. TROUBLESHOOTING

### Masalah Login:
- **"Access denied"** → Cek role user di database
- **"Invalid credentials"** → Reset password via database

### Masalah Database:
- **"No such table"** → Jalankan `php artisan migrate`
- **"Access denied"** → Cek kredensial .env

### Masalah Fitur:
- **Kalender tidak update** → Refresh halaman (Livewire auto-refresh)
- **WhatsApp tidak kirim** → Cek nomor format (628... bukan 08...)
- **Upload gagal** → Cek permission folder storage

---

**Dokumen ini dibuat untuk:** SewaVIP - Aplikasi Manajemen Kos
**Versi:** 1.0
**Tanggal:** April 2026
