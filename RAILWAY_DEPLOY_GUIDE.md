# 🚂 Railway.app Deployment Guide - Step by Step

## Prerequisites
- GitHub account (sudah ada)
- Repository sudah di-push: `https://github.com/misrahanummisrahanum-create/kos1`
- Project Laravel siap deploy

---

## STEP 1: Daftar Railway (GRATIS $5 Credit)

1. Buka browser → https://railway.app
2. Click tombol **"Start for Free"**
3. Pilih **"Continue with GitHub"**
4. Login dengan akun GitHub Anda
5. Berikan permission untuk Railway mengakses repository
6. Selesai! Anda sekarang di Dashboard Railway

---

## STEP 2: Create New Project

### Method A: Deploy from GitHub (Recommended)
1. Di Dashboard Railway, click **"New Project"**
2. Pilih **"Deploy from GitHub repo"**
3. Railway akan minta install GitHub App:
   - Click **"Configure GitHub App"**
   - Pilih repository: **"kos1"**
   - Click **"Install & Authorize"**
   - Kembali ke Railway
4. Railway akan detect repository Anda
5. Click **"Add"** untuk deploy
6. Tunggu proses build (2-5 menit)

### Method B: Deploy from Template (Alternative)
1. Di Dashboard, click **"New Project"**
2. Pilih **"Provision MySQL"** dulu
3. Lalu add deployment

---

## STEP 3: Add MySQL Database

1. Di project dashboard, click **"New"**
2. Pilih **"Database"**
3. Pilih **"Add MySQL"**
4. Beri nama: `kos-db` (opsional)
5. Railway akan auto-create database dengan:
   - Database name
   - Username
   - Password
   - Host & Port
6. Tunggu sampai status **"Running"** (hijau)

---

## STEP 4: Setup Environment Variables

### 4.1 Generate APP_KEY (di local terminal)
```bash
cd C:\Users\Asus\Downloads\kos4lokaso
php artisan key:generate --show
```
**Copy output-nya** (contoh: `base64:xvQ/9H1k...`)

### 4.2 Add Variables di Railway
1. Di project dashboard, click service **"kos1"** (deployment)
2. Click tab **"Variables"**
3. Click **"+ New Variable"** satu per satu:

| Variable | Value | Keterangan |
|----------|-------|------------|
| `APP_NAME` | `SewaVIP Kos` | Nama aplikasi |
| `APP_ENV` | `production` | Environment |
| `APP_KEY` | `base64:...` | Paste dari terminal tadi |
| `APP_DEBUG` | `false` | Jangan true di production |
| `APP_URL` | `https://kos1-production.up.railway.app` | Nanti Railway kasih |
| `DB_CONNECTION` | `mysql` | Driver database |
| `DB_HOST` | `${{Mysql.MYSQLHOST}}` | Railway variable |
| `DB_PORT` | `${{Mysql.MYSQLPORT}}` | Railway variable |
| `DB_DATABASE` | `${{Mysql.MYSQLDATABASE}}` | Railway variable |
| `DB_USERNAME` | `${{Mysql.MYSQLUSER}}` | Railway variable |
| `DB_PASSWORD` | `${{Mysql.MYSQLPASSWORD}}` | Railway variable |

**Untuk Railway Variables**: Click **"+ New Variable"** → Pilih **"Add Reference"** → Pilih database service → Pilih variable yang diinginkan.

---

## STEP 5: Railway Variables Auto-Detect

Railway akan otomatis bikin beberapa variable setelah deploy. Yang perlu ditambahkan manual:

```
APP_NAME=SewaVIP Kos
APP_ENV=production
APP_KEY=base64:ISI_DARI_TERMINAL
APP_DEBUG=false
APP_TIMEZONE=Asia/Jakarta
DB_CONNECTION=mysql
```

---

## STEP 6: Deploy Aplikasi

1. Setelah semua variable di-set
2. Railway akan auto-redeploy
3. Tunggu build selesai (bisa lihat di tab **"Deployments"**)
4. Jika berhasil, status akan **"Healthy"**

### Cek Logs (kalau ada error):
1. Click tab **"Logs"**
2. Lihat error message

---

## STEP 7: Database Migration & Seeding

### Method A: Via Railway Shell (Recommended)
1. Di project dashboard, click service **"kos1"**
2. Click tab **"Shell"**
3. Jalankan command satu per satu:

```bash
# Migrate database
php artisan migrate --force

# Seed default data (user, room, dll)
php artisan db:seed --force

# Create storage link
php artisan storage:link

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Method B: Via Railway CLI (Alternative)
Jika ingin pakai CLI di local:
```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Link project
railway link

# Jalankan command
railway run php artisan migrate --force
```

---

## STEP 8: Get Domain & Test

1. Railway akan kasih domain otomatis: `https://kos1-production.up.railway.app`
2. Buka di browser
3. Test login dengan default user:
   - **Super Admin**: `superadmin@sewavip.com` / `password123`
   - **Admin**: `admin@sewavip.com` / `password123`
   - **Customer**: `customer@sewavip.com` / `password123`

---

## STEP 9: Custom Domain (Opsional)

1. Di Railway dashboard, click **"Settings"**
2. Scroll ke **"Domains"**
3. Click **"+ Custom Domain"**
4. Masukkan domain Anda: `kos.sewavip.com`
5. Railway akan kasih DNS record (CNAME)
6. Tambahkan di domain provider Anda
7. Tunggu propagasi (1-24 jam)

---

## STEP 10: Monitoring & Maintenance

### Cek Usage (Jangan sampai habis $5 credit):
1. Dashboard → **"Usage"** tab
2. Monitor CPU, Memory, Database usage

### Auto-redeploy saat push ke GitHub:
1. Push kode baru ke repository
2. Railway auto-detect dan redeploy

### Backup Database:
1. Click service MySQL
2. Tab **"Backups"**
3. Click **"Create Backup"**

---

## 🚨 TROUBLESHOOTING

### Error: "No application encryption key specified"
- Solusi: Pastikan `APP_KEY` sudah di-set di Variables

### Error: "Database connection failed"
- Solusi: Cek DB_HOST, DB_PORT, dll. Pastikan pakai Railway variables

### Build Failed
1. Click tab **"Build"** lihat error
2. Common fix: Pastikan `composer.json` valid

### 500 Server Error
1. Click tab **"Logs"**
2. Cari error detail di Laravel logs

---

## 📱 Railway CLI Commands (Opsional)

```bash
# Install CLI
npm install -g @railway/cli

# Login
railway login

# Link project local ke Railway
railway link

# Jalankan command di Railway environment
railway run php artisan tinker

# Check status
railway status

# View logs
railway logs
```

---

## ✅ CHECKLIST DEPLOYMENT

- [ ] Daftar Railway dengan GitHub
- [ ] Create project from GitHub repo
- [ ] Add MySQL database
- [ ] Set APP_KEY variable
- [ ] Set all DB variables (gunakan Railway references)
- [ ] Deploy berhasil (status Healthy)
- [ ] Run migration via Shell
- [ ] Run seeder via Shell
- [ ] Create storage link
- [ ] Test login di browser
- [ ] (Opsional) Setup custom domain

---

## 🎯 Next Steps Setelah Deploy

1. **Ganti default password** setelah login pertama kali
2. **Setup SSL** (Railway otomatis untuk .railway.app domain)
3. **Configure email** (untuk forgot password, dll)
4. **Setup CDN** untuk assets (Cloudflare gratis)

**Siap deploy ke Railway sekarang!** 🚀
