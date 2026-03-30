# Deployment Guide for Webtoon V2

This guide covers deploying your Laravel application to two common environments: **Shared Hosting (cPanel)** and **VPS (Ubuntu/Nginx)**.

## Prerequisites
Before deploying, ensure you have:
1.  **Production Build**: Run `npm run build` locally to compile assets.
2.  **Database**: A MySQL database created on your server.
3.  **Domain**: Pointed to your server's IP or name servers.

---

## Option 1: Shared Hosting (cPanel)

### 1. Prepare Files
1.  Run `composer install --optimize-autoloader --no-dev` locally.
2.  Run `npm run build` locally.
3.  Compress your entire project folder (excluding `node_modules` and `.git`) into a `project.zip` file.

### 2. Upload to Server
1.  Log in to cPanel -> **File Manager**.
2.  Upload `project.zip` to the root directory (not `public_html`), e.g., `/home/username/webtoon-v2`.
3.  Extract the zip file.

### 3. Configure Public Folder
1.  Move the **contents** of your project's `public` folder to `public_html`.
2.  Edit `public_html/index.php`:
    ```php
    // Change these lines to point to your project folder
    require __DIR__.'/../webtoon-v2/vendor/autoload.php';
    $app = require_once __DIR__.'/../webtoon-v2/bootstrap/app.php';
    ```

### 4. Environment & Database
1.  Copy `.env.example` to `.env` in your project folder.
2.  Edit `.env` with your database credentials:
    ```ini
    APP_NAME=WebtoonV2
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://yourdomain.com

    DB_DATABASE=your_db_name
    DB_USERNAME=your_db_user
    DB_PASSWORD=your_db_password
    ```
3.  **Generate Key**: If you have SSH access, run `php artisan key:generate`. If not, copy the `APP_KEY` from your local `.env`.

### 5. Storage Link
1.  In cPanel, look for a "Symlink" tool or use a cron job to run: `ln -s /home/username/webtoon-v2/storage/app/public /home/username/public_html/storage`.
2.  Alternatively, use PHP in a temporary route:
    ```php
    Route::get('/symlink', function () {
        Artisan::call('storage:link');
        return 'Linked';
    });
    ```

---

## Option 2: VPS (Ubuntu/Nginx) - Recommended

### 1. Server Setup
Install PHP, Nginx, MySQL, and Composer:
```bash
sudo apt update
sudo apt install nginx mysql-server php8.2 php8.2-fpm php8.2-mysql php8.2-xml php8.2-mbstring php8.2-curl unzip git
```

### 2. Database Setup
```sql
sudo mysql
CREATE DATABASE webtoon_v2;
CREATE USER 'webtoon'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON webtoon_v2.* TO 'webtoon'@'localhost';
EXIT;
```

### 3. Deploy Code
```bash
cd /var/www
sudo git clone https://github.com/yourusername/webtoon-v2.git
cd webtoon-v2
sudo chown -R www-data:www-data /var/www/webtoon-v2
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Install Dependencies
```bash
cp .env.example .env
# Edit .env with production settings (DB, URL, Debug=false)

composer install --optimize-autoloader --no-dev
php artisan key:generate
php artisan migrate --force
php artisan storage:link
npm install && npm run build
```

### 5. Nginx Config
Create `/etc/nginx/sites-available/webtoon`:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/webtoon-v2/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```
Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/webtoon /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 6. SSL
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d yourdomain.com
```
