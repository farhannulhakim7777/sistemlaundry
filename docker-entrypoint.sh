#!/bin/sh
set -e

if [ ! -f /var/www/html/vendor/autoload.php ]; then
    composer install --ignore-platform-reqs --no-interaction --prefer-dist
fi

# Pastikan struktur folder storage & bootstrap/cache selalu ada dan bisa ditulis.
# Tanpa ini, session file (termasuk CSRF token) gagal tersimpan sehingga setiap
# submit form (mis. Simpan Pesanan) akan selalu berujung "419 Page Expired".
mkdir -p /var/www/html/storage/app/public \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/testing \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    php /var/www/html/artisan key:generate
fi

# Bersihkan cache config/route lama (kalau ada) agar perubahan .env selalu terbaca
php /var/www/html/artisan config:clear
php /var/www/html/artisan cache:clear
php /var/www/html/artisan view:clear

until php /var/www/html/artisan migrate --force; do
    echo "Menunggu database siap..."
    sleep 2
done

php /var/www/html/artisan db:seed --class=AdminSeeder --force

if [ ! -e /var/www/html/public/storage ]; then
    php /var/www/html/artisan storage:link
fi

php-fpm
