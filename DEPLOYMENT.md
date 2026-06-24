# MazadXA — Deployment Guide (Shared Web Hosting)

This Laravel auction site is structured for **standard shared hosting** (cPanel, Plesk, etc.) with Apache and PHP 8.2+.

## Requirements

- PHP 8.2 or higher
- MySQL 5.7+ or MariaDB (or SQLite for small sites)
- Apache with `mod_rewrite` enabled
- Composer (on your local machine for building)

## Local Development (XAMPP)

1. The project is at `c:\xampp\htdocs\mazadxa`
2. Access via: `http://localhost/mazadxa/public`
3. Or configure Apache virtual host with document root pointing to `/public`

```bash
php artisan migrate --seed
npm install
npm run build
```

## Shared Hosting Deployment

### Step 1: Build assets locally

```bash
npm install
npm run build
```

### Step 2: Upload files

Upload the entire project. Set your domain **document root** to the `public` folder.

### Step 3: Configure `.env`

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

```bash
php artisan key:generate
php artisan migrate --seed
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## SQLite (simple hosting)

```env
DB_CONNECTION=sqlite
```

Ensure `database/database.sqlite` is writable.
