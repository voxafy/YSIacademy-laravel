# СтройТех для ЮСИ / Laravel

Laravel-миграция сервиса обучения `СтройТех`, который используется для сотрудников ЮСИ. Новый проект собран в отдельной папке и сохраняет ключевые сценарии исходной системы:

- публичная landing page и каталог курсов;
- login / register / logout;
- роли `ADMIN`, `LEADER`, `STUDENT`;
- кабинеты администратора, руководителя и стажера;
- курсы, модули, уроки, тесты, прогресс, назначения;
- решения руководителя и отчеты;
- медиатека, видеоуроки и вложения;
- редакторы курсов и уроков.

## Стек

- Laravel 12
- PHP 8.2+
- MySQL / MariaDB
- JavaScript
- Gulp
- Blade shell + Laravel routing / middleware / sessions / migrations / seeders

## Структура

- `app/Http/Controllers` — HTTP-контроллеры по ролям и сценариям
- `app/Services` — бизнес-логика LMS
- `app/Support` — helpers, DB adapter, page rendering
- `resources/views` — шаблоны интерфейса
- `resources/scss`, `resources/js` — исходники ассетов
- `public/build` — собранные CSS / JS
- `database/migrations` — схема
- `database/seeders` — demo-данные
- `database/sql` — reference schema и импортированный demo seed из исходного проекта
- `storage/app/public` — локальные медиа, файлы, видео
- `docs` — аудит, карта сущностей, маршруты, миграция, архитектура, БД

## Быстрый старт

1. Скопируйте `.env.example` в `.env`
2. Настройте MySQL-подключение
3. Установите зависимости:
   - `composer install`
   - `npm install`
4. Подготовьте приложение:
   - `php artisan key:generate`
   - `php artisan migrate --seed`
5. Соберите ассеты:
   - `npm run build`
6. Запустите локально:
   - `php artisan serve`

Подробные инструкции:

- [LOCAL_SETUP.md](LOCAL_SETUP.md)
- [GULP_SETUP.md](GULP_SETUP.md)
- [DEPLOY.md](DEPLOY.md)

## Demo-учетки

Пароль для всех: `demo12345`

- `admin@demo.local` — администратор
- `leader@demo.local` — руководитель
- `student1@demo.local` — оператор колл-центра
- `student2@demo.local` — менеджер прямого отдела продаж
- `student3@demo.local` — менеджер партнерского отдела продаж

## Что уже перенесено

- текущая навигация и layout-паттерны;
- маршруты публичной части и кабинетов;
- auth flow и role middleware;
- CRUD по пользователям, курсам, модулям и урокам;
- editor flow для курсов и уроков;
- quiz engine с попытками и результатами;
- прогресс по урокам / модулям / курсам;
- leader decisions;
- медиа-выдача и upload service;
- demo-сид на основе текущей БД проекта.

## Документация по миграции

- [docs/feature-audit.md](docs/feature-audit.md)
- [docs/entity-map.md](docs/entity-map.md)
- [docs/route-map.md](docs/route-map.md)
- [docs/migration-map.md](docs/migration-map.md)
- [docs/architecture.md](docs/architecture.md)
- [docs/database.md](docs/database.md)
