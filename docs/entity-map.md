# Entity Map

## Основные сущности

### Пользователи и оргструктура

- `roles` — роли `ADMIN`, `LEADER`, `STUDENT`
- `companies` — компания-владелец данных
- `cities` — справочник городов
- `departments` — подразделения
- `users` — пользователи платформы
- `auth_sessions` — авторизационные сессии

### Курсы и контент

- `course_categories` — категории курсов
- `courses` — курсы
- `course_cities` — ограничения курса по городам
- `course_departments` — ограничения курса по подразделениям
- `modules` — модули курса
- `lessons` — уроки модуля
- `lesson_blocks` — текстовые / структурные блоки урока

### Медиа

- `media_assets` — универсальная медиатека
- `lesson_videos` — связка урока с видео
- `lesson_attachments` — вложения урока

### Quiz engine

- `quizzes` — тесты
- `questions` — банк вопросов
- `answer_options` — варианты ответа
- `quiz_questions` — связь quiz <-> question
- `attempts` — попытки прохождения

### Обучение и прогресс

- `enrollments` — назначения курсов
- `progress` — агрегированный прогресс по курсу
- `module_progress` — прогресс по модулю
- `lesson_progress` — прогресс по уроку

### Руководитель и сервисные сущности

- `supervisor_decisions` — решения руководителя
- `notifications` — уведомления
- `platform_settings` — настройки платформы
- `audit_logs` — аудит действий

## Связи

- `users.role_id -> roles.id`
- `users.city_id -> cities.id`
- `users.department_id -> departments.id`
- `users.supervisor_id -> users.id`
- `courses.category_id -> course_categories.id`
- `courses.company_id -> companies.id`
- `courses.created_by_id -> users.id`
- `courses.final_quiz_id -> quizzes.id`
- `modules.course_id -> courses.id`
- `modules.quiz_id -> quizzes.id`
- `lessons.module_id -> modules.id`
- `lessons.quiz_id -> quizzes.id`
- `lesson_blocks.lesson_id -> lessons.id`
- `lesson_videos.lesson_id -> lessons.id`
- `lesson_videos.media_asset_id -> media_assets.id`
- `lesson_attachments.lesson_id -> lessons.id`
- `lesson_attachments.asset_id -> media_assets.id`
- `quiz_questions.quiz_id -> quizzes.id`
- `quiz_questions.question_id -> questions.id`
- `answer_options.question_id -> questions.id`
- `enrollments.user_id -> users.id`
- `enrollments.course_id -> courses.id`
- `progress.enrollment_id -> enrollments.id`
- `module_progress.enrollment_id -> enrollments.id`
- `lesson_progress.enrollment_id -> enrollments.id`
- `attempts.enrollment_id -> enrollments.id`
- `attempts.quiz_id -> quizzes.id`
- `supervisor_decisions.enrollment_id -> enrollments.id`
- `supervisor_decisions.leader_id -> users.id`
