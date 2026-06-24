#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

php artisan config:cache
php artisan route:cache
php artisan view:cache

php artisan migrate --force

php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
if (App\Models\User::count() === 0) {
    passthru('php artisan db:seed --force');
}
"

php artisan storage:link 2>/dev/null || true

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
