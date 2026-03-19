# Database

## Общая схема

База данных перенесена в MySQL / MariaDB и покрывает все основные функциональные зоны академии:

- пользователи и роли;
- оргструктура;
- курсы и контент;
- quiz engine;
- прогресс и статусы;
- leader decisions;
- медиа и вложения;
- аудит.

## Таблицы

### Users / org

- `roles`
- `companies`
- `cities`
- `departments`
- `users`
- `auth_sessions`

### Courses / content

- `course_categories`
- `courses`
- `course_cities`
- `course_departments`
- `modules`
- `lessons`
- `lesson_blocks`

### Media

- `media_assets`
- `lesson_videos`
- `lesson_attachments`

### Quizzes

- `quizzes`
- `questions`
- `answer_options`
- `quiz_questions`
- `attempts`

### Learning progress

- `enrollments`
- `progress`
- `module_progress`
- `lesson_progress`

### Workflow / service

- `supervisor_decisions`
- `notifications`
- `platform_settings`
- `audit_logs`

## Принципы хранения

### Users

`users` хранит:

- роль;
- город;
- подразделение;
- руководителя;
- статус активации;
- пароль в `password_hash`.

### Courses

`courses` хранит:

- slug;
- title / subtitle;
- short / full description;
- target audience;
- status;
- final quiz;
- category;
- company / creator.

### Lessons

`lessons` хранит:

- тип урока;
- quiz relation;
- sort order;
- текстовые блоки и медиа через отдельные таблицы.

### Media

`media_assets` хранит:

- kind;
- original name;
- mime type;
- size;
- storage provider;
- storage path;
- metadata;
- связь с курсом и пользователем.

### Attempts / progress

`attempts` хранит:

- quiz;
- user;
- enrollment;
- score / max_score / percentage;
- passed;
- answers JSON.

`progress`, `module_progress`, `lesson_progress` хранят агрегаты и детальный прогресс.

## Seed data

Demo-данные загружаются через:

- `database/seeders/DatabaseSeeder.php`
- `database/seeders/DemoSeeder.php`

Reference SQL находится в:

- `database/sql/schema_reference.sql`
- `database/sql/seed_demo.sql`
