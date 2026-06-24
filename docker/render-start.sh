#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

# Render generateValue may not include Laravel's required base64: prefix
if [ -z "${APP_KEY:-}" ] || [[ "${APP_KEY}" != base64:* ]]; then
  export APP_KEY="base64:$(php -r 'echo base64_encode(random_bytes(32));')"
fi

export DB_SSLMODE="${DB_SSLMODE:-require}"
export APP_URL="${APP_URL:-https://mazadxa.onrender.com}"

php artisan config:clear
php artisan route:clear
php artisan view:clear

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

if [ ! -f public/build/manifest.json ]; then
  echo "ERROR: Vite build manifest missing at public/build/manifest.json" >&2
  exit 1
fi

chmod -R a+rX public/build 2>/dev/null || true

php artisan config:cache
php artisan route:cache

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
