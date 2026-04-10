---
description: Step-by-step deployment guide for SewaVIP Laravel application
tags: [deployment, laravel, hosting, production]
---

# 🚀 Deployment Guide - SewaVIP Kos Management System

## Platform Rekomendasi (Berdasarkan Budget & Kebutuhan)

| Platform | Harga/Bulan | Skill Level | Rekomendasi Untuk |
|----------|-------------|-------------|-------------------|
| **Shared Hosting (cPanel)** | Rp 50K-200K | Pemula | Budget kecil, traffic rendah |
| **VPS (DigitalOcean/Cloudways)** | $6-12 | Menengah | Kontrol penuh, traffic menengah |
| **AWS/RGCP/Azure** | Pay-as-you-go | Advanced | Enterprise, traffic tinggi |
| **Laravel Cloud/Vapor** | $30+ | Pemula-Medium | Laravel native, auto-scaling |

---

## 1️⃣ SHARED HOSTING (cPanel) - Budget Friendly

### Prerequisites
- Domain (beli di Niagahoster/Hostinger/namecheap)
- Shared hosting dengan PHP 8.2+ & MySQL 8.0+

### Step-by-Step

#### Step 1: Persiapan Local
```bash
# Optimize Laravel untuk production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Hapus file development
rm -rf node_modules
rm -rf tests/
rm -rf .git/
```

#### Step 2: Database Setup
```bash
# Export database local
mysqldump -u root -p kos_sewavip > database_export.sql

# Atau gunakan phpMyAdmin export
```

#### Step 3: Upload ke cPanel
1. Login cPanel → File Manager
2. Upload ZIP project ke `public_html/`
3. Extract ZIP
4. Pindahkan isi `public/` ke root (public_html)

#### Step 4: Konfigurasi .env
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_cpanel_db_name
DB_USERNAME=your_cpanel_db_user
DB_PASSWORD=your_cpanel_db_pass
```

#### Step 5: Setup Database di cPanel
1. cPanel → MySQL Database Wizard
2. Create database + user + password
3. Import `database_export.sql` via phpMyAdmin

#### Step 6: Final Setup via SSH (jika tersedia)
```bash
cd ~/public_html
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### Step 7: Konfigurasi .htaccess
Buat/Edit `.htaccess` di root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>

# PHP Version
AddHandler application/x-httpd-php82 .php
```

---

## 2️⃣ VPS (DigitalOcean/Linode/Vultr) - Full Control

### Prerequisites
- VPS dengan Ubuntu 22.04 LTS
- Domain pointing ke VPS IP
- SSH access

### Step-by-Step Auto-Deploy Script

#### Step 1: Initial Server Setup
```bash
# SSH ke server
ssh root@your-vps-ip

# Update system
apt update && apt upgrade -y

# Install dependencies
apt install -y nginx mysql-server php8.2-fpm php8.2-mysql php8.2-curl \
    php8.2-gd php8.2-mbstring php8.2-xml php8.2-zip php8.2-bcmath \
    redis-server composer git unzip

# Setup MySQL
mysql_secure_installation
mysql -u root -p

# Buat database
CREATE DATABASE kos_sewavip;
CREATE USER 'kosuser'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON kos_sewavip.* TO 'kosuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 2: Deploy Aplikasi
```bash
# Buat user deploy
useradd -m -s /bin/bash deploy
usermod -aG sudo deploy

# Login sebagai deploy
su - deploy

# Clone repository
cd /var/www
git clone https://github.com/fauzanalditester-rgb/kos-sudah-jadi.git sewavip
cd sewavip

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Copy dan setup .env
cp .env.example .env
php artisan key:generate

# Edit .env sesuai konfigurasi VPS
nano .env

# Setup database
php artisan migrate --force
php artisan db:seed --force

# Permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
```

#### Step 3: Nginx Configuration
```bash
sudo nano /etc/nginx/sites-available/sewavip
```

Isi konfigurasi:
```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/sewavip/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

```bash
# Aktifkan site
sudo ln -s /etc/nginx/sites-available/sewavip /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx

# Setup SSL dengan Certbot
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

#### Step 4: Setup Supervisor (untuk queue)
```bash
sudo apt install supervisor
sudo nano /etc/supervisor/conf.d/sewavip-worker.conf
```

Isi:
```ini
[program:sewavip-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/sewavip/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/sewavip/storage/logs/worker.log
```

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start sewavip-worker:*
```

#### Step 5: Setup Cron (Scheduled Tasks)
```bash
crontab -e
```

Tambahkan:
```
* * * * * cd /var/www/sewavip && php artisan schedule:run >> /dev/null 2>&1
```

---

## 3️⃣ DOCKER DEPLOY (Recommended untuk Modern Stack)

### File: `docker-compose.yml`
```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: sewavip_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
      - ./docker/php/local.ini:/usr/local/etc/php/conf.d/local.ini
    networks:
      - sewavip_network
    depends_on:
      - db
      - redis

  nginx:
    image: nginx:alpine
    container_name: sewavip_nginx
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    volumes:
      - ./:/var/www
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
      - ./docker/ssl:/etc/nginx/ssl
    networks:
      - sewavip_network
    depends_on:
      - app

  db:
    image: mysql:8.0
    container_name: sewavip_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: kos_sewavip
      MYSQL_ROOT_PASSWORD: your_root_password
      MYSQL_USER: kosuser
      MYSQL_PASSWORD: kos_password
    volumes:
      - db_data:/var/lib/mysql
    ports:
      - "3306:3306"
    networks:
      - sewavip_network

  redis:
    image: redis:alpine
    container_name: sewavip_redis
    restart: unless-stopped
    networks:
      - sewavip_network

volumes:
  db_data:

networks:
  sewavip_network:
    driver: bridge
```

### File: `Dockerfile`
```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project
COPY . /var/www

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

# Permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000
CMD ["php-fpm"]
```

### Deploy dengan Docker:
```bash
# Build dan run
docker-compose up -d --build

# Setup database
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force
docker-compose exec app php artisan storage:link

# Optimize
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

---

## 4️⃣ PAAS (Platform-as-a-Service) - Mudah & Cepat

### Railway.app (Gratis $5/bulan)
1. Daftar di https://railway.app (login dengan GitHub)
2. New Project → Deploy from GitHub repo
3. Pilih repo `kos-sudah-jadi`
4. Add MySQL database (New → Database → Add MySQL)
5. Environment Variables:
   - `APP_ENV=production`
   - `APP_KEY=base64:...` (generate dengan `php artisan key:generate`)
   - `DB_CONNECTION=mysql`
   - `DB_HOST=${{Mysql.MYSQLHOST}}`
   - `DB_PORT=${{Mysql.MYSQLPORT}}`
   - `DB_DATABASE=${{Mysql.MYSQLDATABASE}}`
   - `DB_USERNAME=${{Mysql.MYSQLUSER}}`
   - `DB_PASSWORD=${{Mysql.MYSQLPASSWORD}}`
6. Deploy!

### Heroku (Free tier discontinued, minimal $7/bulan)
1. Install Heroku CLI
2. `heroku create sewavip-kos`
3. `heroku addons:create heroku-postgresql:mini`
4. `git push heroku main`
5. `heroku run php artisan migrate --force`

---

## 📋 POST-DEPLOYMENT CHECKLIST

### Security
- [ ] Ganti APP_KEY production
- [ ] Set APP_DEBUG=false
- [ ] Enable HTTPS/SSL
- [ ] Setup firewall (ufw/iptables)
- [ ] Disable register route jika tidak dipakai
- [ ] Setup rate limiting

### Performance
- [ ] Enable OPcache
- [ ] Setup CDN untuk assets (Cloudflare)
- [ ] Enable gzip compression
- [ ] Optimize images
- [ ] Database indexing

### Monitoring
- [ ] Setup error tracking (Sentry/Flare)
- [ ] Setup uptime monitoring (UptimeRobot)
- [ ] Setup log aggregation
- [ ] Backup otomatis database

### Maintenance
```bash
# Weekly
php artisan cache:clear
php artisan view:clear
php artisan config:cache

# Monthly
php artisan route:cache
composer update --no-dev

# Backup
cd /var/www/sewavip
mysqldump -u root -p kos_sewavip > backup_$(date +%Y%m%d).sql
```

---

## 🔧 TROUBLESHOOTING

### Permission Denied
```bash
chmod -R 755 storage/ bootstrap/cache/
chown -R www-data:www-data /var/www/sewavip
```

### 500 Server Error
```bash
# Check logs
tail -f /var/www/sewavip/storage/logs/laravel.log

# Clear caches
php artisan cache:clear
php artisan config:clear
```

### Database Connection Failed
```bash
# Test MySQL
mysql -u kosuser -p -h localhost

# Check .env DB config
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## 📞 BUTUH BANTUAN?

Jika ada masalah deployment, cek:
1. Laravel logs: `storage/logs/laravel.log`
2. Nginx logs: `/var/log/nginx/error.log`
3. PHP-FPM logs: `/var/log/php8.2-fpm.log`
4. Server requirements: `php artisan about`
