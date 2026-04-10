# 🏠 SewaVIP Kos Management System

Aplikasi manajemen kos/kost berbasis Laravel + Livewire dengan fitur lengkap untuk admin, super admin, dan customer.

## 🚀 Deploy ke Railway (GRATIS $5/bulan)

### Prerequisites
- Akun GitHub
- Repository: `https://github.com/misrahanummisrahanum-create/kos1`

---

## 📋 Step-by-Step Deployment

### Step 1: Daftar Railway
1. Buka https://railway.app
2. Click "Start for Free"
3. Login dengan GitHub
4. Berikan akses ke repository

### Step 2: Create Project
1. Click "New Project"
2. Pilih "Deploy from GitHub repo"
3. Pilih repository "kos1"
4. Click "Add" → Tunggu build

### Step 3: Add MySQL Database
1. Click "New" → "Database" → "Add MySQL"
2. Beri nama: `kos-mysql`
3. Tunggu status "Running"

### Step 4: Environment Variables
Di service "kos1" → Tab "Variables", tambahkan:

**WAJIB (Manual):**
```
APP_NAME=SewaVIP Kos
APP_ENV=production
APP_KEY=base64:HASIL_DARI_LOCAL
APP_DEBUG=false
APP_URL=${RAILWAY_STATIC_URL}
```

**Generate APP_KEY di local:**
```bash
php artisan key:generate --show
# Copy output ke Railway variable APP_KEY
```

**Railway References (Auto):**
```
DB_CONNECTION=mysql
DB_HOST=${{kos-mysql.MYSQLHOST}}
DB_PORT=${{kos-mysql.MYSQLPORT}}
DB_DATABASE=${{kos-mysql.MYSQLDATABASE}}
DB_USERNAME=${{kos-mysql.MYSQLUSER}}
DB_PASSWORD=${{kos-mysql.MYSQLPASSWORD}}
```

**Session & Cache:**
```
SESSION_DRIVER=cookie
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

### Step 5: Database Migration
Di service "kos1" → Tab "Shell", jalankan:
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### Step 6: Test Akses
URL otomatis: `https://kos1-production.up.railway.app`

**Login Default:**
- Super Admin: `superadmin@sewavip.com` / `password123`
- Admin: `admin@sewavip.com` / `password123`
- Customer: `customer@sewavip.com` / `password123`

---

## 🔧 Troubleshooting

### Error 500 / Database Connection
```bash
# Cek logs di Railway tab "Logs"
# Pastikan semua DB variables ter-set dengan benar
```

### APP_KEY Missing
```bash
php artisan key:generate --show
# Copy ke Railway variables
```

### Storage Issue
```bash
php artisan storage:link
```

---

## 🛠️ Fitur Aplikasi

### Role Management
- ✅ Super Admin (full access)
- ✅ Admin (operational)
- ✅ Customer (tenant portal)

### Module
- 📊 Dashboard & Analytics
- 🏠 Room & Property Management
- 👥 Tenant Management
- 📝 Booking System
- 💰 Invoice & Payment
- 📈 Financial Reports
- 💬 Comment Board
- 🔐 Account Settings

---

## 📁 File Konfigurasi Railway

- `railway.toml` - Railway deployment config
- `nixpacks.toml` - Build configuration
- `Procfile` - Process configuration
- `.env.railway` - Environment template

---

## 📝 Local Development

```bash
# Setup
cd kos4lokaso
composer install
npm install
npm run build

# Database
cp .env.example .env
php artisan key:generate
php artisan migrate --seed

# Run
php artisan serve
npm run dev
```

---

## 🔒 Keamanan
- `.env` excluded dari git
- Password default harus diganti setelah deploy
- HTTPS auto-enabled di production
- Session cookie secure

---

## 💡 Tips Railway Gratis
- $5 credit cukup untuk 1 aplikasi kecil
- Monitor usage di tab "Usage"
- Database gratis included
- Auto-sleep setelah idle (slow wake)

---

## 📞 Support
Jika ada error deploy:
1. Cek Railway Logs
2. Verifikasi environment variables
3. Jalankan ulang migration
4. Restart deployment

---

**Ready to deploy!** 🚀
