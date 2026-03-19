# Route Map

## Public / Auth

- `GET /` — landing
- `GET /login` — страница логина
- `POST /login` — авторизация
- `GET /register` — регистрация стажера
- `POST /register` — создание стажера
- `POST /logout` — выход
- `GET /courses` — каталог курсов
- `GET /courses/{slug}` — карточка курса
- `GET /courses/{slug}/lessons/{lessonId}` — урок
- `GET /media/{assetId}` — безопасная выдача медиа

## Profile

- `GET /profile`
- `POST /profile`

## Student

- `GET /student`
- `POST /lessons/{lessonId}/complete`
- `POST /quizzes/{quizId}/submit`

## Leader

- `GET /leader`
- `GET /leader/assignments`
- `POST /leader/assignments`
- `POST /leader/trainees`
- `GET /leader/team/{userId}`
- `GET /leader/team/{userId}/edit`
- `POST /leader/team/{userId}/edit`
- `POST /leader/decisions/{enrollmentId}`

## Admin

- `GET /admin`
- `GET /admin/users`
- `POST /admin/users`
- `GET /admin/users/{userId}`
- `POST /admin/users/{userId}`
- `GET /admin/courses`
- `POST /admin/courses`
- `POST /admin/courses/{courseId}/duplicate`
- `POST /admin/courses/{courseId}/delete`
- `GET /admin/courses/{courseId}`
- `POST /admin/courses/{courseId}`
- `POST /admin/courses/{courseId}/modules`
- `POST /admin/modules/{moduleId}/delete`
- `POST /admin/modules/{moduleId}/lessons`
- `GET /admin/lessons/{lessonId}`
- `POST /admin/lessons/{lessonId}`
- `POST /admin/lessons/{lessonId}/delete`
- `POST /admin/lessons/{lessonId}/quiz`
- `POST /admin/lessons/{lessonId}/video`
- `POST /admin/lessons/{lessonId}/video/delete`
- `POST /admin/lessons/{lessonId}/attachments`
- `POST /admin/lessons/{lessonId}/attachments/{assetId}/delete`
- `GET /admin/questions`
- `POST /admin/questions`
- `GET /admin/assignments`
- `POST /admin/assignments`
- `GET /admin/results`
- `GET /admin/results/{userId}`
- `GET /admin/media`
