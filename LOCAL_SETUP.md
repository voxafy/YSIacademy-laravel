# Local Setup

Ниже два рабочих сценария локального запуска:

- рекомендованный: `php artisan serve` для backend и `npm run dev` или `npm run build` для ассетов;
- альтернативный: запуск через Apache из XAMPP с `DocumentRoot` на папку `public`.

Если у вас Windows + XAMPP, используйте команды через `C:\xampp\php\php.exe`. В этом проекте это особенно важно: `php` может не быть добавлен в системный `PATH`.

## Требования

- PHP 8.2+
- Composer 2+
- Node.js 20+
- npm
- MySQL 8+ или MariaDB

Под Windows удобно использовать:

- XAMPP для PHP, Apache и MySQL
- локальный `composer.phar` из корня проекта

Проверка инструментов:

```powershell
& "C:\xampp\php\php.exe" -v
& "C:\xampp\php\php.exe" composer.phar --version
node -v
npm -v
```

## 1. Поднимите сервисы

Минимально нужен MySQL. Через XAMPP Control Panel:

- запустите `MySQL`;
- `Apache` нужен только если хотите открывать проект именно через XAMPP, а не через `artisan serve`.

Проверить MySQL можно через:

- `http://localhost/phpmyadmin`

## 2. Создайте базу данных

Через phpMyAdmin или SQL-консоль создайте пустую БД:

```sql
CREATE DATABASE ysi_academy_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 3. Настройте `.env`

Скопируйте шаблон:

```powershell
Copy-Item .env.example .env
```

Сгенерируйте ключ приложения:

```powershell
& "C:\xampp\php\php.exe" artisan key:generate
```

Проверьте или поправьте значения в `.env`:

```env
APP_NAME="Академия ЮСИ"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Europe/Moscow

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ysi_academy_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Если будете запускать через Apache VirtualHost, поменяйте `APP_URL` на адрес этого хоста, например `http://ysiacademy.local`.

## 4. Установите зависимости

Для Windows/XAMPP:

```powershell
& "C:\xampp\php\php.exe" composer.phar install
npm install
```

Если `php` и `composer` уже добавлены в `PATH`, можно короче:

```bash
composer install
npm install
```

## 5. Разверните схему и demo-данные

Полный старт с наполнением demo-данными:

```powershell
& "C:\xampp\php\php.exe" artisan migrate --seed
```

Что делает эта команда:

- создаёт таблицы из `database/sql/schema_reference.sql`;
- загружает demo-данные через `DatabaseSeeder` и `DemoSeeder`;
- подготавливает пользователей, курсы, уроки, тесты и медиа-ссылки.

Если нужно полностью пересоздать локальную БД с нуля:

```powershell
& "C:\xampp\php\php.exe" artisan migrate:fresh --seed
```

## 6. Соберите фронтенд-ассеты

Разовая сборка:

```powershell
npm run build
```

Режим разработки с watch:

```powershell
npm run dev
```

Что собирается:

- `resources/scss/app.scss` в `public/build/css/app.css`
- `resources/js/app.js` в `public/build/js/app.js`

Если вы просто хотите открыть сайт локально и не планируете менять стили/JS прямо сейчас, достаточно `npm run build`.

## 7. Запустите приложение

### Вариант A. Рекомендованный: встроенный PHP-сервер

Откройте отдельный терминал и запустите:

```powershell
& "C:\xampp\php\php.exe" artisan serve
```

После этого приложение будет доступно по адресу:

- `http://127.0.0.1:8000`

Для активной фронтенд-разработки обычно удобно держать два окна терминала:

Окно 1:

```powershell
& "C:\xampp\php\php.exe" artisan serve
```

Окно 2:

```powershell
npm run dev
```

### Вариант B. Через Apache в XAMPP

Если хотите открывать проект через Apache, корнем сайта должна быть папка `public`, а не корень репозитория.

Рекомендуемый `DocumentRoot`:

```text
C:/xampp/htdocs/YSIacademy-laravel/public
```

После настройки Apache:

- обновите `APP_URL` в `.env`;
- перезапустите Apache;
- откройте сайт по адресу вашего локального хоста.

Если VirtualHost пока не настроен, для быстрой проверки всё равно лучше использовать `artisan serve`.

## 8. Проверьте, что приложение поднялось

Быстрая проверка состояния:

```powershell
& "C:\xampp\php\php.exe" artisan about
```

Проверьте, что:

- `Environment` = `local`;
- `Database` = `mysql`;
- `URL` совпадает с вашим локальным адресом;
- главная страница `/` открывается без ошибок;
- логин `/login` доступен;
- стили и скрипты подгружаются из `public/build`.

## 9. Demo-аккаунты

После `artisan migrate --seed` доступны:

- `admin@demo.local`
- `leader@demo.local`
- `student1@demo.local`
- `student2@demo.local`
- `student3@demo.local`

Пароль для всех:

- `demo12345`

## 10. Медиа и файлы

Demo-файлы лежат в:

- `storage/app/public/demo`

В этом проекте медиа отдаются не прямой ссылкой на `storage`, а через Laravel route:

- `/media/{assetId}`

Поэтому отсутствие `public/storage` symlink обычно не мешает основной работе. `php artisan storage:link` можно выполнить дополнительно, но для базового локального запуска это не обязательный шаг.

## 11. Полезные команды

Очистить кеши Laravel:

```powershell
& "C:\xampp\php\php.exe" artisan optimize:clear
```

Посмотреть список маршрутов:

```powershell
& "C:\xampp\php\php.exe" artisan route:list
```

Пересидировать demo-данные без полного сброса:

```powershell
& "C:\xampp\php\php.exe" artisan db:seed
```

## 12. Частые проблемы

### `php` is not recognized

Причина: PHP не в `PATH`.

Решение:

- используйте явный путь `C:\xampp\php\php.exe`;
- либо добавьте `C:\xampp\php` в системный `PATH`.

### Нет подключения к БД

Проверьте:

- запущен ли `MySQL` в XAMPP;
- совпадают ли `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` в `.env`;
- существует ли база `ysi_academy_laravel`.

### Нет стилей или JS

Обычно помогает:

```powershell
npm run build
```

Если вы меняете фронтенд в процессе разработки, держите включённым:

```powershell
npm run dev
```

### Порт `8000` занят

Можно запустить Laravel на другом порту:

```powershell
& "C:\xampp\php\php.exe" artisan serve --port=8080
```

Тогда откройте:

- `http://127.0.0.1:8080`

И при необходимости обновите `APP_URL` в `.env`.

### Нужен самый быстрый сценарий запуска

Минимальный набор команд после создания БД:

```powershell
Copy-Item .env.example .env
& "C:\xampp\php\php.exe" composer.phar install
npm install
& "C:\xampp\php\php.exe" artisan key:generate
& "C:\xampp\php\php.exe" artisan migrate --seed
npm run build
& "C:\xampp\php\php.exe" artisan serve
```
