# Deploy

## Production requirements

- PHP 8.2+
- Composer
- MySQL / MariaDB
- Node.js 20+ только для первичной сборки ассетов
- Apache или Nginx

## 1. Клонирование и зависимости

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

Если build выполняется заранее в CI, `node_modules` на сервере не нужен.

## 2. Окружение

```bash
cp .env.example .env
php artisan key:generate
```

Заполните:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://academy.example.ru

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ysi_academy_laravel
DB_USERNAME=academy_user
DB_PASSWORD=strong_password
```

## 3. Миграции

```bash
php artisan migrate --force
```

Если нужен demo-режим:

```bash
php artisan db:seed --class=DemoSeeder --force
```

## 4. Storage

Локальные файлы и видео используются из:

- `storage/app/public`

Убедитесь, что PHP может записывать в:

- `storage/`
- `bootstrap/cache/`

## 5. Web server

### Apache

Рекомендуемый `DocumentRoot`:

- `<project>/public`

Нужен `mod_rewrite`.

### Nginx

Корень сайта:

- `<project>/public`

Все запросы должны fallback-иться в `public/index.php`.

## 6. Оптимизация

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 7. Обновление

```bash
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate --force
npm run build
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 8. Примечания

- Очереди не обязательны.
- Node.js не нужен для runtime.
- Медиа отдаются через Laravel route `/media/{assetId}`.
