# Architecture

## High-level

Проект собран как Laravel-приложение с тонкими контроллерами и сервисным слоем, который сохраняет поведение исходной академии.

## Слои

### 1. HTTP layer

- `routes/web.php`
- `app/Http/Controllers/*`
- `app/Http/Middleware/*`

Задачи:

- маршруты;
- авторизация и роль-доступ;
- прием форм;
- редиректы;
- передача данных во view.

### 2. Service layer

- `app/Services/AuthService.php`
- `app/Services/AcademyService.php`
- `app/Services/AcademyWriteService.php`
- `app/Services/MediaService.php`

Задачи:

- бизнес-логика LMS;
- выборки данных;
- mutations;
- progress recalculation;
- quiz engine;
- media handling.

### 3. Support layer

- `app/Support/LegacyDb.php`
- `app/Support/PageRenderer.php`
- `app/Support/helpers.php`

Задачи:

- SQL adapter поверх Laravel DB;
- совместимость со структурой старых view;
- общие helper-функции для UI и domain logic.

### 4. Presentation layer

- `resources/views/layouts`
- `resources/views/partials`
- `resources/views/pages`

Подход:

- Blade layout shell;
- переиспользование перенесенного HTML / PHP markup;
- единый header;
- сохранение UX существующей системы.

### 5. Assets

- `resources/scss/app.scss`
- `resources/js/app.js`
- `gulpfile.js`
- `public/build/*`

Подход:

- Gulp собирает CSS и JS;
- runtime не зависит от Node.js;
- Laravel отдает уже собранные ассеты.

### 6. Data layer

- `database/migrations`
- `database/seeders`
- `database/sql`

Подход:

- schema bootstrap миграцией;
- demo data через seeder;
- reference SQL сохранен для аудита миграции.

## Folder Map

- `app/Http/Controllers` — контроллеры
- `app/Http/Middleware` — guards и auth middleware
- `app/Services` — доменная логика
- `app/Support` — infrastructural helpers
- `database/migrations` — schema bootstrap
- `database/seeders` — demo data
- `resources/views` — UI
- `resources/scss`, `resources/js` — source assets
- `public/build` — compiled assets
- `storage/app/public` — файлы, видео, demo media

## Почему архитектура такая

- минимально ломает текущую бизнес-логику;
- переносит систему в поддерживаемый Laravel runtime;
- оставляет SQL и сервисы прозрачными;
- не перегружает MVP лишними abstraction layers.
