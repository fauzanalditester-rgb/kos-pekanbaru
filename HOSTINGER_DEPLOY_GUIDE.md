# 🚀 Hostinger Business Deployment Guide - SewaVIP Kos

## 📋 Overview
Panduan lengkap deploy aplikasi Laravel SewaVIP Kos ke Hostinger Business Hosting.

---

## 🔧 Step 1: Persiapan di Hostinger Panel

### 1.1 Login ke Hostinger
1. Buka https://hpanel.hostinger.com
2. Login dengan akun Hostinger Anda

### 1.2 Setup Domain/Subdomain
1. Pilih domain yang akan digunakan (contoh: `kos.yourdomain.com`)
2. Atau gunakan subdomain gratis dari Hostinger

### 1.3 Buat Database MySQL
1. Masuk menu **Databases** → **MySQL Databases**
2. Klik **Create Database**
3. Isi:
   - Database Name: `sewavip_kos`
   - Database Username: `sewavip_user`
   - Password: (generate strong password)
4. Simpan informasi database (nanti diperlukan untuk .env)

---

## 📁 Step 2: Upload Project via Git (Hostinger Git Integration)

### 2.1 Aktifkan Git Integration
1. Di Hostinger Panel, masuk **Advanced** → **Git**
2. Klik **Create Repository**
3. Pilih **Clone Repository**
4. Masukkan URL GitHub: `https://github.com/fauzanalditester-rgb/kos-pekanbaru.git`
5. Branch: `main`
6. Directory: `public_html` (atau folder lain jika menggunakan subdomain)
7. Klik **Create**

### 2.2 Setup Web Root (IMPORTANT!)
1. Masuk **Websites** → **Domain** → **Advanced** → **Change Root Directory**
2. Ubah ke: `public_html/public`
3. Ini memastikan Laravel public folder yang diakses

---

## ⚙️ Step 3: Konfigurasi Environment

### 3.1 Buat File .env
1. Di File Manager Hostinger, edit file `.env` (copy dari `.env.example`)
2. Sesuaikan dengan database Hostinger:

```env
APP_NAME="SewaVIP Kos"
APP_ENV=production
APP_KEY=base64:ISI_DENGAN_KEY_GENERATE
APP_DEBUG=false
APP_URL=https://your-domain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=sewavip_kos
DB_USERNAME=sewavip_user
DB_PASSWORD=PASSWORD_DATABASE_ANDA

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

### 3.2 Generate APP_KEY
1. Buka **Advanced** → **SSH Access**
2. Aktifkan SSH, copy command login
3. Login via SSH (gunakan PuTTY/Terminal)
4. Jalankan:
```bash
cd public_html
php artisan key:generate
```

---

## 🗄️ Step 4: Import Database

### 4.1 Export Database Lokal (dari file yang saya buat)
File database ada di: `database/backup/sewavip_kos_database.sql`

### 4.2 Import ke Hostinger
1. Masuk **Databases** → **phpMyAdmin**
2. Pilih database `sewavip_kos`
3. Klik **Import** tab
4. Pilih file `sewavip_kos_database.sql`
5. Klik **Go**

---

## 🔄 Step 5: Final Setup

### 5.1 Jalankan Migration (jika perlu)
```bash
cd public_html
php artisan migrate --force
```

### 5.2 Storage Link
```bash
cd public_html
php artisan storage:link
```

### 5.3 Cache & Optimization
```bash
cd public_html
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5.4 Set Permissions (via File Manager atau SSH)
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod -R 755 public/storage
```

---

## ✅ Step 6: Verifikasi

### 6.1 Test Website
1. Buka domain Anda di browser
2. Test login dengan credential:
   - Super Admin: `superadmin@sewavip.com` / `password123`
   - Admin: `admin@sewavip.com` / `password123`
   - Customer: `customer@sewavip.com` / `password123`

### 6.2 Test Fitur
- Login/Logout semua role
- CRUD data
- Upload gambar (kamar, bukti pembayaran)
- Invoice dan pembayaran

---

## 🔒 Security Checklist

- [ ] SSL Certificate aktif (Hostinger auto-SSL)
- [ ] APP_DEBUG = false
- [ ] APP_KEY sudah digenerate
- [ ] .env file permission 644 (read-only)
- [ ] Folder storage/cache permission 755
- [ ] Database password strong

---

## 🆘 Troubleshooting

### Error 500
- Check `.env` APP_KEY sudah diisi
- Check folder permissions
- Check error log di `storage/logs/laravel.log`

### Database Connection Error
- Verify DB_HOST = localhost
- Check DB_DATABASE, DB_USERNAME, DB_PASSWORD
- Pastikan database sudah di-import

### Permission Denied
```bash
chmod -R 755 storage bootstrap/cache
chmod -R 644 .env
```

### Gambar tidak tampil
- Pastikan `storage:link` sudah dijalankan
- Check folder `public/storage` ada symlink

---

## 📞 Support

Jika ada masalah:
1. Check Hostinger Knowledge Base
2. Contact Hostinger Support via Live Chat
3. Check Laravel logs: `storage/logs/laravel.log`

---

**Selamat! Aplikasi SewaVIP Kos sudah live di Hostinger! 🎉**
