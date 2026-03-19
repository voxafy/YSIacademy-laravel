# Migration Map

## Принцип миграции

Исходный проект не переписывался на месте. Весь перенос выполнен в отдельную папку:

- old: `C:\xampp\htdocs\YSIacademy`
- new: `C:\xampp\htdocs\YSIacademy-laravel`

## Карта соответствия

### Routing

- старый front controller + custom router
- новый `routes/web.php`

### Controllers

- старые `app/Controllers/*.php`
- новые `app/Http/Controllers/*.php`

### Auth

- старый `AuthService` + PHP session
- новый `AuthService` внутри Laravel session middleware

### Views

- старые PHP views
- новые Laravel views в `resources/views`
- рендер переведен на Blade shell через `PageRenderer`

### Data access

- старый `LegacyDb` / mysqli style SQL layer
- новый `App\Support\LegacyDb` поверх Laravel DB facade

### Business logic

- старые `AcademyService`, `AcademyWriteService`, `MediaService`
- новые Laravel-версии тех же сервисов в `app/Services`

### Media

- старые файлы в `storage/*`
- новые файлы в `storage/app/public/*`
- выдача через `MediaController`

### Database

- старые `sql/schema.sql`, `sql/seed_demo.sql`
- новая схема через migration bootstrap
- demo data через `DatabaseSeeder` / `DemoSeeder`

## Source -> Laravel modules

### Public site

- source: `HomeController`, `CourseController`, public views
- laravel: `HomeController`, `CourseController`, `resources/views/pages/home*`, `resources/views/pages/courses/*`

### Student

- source: `StudentController`, `AcademyService::getStudentDashboard`, `AcademyWriteService::markLessonComplete`, `submitQuiz`
- laravel: `StudentController` + same services adapted to Laravel

### Leader

- source: `LeaderController`, leader views, leader write methods
- laravel: `LeaderController` + role middleware + leader pages

### Admin

- source: `AdminController`, editor pages, question bank, assignments, results, media
- laravel: `AdminController` + corresponding pages and services

### Course editor

- source: `getCourseEditorData`, `createCourse`, `duplicateCourse`, `updateCourse`, `createModule`, `createLesson`, `updateLesson`
- laravel: same service methods, routed through `AdminController`

### Quiz engine

- source: `getQuizById`, `getQuizForAttempt`, `submitQuiz`
- laravel: same methods preserved in service layer

### Progress engine

- source: `recalculateEnrollment`, `module_progress`, `lesson_progress`
- laravel: same recalculation logic preserved in `AcademyWriteService`
