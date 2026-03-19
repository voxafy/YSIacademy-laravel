# Local Setup

## Требования

- PHP 8.2+
- Composer
- Node.js 20+
- MySQL / MariaDB

Для Windows можно использовать:

- XAMPP для MySQL
- `C:\xampp\php\php.exe` для artisan/composer

## 1. Установка зависимостей

```bash
composer install
npm install
```

## 2. Настройка окружения

```bash
copy .env.example .env
php artisan key:generate
```

Заполните в `.env`:

```env
APP_NAME="Академия ЮСИ"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ysi_academy_laravel
DB_USERNAME=root
DB_PASSWORD=
```

## 3. База данных

Создайте БД:

```sql
CREATE DATABASE ysi_academy_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Затем выполните:

```bash
php artisan migrate --seed
```

## 4. Ассеты

```bash
npm run build
```

## 5. Локальный запуск

```bash
php artisan serve
```

По умолчанию приложение откроется по адресу:

- `http://127.0.0.1:8000`

## 6. Demo-данные

После `php artisan migrate --seed` доступны demo-аккаунты:

- `admin@demo.local`
- `leader@demo.local`
- `student1@demo.local`
- `student2@demo.local`
- `student3@demo.local`

Пароль:

- `demo12345`

## 7. Медиа

Demo-файлы лежат в:

- `storage/app/public/demo`

Медиа отдаются не напрямую из `storage`, а через Laravel-маршрут:

- `/media/{assetId}`
