#!/bin/bash

# Railway Deployment Script for SewaVIP Kos
# This script runs after deployment to set up the database

echo "🚀 Starting Railway Deployment..."

# Check if APP_KEY is set
if [ -z "$APP_KEY" ]; then
    echo "❌ Error: APP_KEY is not set!"
    echo "Please generate APP_KEY using: php artisan key:generate --show"
    exit 1
fi

# Check database connection
echo "🔍 Checking database connection..."
php artisan tinker --execute="try { \DB::connection()->getPdo(); echo '✅ Database connected!\n'; } catch (\Exception \$e) { echo '❌ Database connection failed: ' . \$e->getMessage() . '\n'; exit(1); }"

# Run migrations
echo "📊 Running database migrations..."
php artisan migrate --force --no-interaction
if [ $? -ne 0 ]; then
    echo "❌ Migration failed!"
    exit 1
fi

# Run seeders (only if tables are empty)
echo "🌱 Checking if seeding is needed..."
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ]; then
    echo "🌱 Running database seeders..."
    php artisan db:seed --force --no-interaction
else
    echo "✅ Database already seeded (Users: $USER_COUNT)"
fi

# Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link --no-interaction 2>/dev/null || echo "Storage link already exists"

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Clear unnecessary caches
echo "🧹 Clearing temporary caches..."
php artisan cache:clear --no-interaction

echo "✅ Deployment completed successfully!"
echo ""
echo "🌐 Your application should be running at: $RAILWAY_STATIC_URL"
