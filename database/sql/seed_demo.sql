SET NAMES utf8mb4;

SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM audit_logs;

DELETE FROM platform_settings;

DELETE FROM notifications;

DELETE FROM supervisor_decisions;

DELETE FROM attempts;

DELETE FROM lesson_progress;

DELETE FROM module_progress;

DELETE FROM progress;

DELETE FROM enrollments;

DELETE FROM quiz_questions;

DELETE FROM answer_options;

DELETE FROM questions;

DELETE FROM lesson_attachments;

DELETE FROM lesson_videos;

DELETE FROM media_assets;

DELETE FROM lesson_blocks;

DELETE FROM lessons;

DELETE FROM modules;

DELETE FROM course_departments;

DELETE FROM course_cities;

DELETE FROM courses;

DELETE FROM quizzes;

DELETE FROM course_categories;

DELETE FROM auth_sessions;

DELETE FROM users;

DELETE FROM departments;

DELETE FROM cities;

DELETE FROM companies;

DELETE FROM roles;

INSERT INTO roles (`id`, `key`, `name`, `description`) VALUES ('cmmq0rgun0001irhgwps91rsd', 'ADMIN', 'Администратор', 'Управляет платформой и контентом.');

INSERT INTO roles (`id`, `key`, `name`, `description`) VALUES ('cmmq0rgun0002irhgzsztkztu', 'STUDENT', 'Ученик', 'Проходит курсы и тесты.');

INSERT INTO roles (`id`, `key`, `name`, `description`) VALUES ('cmmq0rgun0003irhg6rm2fw1g', 'LEADER', 'Руководитель', 'Контролирует результаты команды.');

INSERT INTO companies (`id`, `name`, `slug`, `subtitle`, `created_at`, `updated_at`) VALUES ('cmmq0rguj0000irhgqxxoq9qq', 'ЮгСтройИнвест', 'yugstrojinvest', 'Компания ЮСИ', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO cities (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rguu0005irhg8m2eu2wc', 'Краснодар', 'krasnodar', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO cities (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rguv0007irhg4cqp21vn', 'Кисловодск', 'kislovodsk', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO cities (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rguu0006irhgj08gqvu5', 'Мариуполь', 'mariupol', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO cities (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rguu0004irhggr5iy8kb', 'Ставрополь', 'stavropol', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO cities (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rguv0008irhg5h49gxuk', 'Ростов-на-Дону', 'rostov-na-donu', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO departments (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rgw40009irhgw3thakcs', 'Колл-центр', 'call-center', 'Квалификация и первичные касания.', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO departments (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rgw4000cirhg7epe2h7c', 'Контроль качества', 'quality-control', 'Антифрод и качество CRM.', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO departments (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rgw4000dirhglyysjpp8', 'Администрирование', 'administration', 'Управление сервисом обучения.', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO departments (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rgw4000birhgefdp9bwy', 'Прямой отдел продаж', 'direct-sales', 'Встречи, брони, договор.', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO departments (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES ('cmmq0rgw4000airhgk7ehdyza', 'Партнерский отдел продаж', 'partner-sales', 'Агенты, агентства, фиксация.', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxu000girhgrgvdak5s', '03-pryamoj-otdel-prodazh', '03. Прямой отдел продаж', 'Встречи, решение, договор.', 3);

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxv000jirhgf1ej9i93', '06-kontrol-kachestva-i-antifrod', '06. Контроль качества и антифрод', 'Критичные нарушения и разбор рисков.', 6);

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxv000iirhgi3gkis5g', '05-allio-i-smezhnye-protsessy', '05. Allio и смежные процессы', 'Подбор, бронь и синхронизация.', 5);

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxu000hirhg4xanaqha', '04-partnerskij-otdel-prodazh', '04. Партнерский отдел продаж', 'Агенты и фиксация клиента.', 4);

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxu000eirhg1radpfwh', '01-vvodnyj-blok', '01. Вводный блок', 'Онбординг и структура обучения.', 1);

INSERT INTO course_categories (`id`, `slug`, `title`, `description`, `sort_order`) VALUES ('cmmq0rgxu000firhgp9g8n6le', '02-koll-tsentr', '02. Колл-центр', 'Этапы КЦ и квалификация.', 2);

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh4v005dirhgzq0u16m7', 'Финальная проверка по СтройТех', 'Короткая проверка по ролям, статусам и логике платформы.', 'FINAL', 70, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh4w005nirhgflro31nj', 'Итоговый тест: менеджер прямого отдела продаж', 'Проверка по консультациям, встречам, броням, договору и корректному закрытию.', 'FINAL', 85, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh5s009birhgxrg9mhsk', 'Проверка модуля: Принятие клиента после консультации', 'Мини-тест по модулю «Принятие клиента после консультации».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh60009rirhg3l4q41c5', 'Проверка модуля: Онлайн-консультации, встречи и показы', 'Мини-тест по модулю «Онлайн-консультации, встречи и показы».', 'MODULE', 85, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh6400a0irhgnohr1g44', 'Проверка модуля: Как устроен СтройТех', 'Мини-тест по модулю «Как устроен СтройТех».', 'MODULE', 70, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh6a00aeirhglkydgepl', 'Проверка модуля: Статусы и итоговое решение', 'Мини-тест по модулю «Статусы и итоговое решение».', 'MODULE', 70, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh4v005lirhgl81opbfj', 'Итоговый тест: оператор колл-центра', 'Проверка по этапам КЦ, частоте касаний, качеству задач и передаче в ОП.', 'FINAL', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh6l00b2irhg26fygdly', 'Проверка модуля: Лид и первичная квалификация', 'Мини-тест по модулю «Лид и первичная квалификация».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh6r00biirhgpmjvyesv', 'Проверка модуля: Не отвечает и отложенный спрос', 'Мини-тест по модулю «Не отвечает и отложенный спрос».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh7100c5irhgtw77m3dp', 'Проверка модуля: Принятие решения и бронирование', 'Мини-тест по модулю «Принятие решения и бронирование».', 'MODULE', 85, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh7e00crirhg6fuh1l6u', 'Проверка модуля: Выявление потребностей и горячий клиент', 'Мини-тест по модулю «Выявление потребностей и горячий клиент».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh8y00dvirhg1m4fju5k', 'Проверка модуля: Синхронизация с amoCRM и риски', 'Мини-тест по модулю «Синхронизация с amoCRM и риски».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh4v005firhg3pxnw9mx', 'Итоговый тест: базовый курс по amoCRM', 'Финальная проверка по задачам, дублям, коммуникациям, этапам, антифроду и Allio.', 'FINAL', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh9o00enirhgvs72xcg4', 'Проверка модуля: Рабочий стол и логика интерфейса', 'Мини-тест по модулю «Рабочий стол и логика интерфейса».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh9w00f3irhg9wzttzhd', 'Проверка модуля: Сделки, контакты и задачи', 'Мини-тест по модулю «Сделки, контакты и задачи».', 'MODULE', 75, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rha400fkirhge4xb0b4x', 'Проверка модуля: Создание сделки и проверка дублей', 'Мини-тест по модулю «Создание сделки и проверка дублей».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhaa00g0irhgvy14yxks', 'Проверка модуля: Фиксация коммуникаций и комментарии', 'Мини-тест по модулю «Фиксация коммуникаций и комментарии».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhah00ggirhg7mbj3v7k', 'Проверка модуля: Этапы воронки и корректные переводы', 'Мини-тест по модулю «Этапы воронки и корректные переводы».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhap00gwirhg1bepww7j', 'Проверка модуля: Причины отказа и корректное закрытие', 'Мини-тест по модулю «Причины отказа и корректное закрытие».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhav00hcirhgdey79qsv', 'Проверка модуля: Антифрод, качество и критичные ошибки', 'Мини-тест по модулю «Антифрод, качество и критичные ошибки».', 'MODULE', 85, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhb300htirhgnd4teoa4', 'Проверка модуля: Allio, бронирование и синхронизация', 'Мини-тест по модулю «Allio, бронирование и синхронизация».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rh4x007uirhgyvoodiux', 'Итоговый тест: партнерский отдел продаж', 'Проверка по агентам, агентствам, уникальности клиента и правилам фиксации.', 'FINAL', 82, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhca00ihirhg11f5wxsk', 'Проверка модуля: Структура партнерской сделки', 'Мини-тест по модулю «Структура партнерской сделки».', 'MODULE', 80, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhcj00ixirhgut6ghsvv', 'Проверка модуля: Уникальность, фиксация и пересечения', 'Мини-тест по модулю «Уникальность, фиксация и пересечения».', 'MODULE', 82, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO quizzes (`id`, `title`, `description`, `scope`, `pass_score`, `max_attempts`, `shuffle_questions`, `created_at`, `updated_at`) VALUES ('cmmq0rhcq00jdirhg80m7uzvn', 'Проверка модуля: Коммуникация с агентом, встречи и решения', 'Мини-тест по модулю «Коммуникация с агентом, встречи и решения».', 'MODULE', 82, NULL, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO users (`id`, `email`, `full_name`, `phone`, `title`, `password_hash`, `approval_status`, `role_id`, `company_id`, `city_id`, `department_id`, `supervisor_id`, `bio`, `created_at`, `updated_at`) VALUES ('cmmq0rh23000mirhgcq9pi09y', 'admin@demo.local', 'Администратор ЮСИ', '+7 900 100-00-01', 'Администратор сервиса СтройТех', '$2b$10$GWdWQ/2tGDJhT.eEPTPNhumKpnbls0a0Md8CISpsURKHXYmj9tmY2', 'ACTIVE', 'cmmq0rgun0001irhgwps91rsd', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rguu0005irhg8m2eu2wc', 'cmmq0rgw4000dirhglyysjpp8', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 12:10:43');

INSERT INTO users (`id`, `email`, `full_name`, `phone`, `title`, `password_hash`, `approval_status`, `role_id`, `company_id`, `city_id`, `department_id`, `supervisor_id`, `bio`, `created_at`, `updated_at`) VALUES ('cmmq0rh25000oirhgeovr0ni1', 'leader@demo.local', 'Игорь Морозов', '+7 900 100-00-02', 'Руководитель обучения ЮСИ', '$2b$10$rcQw7dYkpXp/7reUsYT8GOkx7RTtHQk7VNnGc.o..gJEzQfgt98cW', 'ACTIVE', 'cmmq0rgun0003irhg6rm2fw1g', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rguv0008irhg5h49gxuk', 'cmmq0rgw4000cirhg7epe2h7c', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO users (`id`, `email`, `full_name`, `phone`, `title`, `password_hash`, `approval_status`, `role_id`, `company_id`, `city_id`, `department_id`, `supervisor_id`, `bio`, `created_at`, `updated_at`) VALUES ('cmmq0rh26000qirhg5v3pco2h', 'student1@demo.local', 'Мария Егорова', '+7 900 100-00-11', 'Оператор колл-центра', '$2b$10$rcQw7dYkpXp/7reUsYT8GOkx7RTtHQk7VNnGc.o..gJEzQfgt98cW', 'ACTIVE', 'cmmq0rgun0002irhgzsztkztu', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rguu0004irhggr5iy8kb', 'cmmq0rgw40009irhgw3thakcs', 'cmmq0rh25000oirhgeovr0ni1', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO users (`id`, `email`, `full_name`, `phone`, `title`, `password_hash`, `approval_status`, `role_id`, `company_id`, `city_id`, `department_id`, `supervisor_id`, `bio`, `created_at`, `updated_at`) VALUES ('cmmq0rh28000sirhg8quemref', 'student2@demo.local', 'Антон Беляев', '+7 900 100-00-12', 'Менеджер прямого отдела продаж', '$2b$10$rcQw7dYkpXp/7reUsYT8GOkx7RTtHQk7VNnGc.o..gJEzQfgt98cW', 'ACTIVE', 'cmmq0rgun0002irhgzsztkztu', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rguu0005irhg8m2eu2wc', 'cmmq0rgw4000birhgefdp9bwy', 'cmmq0rh25000oirhgeovr0ni1', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO users (`id`, `email`, `full_name`, `phone`, `title`, `password_hash`, `approval_status`, `role_id`, `company_id`, `city_id`, `department_id`, `supervisor_id`, `bio`, `created_at`, `updated_at`) VALUES ('cmmq0rh2b000uirhghbj4y00i', 'student3@demo.local', 'София Руденко', '+7 900 100-00-13', 'Менеджер партнерского отдела продаж', '$2b$10$rcQw7dYkpXp/7reUsYT8GOkx7RTtHQk7VNnGc.o..gJEzQfgt98cW', 'ACTIVE', 'cmmq0rgun0002irhgzsztkztu', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rguv0008irhg5h49gxuk', 'cmmq0rgw4000airhgk7ehdyza', 'cmmq0rh25000oirhgeovr0ni1', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh5p0092irhgzw7oxjul', 'menedzher-pryamogo-otdela-prodazh-ysi', 'Менеджер прямого отдела продаж ЮСИ', 'Встречи, показы, решения, брони и договор', 'Курс для менеджеров прямого ОП: от принятия клиента до успешной реализации.', 'Программа для прямого отдела продаж с акцентом на консультации, встречи, ожидание после встречи, принятие решения, бронирование и договор.', 'Маршрут менеджера ОП от встречи до сделки', 'Показываем правила этапов, синхронизацию данных и ошибки, которые портят отчетность.', 'Менеджеры прямого отдела продаж', '#2c6cff', '#132d5f', 'PUBLISHED', 0, 105, 85, 'cmmq0rgxu000girhgrgvdak5s', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', 'cmmq0rh4w005nirhgflro31nj', NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh4x0087irhgdorgouv1', 'strojteh-start-v-protsessah-ysi', 'СтройТех: старт в процессах ЮСИ', 'Как устроено обучение, статусы и итоговое согласование', 'Вводный курс по сервису СтройТех, маршруту обучения и роли руководителя.', 'Курс объясняет маршрут сотрудника от регистрации до итогового решения руководителя и показывает, как СтройТех работает как управляемая точка допуска к рабочим процессам ЮСИ.', 'Старт в СтройТех без лишних вопросов', 'Что видит ученик, что контролирует руководитель и как строится маршрут обучения.', 'Все сотрудники ЮСИ', '#0d5de7', '#0d2148', 'PUBLISHED', 0, 35, 70, 'cmmq0rgxu000eirhg1radpfwh', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', 'cmmq0rh4v005dirhgzq0u16m7', NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6j00atirhgiy2kz3z7', 'operator-koll-tsentra-ysi-v-amocrm', 'Оператор колл-центра ЮСИ в amoCRM', 'Этапы КЦ, частота касаний и качественная квалификация', 'Курс по этапам колл-центра: лид, не отвечает, отложенный спрос, горячий клиент и передача в ОП.', 'Ролевая программа для операторов колл-центра с фокусом на первичную квалификацию, частоту касаний, постановку задач и передачу сделки менеджеру ОП.', 'Качественная первичная квалификация без потери клиента', 'Как вести клиента по этапам КЦ и готовить сделку к передаче в отдел продаж.', 'Операторы колл-центра', '#0f74ff', '#0b264f', 'PUBLISHED', 0, 95, 75, 'cmmq0rgxu000firhgp9g8n6le', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', 'cmmq0rh4v005lirhgl81opbfj', NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh4w006xirhgg4g8puiy', 'allio-dlya-menedzhera-ysi', 'Allio для менеджера ЮСИ', 'Подбор объектов, КП, бронирование и риски синхронизации', 'Курс по Allio: подбор объектов, КП, бронирование и контроль синхронизации.', 'Курс показывает рабочую логику использования Allio в связке с amoCRM, чтобы сотрудники ЮСИ не путали этапы и не теряли контроль над бронями.', 'Allio как часть маршрута сделки', 'Учимся подбирать объекты, отправлять предложения и синхронизировать бронь с CRM.', 'Менеджеры ОП и партнерского отдела', '#0f68e8', '#10284f', 'PUBLISHED', 0, 60, 75, 'cmmq0rgxv000iirhgi3gkis5g', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', NULL, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9l00ecirhgu22760el', 'amocrm-ysi-bazovyj-kurs-dlya-novyh-sotrudnikov', 'amoCRM ЮСИ: базовый курс для новых сотрудников', 'Главный курс по ежедневной работе в CRM', 'Полный курс по задачам, сделкам, дублям, коммуникациям, этапам и антифроду.', 'Главный курс по операционной работе в amoCRM ЮСИ. Он объясняет логику интерфейса, обязательные действия менеджера, ключевые ограничения и критические ошибки, которые нельзя допускать при работе в amoCRM ЮСИ.', 'Главный курс по ежедневной работе в amoCRM', 'От рабочего стола и задач до причин отказа, дублей, антифрода и связки с Allio.', 'Новые сотрудники ЮСИ', '#1264f2', '#0b1d44', 'PUBLISHED', 0, 180, 80, 'cmmq0rgxu000eirhg1radpfwh', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', 'cmmq0rh4v005firhg3pxnw9mx', NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhc800ibirhg6gct05li', 'partnerskij-otdel-prodazh-ysi', 'Партнерский отдел продаж ЮСИ', 'Клиент, агент, агентство и фиксация уникальности', 'Курс по партнерским сделкам: агент, клиент, агентство, пересечения и бронь через Allio.', 'Ролевая программа для менеджеров партнерского отдела продаж с фокусом на уникальность клиента, фиксацию за агентом и правила коммуникации с агентом и агентством.', 'Партнерская сделка без дублей и конфликтов', 'Фиксация клиента за агентом, контроль агентства и прозрачное управление пересечениями.', 'Менеджеры партнерского отдела', '#1459de', '#0d2049', 'PUBLISHED', 0, 100, 82, 'cmmq0rgxu000hirhg4xanaqha', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', 'cmmq0rh4x007uirhgyvoodiux', NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO courses (`id`, `slug`, `title`, `subtitle`, `short_description`, `description`, `hero_title`, `hero_description`, `target_audience`, `accent_color`, `dark_accent_color`, `status`, `is_template`, `estimated_minutes`, `pass_score`, `category_id`, `company_id`, `created_by_id`, `final_quiz_id`, `cover_asset_id`, `template_source_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh4w007airhgnxlfwibv', 'kontrol-kachestva-antifrod-dubli-i-peresecheniya', 'Контроль качества ЮСИ: антифрод, дубли и пересечения', 'Критичные нарушения и управленческие риски', 'Курс о критичных нарушениях: беззадачные сделки, просрочки, дубли, пересечения и причины отказа.', 'Курс нужен руководителям, администраторам и сотрудникам как единый слой по критическим нарушениям, которые искажают работу CRM и могут приводить к изъятию сделки.', 'Контроль качества — не формальность', 'Показываем нарушения, которые влияют на результат продаж и прозрачность отчетов.', 'Все подразделения', '#155ce0', '#10244e', 'PUBLISHED', 0, 58, 80, 'cmmq0rgxv000jirhgf1ej9i93', 'cmmq0rguj0000irhgqxxoq9qq', 'cmmq0rh23000mirhgcq9pi09y', NULL, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh5p0094irhgv81piyh1', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh5p0095irhgogwbudcg', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh5p0096irhg8d0cs4fl', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh5p0097irhgz070tln2', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh5p0098irhgmxgaz761', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4x0089irhgztf0tizo', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4x008airhg62krj38y', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4x008birhgo0lyu5ff', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4x008cirhgpvnn618q', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4x008dirhgozhn375h', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh6j00avirhg2qd2cqap', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh6j00awirhgkjcqs65q', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh6j00axirhgwpnfp2fd', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh6j00ayirhg50zmu18b', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh6j00azirhgsockp568', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w006zirhgyerxxp3p', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w0070irhgq9f8sxh0', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w0071irhgk6hauslz', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w0072irhgcsftjg3o', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w0073irhgxt0trniy', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh9l00eeirhgf1cnp9fn', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh9l00efirhg8elnmseh', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh9l00egirhg02izcnh5', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh9l00ehirhgopmhq9l4', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh9l00eiirhgpd76y3qd', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rhc800idirhgbtagvhbr', 'cmmq0rhc800ibirhg6gct05li', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rhc800ieirhgm93pvsmb', 'cmmq0rhc800ibirhg6gct05li', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w007firhgw712t8v0', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rguu0004irhggr5iy8kb');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w007hirhgim2lorvi', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rguu0006irhgj08gqvu5');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w007jirhg3io0dv6g', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rguu0005irhg8m2eu2wc');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w007kirhgf5laqsu8', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rguv0008irhg5h49gxuk');

INSERT INTO course_cities (`id`, `course_id`, `city_id`) VALUES ('cmmq0rh4w007mirhg7jdvennb', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rguv0007irhg4cqp21vn');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh5p009airhgwpqspinu', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rgw4000birhgefdp9bwy');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x008firhgio252wl2', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rgw40009irhgw3thakcs');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x008girhgwm1g8edx', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rgw4000birhgefdp9bwy');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x008hirhg618nsrrp', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rgw4000airhgk7ehdyza');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh6j00b1irhg6625kc51', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rgw40009irhgw3thakcs');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4w0077irhg9ipcudya', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rgw4000birhgefdp9bwy');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4w0078irhgva4a5i3k', 'cmmq0rh4w006xirhgg4g8puiy', 'cmmq0rgw4000airhgk7ehdyza');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh9l00ekirhgx1gxdwuf', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rgw40009irhgw3thakcs');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh9l00elirhgqnsinkt5', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rgw4000birhgefdp9bwy');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh9l00emirhgw0lv6d0m', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rgw4000airhgk7ehdyza');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rhc800igirhgvrkfhf1r', 'cmmq0rhc800ibirhg6gct05li', 'cmmq0rgw4000airhgk7ehdyza');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x007pirhgxh013lv3', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rgw40009irhgw3thakcs');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x007qirhg7upp8s9c', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rgw4000birhgefdp9bwy');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x007rirhgmbxhc836', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rgw4000airhgk7ehdyza');

INSERT INTO course_departments (`id`, `course_id`, `department_id`) VALUES ('cmmq0rh4x007sirhg52thrmc9', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rgw4000cirhg7epe2h7c');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh5t009jirhgggqhfrkl', 'cmmq0rh5p0092irhgzw7oxjul', 'Принятие клиента после консультации', 'Как подхватить квалифицированного клиента и не потерять контекст.', 'Как подхватить квалифицированного клиента и не потерять контекст.', 1, 20, 80, 1, 'cmmq0rh5s009birhgxrg9mhsk', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6600a6irhgfznreogh', 'cmmq0rh4x0087irhgdorgouv1', 'Как устроен СтройТех', 'Роли, кабинеты и маршрут обучения.', 'Роли, кабинеты и маршрут обучения.', 1, 10, 70, 1, 'cmmq0rh6400a0irhgnohr1g44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6b00akirhgddy0euz0', 'cmmq0rh4x0087irhgdorgouv1', 'Статусы и итоговое решение', 'Как читаются статусы и что происходит после финального теста.', 'Как читаются статусы и что происходит после финального теста.', 2, 12, 70, 1, 'cmmq0rh6a00aeirhglkydgepl', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6n00bairhgpxyyt15q', 'cmmq0rh6j00atirhgiy2kz3z7', 'Лид и первичная квалификация', 'Старт работы с новым клиентом и первая логика оценки лида.', 'Старт работы с новым клиентом и первая логика оценки лида.', 1, 18, 75, 1, 'cmmq0rh6l00b2irhg26fygdly', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6t00bqirhgpr18dzj7', 'cmmq0rh6j00atirhgiy2kz3z7', 'Не отвечает и отложенный спрос', 'Повторные касания, разумные сроки задач и корректное ведение клиента.', 'Повторные касания, разумные сроки задач и корректное ведение клиента.', 2, 20, 75, 1, 'cmmq0rh6r00biirhgpmjvyesv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh63009zirhgpcyn9y02', 'cmmq0rh5p0092irhgzw7oxjul', 'Онлайн-консультации, встречи и показы', 'Логика полноценных консультаций и контроль их результата.', 'Логика полноценных консультаций и контроль их результата.', 2, 24, 85, 1, 'cmmq0rh60009rirhg3l4q41c5', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7300cdirhg9gyqacfr', 'cmmq0rh5p0092irhgzw7oxjul', 'Принятие решения и бронирование', 'Как вести сделку после консультации и переводить в бронь без потери логики.', 'Как вести сделку после консультации и переводить в бронь без потери логики.', 3, 24, 85, 1, 'cmmq0rh7100c5irhgtw77m3dp', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7600cmirhgrmptcrxx', 'cmmq0rh5p0092irhgzw7oxjul', 'Заключение договора и успешная реализация', 'Договор, проверка пакета документов и перевод сделки в успешную реализацию.', 'Договор, проверка пакета документов и перевод сделки в успешную реализацию.', 4, 12, 80, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7g00czirhga4fnqf0u', 'cmmq0rh6j00atirhgiy2kz3z7', 'Выявление потребностей и горячий клиент', 'Сбор параметров клиента и перевод к консультации.', 'Сбор параметров клиента и перевод к консультации.', 3, 22, 75, 1, 'cmmq0rh7e00crirhg6fuh1l6u', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7u00d8irhg2b9gbokz', 'cmmq0rh6j00atirhgiy2kz3z7', 'Первичная консультация назначена', 'Подготовка сделки к консультации и контроль полноты данных перед передачей в ОП.', 'Подготовка сделки к консультации и контроль полноты данных перед передачей в ОП.', 4, 10, 70, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7y00deirhgvxvei2rb', 'cmmq0rh6j00atirhgiy2kz3z7', 'Передача в ОП и качество фиксации', 'Какие данные обязательны при передаче сделки менеджеру ОП и как не потерять контекст клиента.', 'Какие данные обязательны при передаче сделки менеджеру ОП и как не потерять контекст клиента.', 5, 10, 70, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh8r00dkirhgo0zaabse', 'cmmq0rh4w006xirhgg4g8puiy', 'Галерея объектов и подбор', 'Как использовать подбор по параметрам без потери клиентского контекста.', 'Как использовать подбор по параметрам без потери клиентского контекста.', 1, 16, 75, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh8v00dqirhgfkltpya2', 'cmmq0rh4w006xirhgg4g8puiy', 'Коммерческое предложение и бронь', 'Как работать с предложением и переводить клиента в бронь.', 'Как работать с предложением и переводить клиента в бронь.', 2, 20, 75, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh8z00e3irhg82qcwaow', 'cmmq0rh4w006xirhgg4g8puiy', 'Синхронизация с amoCRM и риски', 'Где чаще всего происходят ошибки между Allio и CRM.', 'Где чаще всего происходят ошибки между Allio и CRM.', 3, 18, 75, 1, 'cmmq0rh8y00dvirhg1m4fju5k', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9q00evirhgh4icrtdw', 'cmmq0rh9l00ecirhgu22760el', 'Рабочий стол и логика интерфейса', 'Навигация, виджеты и фильтры.', 'Навигация, виджеты и фильтры.', 1, 18, 75, 1, 'cmmq0rh9o00enirhgvs72xcg4', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9x00fbirhg6ogxpvvc', 'cmmq0rh9l00ecirhgu22760el', 'Сделки, контакты и задачи', 'Главный принцип ежедневной работы через задачи.', 'Главный принцип ежедневной работы через задачи.', 2, 24, 75, 1, 'cmmq0rh9w00f3irhg9wzttzhd', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rha600fsirhg422jvah2', 'cmmq0rh9l00ecirhgu22760el', 'Создание сделки и проверка дублей', 'Проверка номера, дублей и пересечений перед созданием.', 'Проверка номера, дублей и пересечений перед созданием.', 3, 22, 80, 1, 'cmmq0rha400fkirhge4xb0b4x', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhab00g8irhgrg55e86p', 'cmmq0rh9l00ecirhgu22760el', 'Фиксация коммуникаций и комментарии', 'Подтверждение звонков, переписок и офлайн-консультаций.', 'Подтверждение звонков, переписок и офлайн-консультаций.', 4, 24, 80, 1, 'cmmq0rhaa00g0irhgvy14yxks', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhai00goirhg9mb67drv', 'cmmq0rh9l00ecirhgu22760el', 'Этапы воронки и корректные переводы', 'Этапы отражают реальный прогресс, а не удобство менеджера.', 'Этапы отражают реальный прогресс, а не удобство менеджера.', 5, 22, 80, 1, 'cmmq0rhah00ggirhg7mbj3v7k', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhar00h4irhgys8cju75', 'cmmq0rh9l00ecirhgu22760el', 'Причины отказа и корректное закрытие', 'Как правильно выбирать причину отказа и закрывать сделку.', 'Как правильно выбирать причину отказа и закрывать сделку.', 6, 20, 80, 1, 'cmmq0rhap00gwirhg1bepww7j', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhaw00hkirhgzwy531zq', 'cmmq0rh9l00ecirhgu22760el', 'Антифрод, качество и критичные ошибки', 'Нарушения, которые могут привести к изъятию сделки.', 'Нарушения, которые могут привести к изъятию сделки.', 7, 24, 85, 1, 'cmmq0rhav00hcirhgdey79qsv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhb500i1irhg8jsplhxr', 'cmmq0rh9l00ecirhgu22760el', 'Allio, бронирование и синхронизация', 'Как работать с бронью и не допускать неверных переводов между системами.', 'Как работать с бронью и не допускать неверных переводов между системами.', 8, 18, 80, 1, 'cmmq0rhb300htirhgnd4teoa4', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcc00ipirhgum0oj68x', 'cmmq0rhc800ibirhg6gct05li', 'Структура партнерской сделки', 'Клиент, агент и компания агентства как обязательные сущности.', 'Клиент, агент и компания агентства как обязательные сущности.', 1, 18, 80, 1, 'cmmq0rhca00ihirhg11f5wxsk', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcl00j5irhgd6946q48', 'cmmq0rhc800ibirhg6gct05li', 'Уникальность, фиксация и пересечения', 'Проверка клиента, агента и сроков фиксации перед началом работы.', 'Проверка клиента, агента и сроков фиксации перед началом работы.', 2, 24, 82, 1, 'cmmq0rhcj00ixirhgut6ghsvv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcr00jlirhgwr6k4tm4', 'cmmq0rhc800ibirhg6gct05li', 'Коммуникация с агентом, встречи и решения', 'Особые правила общения с агентом и контроль шагов до брони.', 'Особые правила общения с агентом и контроль шагов до брони.', 3, 24, 82, 1, 'cmmq0rhcq00jdirhg80m7uzvn', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcw00juirhgzbp8uaeb', 'cmmq0rhc800ibirhg6gct05li', 'Бронирование и договор', 'Бронь в Allio, фиксация клиента за агентом и переход к договору без конфликтов и потери статуса.', 'Бронь в Allio, фиксация клиента за агентом и переход к договору без конфликтов и потери статуса.', 4, 12, 80, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhdw00k0irhgnuz0etkv', 'cmmq0rh4w007airhgnxlfwibv', 'Сделка без задачи и просроченные действия', 'Почему отсутствие задачи и длительная просрочка — красные флаги качества.', 'Почему отсутствие задачи и длительная просрочка — красные флаги качества.', 1, 18, 80, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhe100k7irhgtw0wbjmx', 'cmmq0rh4w007airhgnxlfwibv', 'Дубли, пересечения и параллельное общение', 'Что считается пересечением и почему его нельзя скрывать.', 'Что считается пересечением и почему его нельзя скрывать.', 2, 20, 80, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO modules (`id`, `course_id`, `title`, `description`, `summary`, `sort_order`, `estimated_minutes`, `pass_score`, `is_published`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhe400kdirhggz35txua', 'cmmq0rh4w007airhgnxlfwibv', 'Делегирование, передача сделок и причины отказа', 'Как сохранять качество при отпуске, больничном и спорных переходах.', 'Как сохранять качество при отпуске, больничном и спорных переходах.', 3, 20, 80, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh5v009lirhgj3w89ybi', 'cmmq0rh5t009jirhgggqhfrkl', 'Принятие клиента после консультации', 'prinyatie-klienta-posle-peredachi', 'Как подхватить квалифицированного клиента и не потерять контекст.', 'Как подхватить квалифицированного клиента и не потерять контекст.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh5y009qirhg6cns25cv', 'cmmq0rh5t009jirhgggqhfrkl', 'Проверка модуля: Принятие клиента после консультации', 'prinyatie-klienta-posle-peredachi-quiz', 'Мини-тест по модулю «Принятие клиента после консультации».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh5s009birhgxrg9mhsk', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6700a8irhgd2uu8exz', 'cmmq0rh6600a6irhgfznreogh', 'Как устроен СтройТех', 'kak-ustroen-strojteh', 'Роли, кабинеты и маршрут обучения.', 'Роли, кабинеты и маршрут обучения.', 1, 'MIXED', 10, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6900adirhgukyvjdr9', 'cmmq0rh6600a6irhgfznreogh', 'Проверка модуля: Как устроен СтройТех', 'kak-ustroen-strojteh-quiz', 'Мини-тест по модулю «Как устроен СтройТех».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh6400a0irhgnohr1g44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6c00amirhg8ngntu43', 'cmmq0rh6b00akirhgddy0euz0', 'Статусы и итоговое решение', 'statusy-i-itogovoe-reshenie', 'Как читаются статусы и что происходит после финального теста.', 'Как читаются статусы и что происходит после финального теста.', 1, 'MIXED', 12, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6e00arirhgwavbt8i6', 'cmmq0rh6b00akirhgddy0euz0', 'Проверка модуля: Статусы и итоговое решение', 'statusy-i-itogovoe-reshenie-quiz', 'Мини-тест по модулю «Статусы и итоговое решение».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh6a00aeirhglkydgepl', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6o00bcirhgdpyisove', 'cmmq0rh6n00bairhgpxyyt15q', 'Лид и первичная квалификация', 'lid-i-pervichnaya-kvalifikatsiya', 'Старт работы с новым клиентом и первая логика оценки лида.', 'Старт работы с новым клиентом и первая логика оценки лида.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6q00bhirhgmga6tia7', 'cmmq0rh6n00bairhgpxyyt15q', 'Проверка модуля: Лид и первичная квалификация', 'lid-i-pervichnaya-kvalifikatsiya-quiz', 'Мини-тест по модулю «Лид и первичная квалификация».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh6l00b2irhg26fygdly', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6u00bsirhg12fa6ppv', 'cmmq0rh6t00bqirhgpr18dzj7', 'Не отвечает и отложенный спрос', 'ne-otvechaet-i-otlozhennyj-spros', 'Повторные касания, разумные сроки задач и корректное ведение клиента.', 'Повторные касания, разумные сроки задач и корректное ведение клиента.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6y00bzirhgj3fp6z96', 'cmmq0rh63009zirhgpcyn9y02', 'Онлайн-консультации, встречи и показы', 'onlajn-konsultatsii-i-vstrechi', 'Логика полноценных консультаций и контроль их результата.', 'Логика полноценных консультаций и контроль их результата.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7000c4irhgakifz9kc', 'cmmq0rh63009zirhgpcyn9y02', 'Проверка модуля: Онлайн-консультации, встречи и показы', 'onlajn-konsultatsii-i-vstrechi-quiz', 'Мини-тест по модулю «Онлайн-консультации, встречи и показы».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh60009rirhg3l4q41c5', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7400cfirhg59u6ev9w', 'cmmq0rh7300cdirhg9gyqacfr', 'Принятие решения и бронирование', 'prinyatie-resheniya-i-bron', 'Как вести сделку после консультации и переводить в бронь без потери логики.', 'Как вести сделку после консультации и переводить в бронь без потери логики.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7500ckirhg93ydcom9', 'cmmq0rh7300cdirhg9gyqacfr', 'Проверка модуля: Принятие решения и бронирование', 'prinyatie-resheniya-i-bron-quiz', 'Мини-тест по модулю «Принятие решения и бронирование».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh7100c5irhgtw77m3dp', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7800coirhgfefwp0p2', 'cmmq0rh7600cmirhgrmptcrxx', 'Заключение договора и успешная реализация', 'zaklyuchenie-dogovora-i-realizatsiya', 'Договор, проверка пакета документов и перевод сделки в успешную реализацию.', 'Договор, проверка пакета документов и перевод сделки в успешную реализацию.', 1, 'MIXED', 12, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh6x00bxirhgvzcgymz1', 'cmmq0rh6t00bqirhgpr18dzj7', 'Проверка модуля: Не отвечает и отложенный спрос', 'ne-otvechaet-i-otlozhennyj-spros-quiz', 'Мини-тест по модулю «Не отвечает и отложенный спрос».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh6r00biirhgpmjvyesv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7h00d1irhg7t4p8i6g', 'cmmq0rh7g00czirhga4fnqf0u', 'Выявление потребностей и горячий клиент', 'vyyavlenie-potrebnostej-i-goryachij-klient', 'Сбор параметров клиента и перевод к консультации.', 'Сбор параметров клиента и перевод к консультации.', 1, 'MIXED', 22, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7r00d6irhgcyw2r2h9', 'cmmq0rh7g00czirhga4fnqf0u', 'Проверка модуля: Выявление потребностей и горячий клиент', 'vyyavlenie-potrebnostej-i-goryachij-klient-quiz', 'Мини-тест по модулю «Выявление потребностей и горячий клиент».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh7e00crirhg6fuh1l6u', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7w00dairhg6kuvdulm', 'cmmq0rh7u00d8irhg2b9gbokz', 'Первичная консультация назначена', 'pervichnaya-konsultatsiya-naznachena', 'Подготовка сделки к консультации и контроль полноты данных перед передачей в ОП.', 'Подготовка сделки к консультации и контроль полноты данных перед передачей в ОП.', 1, 'MIXED', 10, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh7z00dgirhglwkv1seb', 'cmmq0rh7y00deirhgvxvei2rb', 'Передача в ОП и качество фиксации', 'peredacha-v-op', 'Какие данные обязательны при передаче сделки менеджеру ОП и как не потерять контекст клиента.', 'Какие данные обязательны при передаче сделки менеджеру ОП и как не потерять контекст клиента.', 1, 'MIXED', 10, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh8t00dmirhghc0ty91n', 'cmmq0rh8r00dkirhgo0zaabse', 'Галерея объектов и подбор', 'galereya-obektov-i-podbor', 'Как использовать подбор по параметрам без потери клиентского контекста.', 'Как использовать подбор по параметрам без потери клиентского контекста.', 1, 'MIXED', 16, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh8w00dsirhgcgu3ikg6', 'cmmq0rh8v00dqirhgfkltpya2', 'Коммерческое предложение и бронь', 'kommercheskoe-predlozhenie-i-bron', 'Как работать с предложением и переводить клиента в бронь.', 'Как работать с предложением и переводить клиента в бронь.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9000e5irhgjj8tmfgb', 'cmmq0rh8z00e3irhg82qcwaow', 'Синхронизация с amoCRM и риски', 'sinhronizatsiya-s-amocrm-i-riski', 'Где чаще всего происходят ошибки между Allio и CRM.', 'Где чаще всего происходят ошибки между Allio и CRM.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9300eairhghrc8n31s', 'cmmq0rh8z00e3irhg82qcwaow', 'Проверка модуля: Синхронизация с amoCRM и риски', 'sinhronizatsiya-s-amocrm-i-riski-quiz', 'Мини-тест по модулю «Синхронизация с amoCRM и риски».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh8y00dvirhg1m4fju5k', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9s00exirhg4buxurda', 'cmmq0rh9q00evirhgh4icrtdw', 'Рабочий стол и логика интерфейса', 'rabochij-stol-i-logika-interfejsa', 'Навигация, виджеты и фильтры.', 'Навигация, виджеты и фильтры.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9u00f2irhguwp5rqy4', 'cmmq0rh9q00evirhgh4icrtdw', 'Проверка модуля: Рабочий стол и логика интерфейса', 'rabochij-stol-i-logika-interfejsa-quiz', 'Мини-тест по модулю «Рабочий стол и логика интерфейса».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh9o00enirhgvs72xcg4', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh9y00fdirhgp57ffgwi', 'cmmq0rh9x00fbirhg6ogxpvvc', 'Сделки, контакты и задачи', 'sdelki-kontakty-i-zadachi', 'Главный принцип ежедневной работы через задачи.', 'Главный принцип ежедневной работы через задачи.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rha200fjirhg5panakde', 'cmmq0rh9x00fbirhg6ogxpvvc', 'Проверка модуля: Сделки, контакты и задачи', 'sdelki-kontakty-i-zadachi-quiz', 'Мини-тест по модулю «Сделки, контакты и задачи».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rh9w00f3irhg9wzttzhd', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rha700fuirhg7m7jynt7', 'cmmq0rha600fsirhg422jvah2', 'Создание сделки и проверка дублей', 'sozdanie-sdelki-i-proverka-dublej', 'Проверка номера, дублей и пересечений перед созданием.', 'Проверка номера, дублей и пересечений перед созданием.', 1, 'MIXED', 22, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rha900fzirhged9eeo3t', 'cmmq0rha600fsirhg422jvah2', 'Проверка модуля: Создание сделки и проверка дублей', 'sozdanie-sdelki-i-proverka-dublej-quiz', 'Мини-тест по модулю «Создание сделки и проверка дублей».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rha400fkirhge4xb0b4x', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhad00gairhgxp5swvdj', 'cmmq0rhab00g8irhgrg55e86p', 'Фиксация коммуникаций и комментарии', 'fiksatsiya-kommunikatsij-i-kommentarii', 'Подтверждение звонков, переписок и офлайн-консультаций.', 'Подтверждение звонков, переписок и офлайн-консультаций.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhaf00gfirhgayi98fse', 'cmmq0rhab00g8irhgrg55e86p', 'Проверка модуля: Фиксация коммуникаций и комментарии', 'fiksatsiya-kommunikatsij-i-kommentarii-quiz', 'Мини-тест по модулю «Фиксация коммуникаций и комментарии».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhaa00g0irhgvy14yxks', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhal00gqirhgzspuocv4', 'cmmq0rhai00goirhg9mb67drv', 'Этапы воронки и корректные переводы', 'etapy-voronki-i-korrektnye-perevody', 'Этапы отражают реальный прогресс, а не удобство менеджера.', 'Этапы отражают реальный прогресс, а не удобство менеджера.', 1, 'MIXED', 22, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhan00gvirhgm318dfxx', 'cmmq0rhai00goirhg9mb67drv', 'Проверка модуля: Этапы воронки и корректные переводы', 'etapy-voronki-i-korrektnye-perevody-quiz', 'Мини-тест по модулю «Этапы воронки и корректные переводы».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhah00ggirhg7mbj3v7k', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhas00h6irhgchhe2vxs', 'cmmq0rhar00h4irhgys8cju75', 'Причины отказа и корректное закрытие', 'prichiny-otkaza-i-korrektnoe-zakrytie', 'Как правильно выбирать причину отказа и закрывать сделку.', 'Как правильно выбирать причину отказа и закрывать сделку.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhau00hbirhgayzpmksb', 'cmmq0rhar00h4irhgys8cju75', 'Проверка модуля: Причины отказа и корректное закрытие', 'prichiny-otkaza-i-korrektnoe-zakrytie-quiz', 'Мини-тест по модулю «Причины отказа и корректное закрытие».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhap00gwirhg1bepww7j', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhay00hmirhgufb3yvmn', 'cmmq0rhaw00hkirhgzwy531zq', 'Антифрод, качество и критичные ошибки', 'antifrod-kachestvo-i-kritichnye-oshibki', 'Нарушения, которые могут привести к изъятию сделки.', 'Нарушения, которые могут привести к изъятию сделки.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhb100hsirhgnshj2dg3', 'cmmq0rhaw00hkirhgzwy531zq', 'Проверка модуля: Антифрод, качество и критичные ошибки', 'antifrod-kachestvo-i-kritichnye-oshibki-quiz', 'Мини-тест по модулю «Антифрод, качество и критичные ошибки».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhav00hcirhgdey79qsv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhb700i3irhg0so8v7vy', 'cmmq0rhb500i1irhg8jsplhxr', 'Allio, бронирование и синхронизация', 'allio-bronirovanie-i-sinhronizatsiya', 'Как работать с бронью и не допускать неверных переводов между системами.', 'Как работать с бронью и не допускать неверных переводов между системами.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhb900i9irhg480rxbn4', 'cmmq0rhb500i1irhg8jsplhxr', 'Проверка модуля: Allio, бронирование и синхронизация', 'allio-bronirovanie-i-sinhronizatsiya-quiz', 'Мини-тест по модулю «Allio, бронирование и синхронизация».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhb300htirhgnd4teoa4', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcd00irirhgc7g3r0rx', 'cmmq0rhcc00ipirhgum0oj68x', 'Структура партнерской сделки', 'struktura-partnerskoj-sdelki', 'Клиент, агент и компания агентства как обязательные сущности.', 'Клиент, агент и компания агентства как обязательные сущности.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhch00iwirhgyk8w5jiv', 'cmmq0rhcc00ipirhgum0oj68x', 'Проверка модуля: Структура партнерской сделки', 'struktura-partnerskoj-sdelki-quiz', 'Мини-тест по модулю «Структура партнерской сделки».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhca00ihirhg11f5wxsk', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcm00j7irhgh3z62u9e', 'cmmq0rhcl00j5irhgd6946q48', 'Уникальность, фиксация и пересечения', 'unikalnost-fiksatsiya-i-peresecheniya', 'Проверка клиента, агента и сроков фиксации перед началом работы.', 'Проверка клиента, агента и сроков фиксации перед началом работы.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhco00jcirhgrudda1nl', 'cmmq0rhcl00j5irhgd6946q48', 'Проверка модуля: Уникальность, фиксация и пересечения', 'unikalnost-fiksatsiya-i-peresecheniya-quiz', 'Мини-тест по модулю «Уникальность, фиксация и пересечения».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhcj00ixirhgut6ghsvv', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcs00jnirhgwcpvimar', 'cmmq0rhcr00jlirhgwr6k4tm4', 'Коммуникация с агентом, встречи и решения', 'kommunikatsiya-s-agentom-vstrechi-i-resheniya', 'Особые правила общения с агентом и контроль шагов до брони.', 'Особые правила общения с агентом и контроль шагов до брони.', 1, 'MIXED', 24, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcu00jsirhg9a53m58p', 'cmmq0rhcr00jlirhgwr6k4tm4', 'Проверка модуля: Коммуникация с агентом, встречи и решения', 'kommunikatsiya-s-agentom-vstrechi-i-resheniya-quiz', 'Мини-тест по модулю «Коммуникация с агентом, встречи и решения».', 'Проверка понимания ключевых правил модуля.', 2, 'QUIZ', 8, 1, 'cmmq0rhcq00jdirhg80m7uzvn', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhcy00jwirhghpz7gv8l', 'cmmq0rhcw00juirhgzbp8uaeb', 'Бронирование и договор', 'bronirovanie-i-dogovor-partnery', 'Бронь в Allio, фиксация клиента за агентом и переход к договору без конфликтов и потери статуса.', 'Бронь в Allio, фиксация клиента за агентом и переход к договору без конфликтов и потери статуса.', 1, 'MIXED', 12, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhdy00k2irhgg3l7xijx', 'cmmq0rhdw00k0irhgnuz0etkv', 'Сделка без задачи и просроченные действия', 'sdelka-bez-zadachi-i-prosrochki', 'Почему отсутствие задачи и длительная просрочка — красные флаги качества.', 'Почему отсутствие задачи и длительная просрочка — красные флаги качества.', 1, 'MIXED', 18, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhe200k9irhghazyak8s', 'cmmq0rhe100k7irhgtw0wbjmx', 'Дубли, пересечения и параллельное общение', 'dublis-peresecheniya-i-parallelnoe-obschenie', 'Что считается пересечением и почему его нельзя скрывать.', 'Что считается пересечением и почему его нельзя скрывать.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lessons (`id`, `module_id`, `title`, `slug`, `description`, `summary`, `sort_order`, `lesson_type`, `estimated_minutes`, `is_required`, `quiz_id`, `created_at`, `updated_at`) VALUES ('cmmq0rhe500kfirhg7mut1h49', 'cmmq0rhe400kdirhggz35txua', 'Делегирование, передача сделок и причины отказа', 'delegirovanie-peredacha-sdelok-i-prichiny-otkaza', 'Как сохранять качество при отпуске, больничном и спорных переходах.', 'Как сохранять качество при отпуске, больничном и спорных переходах.', 1, 'MIXED', 20, 1, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh5v009mirhgqdvgmwpo', 'cmmq0rh5v009lirhgj3w89ybi', 'RICH_TEXT', 'Основной материал', 'После передачи из КЦ менеджер ОП обязан быстро проверить качество карточки: есть ли подтвержденная коммуникация, понятна ли потребность, назначена ли консультация или нужно уточнить следующий шаг. В этапе «Передано в ОП» сделки не должны зависать до конца дня.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh5v009nirhga4xyao5p', 'cmmq0rh5v009lirhgj3w89ybi', 'RULES', 'Правила модуля', '- Проверить комментарии, задачу и последнюю коммуникацию.
- Не держать сделку в буферном этапе до конца дня.
- Сразу поставить следующую задачу на сделке.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh5v009oirhgvzuum6ml', 'cmmq0rh5v009lirhgj3w89ybi', 'MISTAKES', 'Типичные ошибки', '- Оставить сделку в «Передано в ОП» до завтра.
- Продолжать работу без чтения комментария от КЦ.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6700a9irhg1k8u2g1d', 'cmmq0rh6700a8irhgd2uu8exz', 'RICH_TEXT', 'Основной материал', 'СтройТех собирает курсы, видео, тесты и управленческие решения в одном интерфейсе. Ученик видит только свои курсы, руководитель контролирует результаты команды, администратор управляет структурой и контентом без участия разработчика.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6700aairhgoxrz8mbs', 'cmmq0rh6700a8irhgd2uu8exz', 'RULES', 'Правила модуля', '- Ученик работает только со своими курсами и прогрессом.
- Руководитель видит только свою команду.
- Администратор управляет курсами, медиа и назначениями.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6700abirhgqjs1km50', 'cmmq0rh6700a8irhgd2uu8exz', 'MISTAKES', 'Типичные ошибки', '- Считать, что доступ выдается автоматически после теста.
- Игнорировать комментарии руководителя.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6c00anirhgaaq4etzz', 'cmmq0rh6c00amirhg8ngntu43', 'RICH_TEXT', 'Основной материал', 'После завершения курса сотрудник либо получает статус неуспешного теста, либо отправляется руководителю на рассмотрение. Финальное решение руководителя определяет, что произойдет дальше: запрос доступов, повторное обучение или дополнительная подготовка.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6c00aoirhgjbzvkosx', 'cmmq0rh6c00amirhg8ngntu43', 'RULES', 'Правила модуля', '- Модульный тест проверяет модуль, финальный тест — курс целиком.
- Решение руководителя ставится после результата обучения.
- Статус курса — это сигнал следующего управленческого шага.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6c00apirhg8ns7ezoi', 'cmmq0rh6c00amirhg8ngntu43', 'MISTAKES', 'Типичные ошибки', '- Игнорировать статус «Тест не сдан».
- Не смотреть на решение руководителя.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6o00bdirhgel9qqa15', 'cmmq0rh6o00bcirhgdpyisove', 'RICH_TEXT', 'Основной материал', 'Этап «Лид» предназначен для новых обращений. Здесь оператор определяет, целевой ли клиент, удается ли установить контакт и какой следующий шаг реалистичен: повторный звонок, выявление потребностей или назначение консультации.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6o00beirhg3jvgwx21', 'cmmq0rh6o00bcirhgdpyisove', 'RULES', 'Правила модуля', '- Новый лид быстро берется в работу.
- После разговора нужен комментарий и следующая задача.
- Успешно квалифицированный клиент не должен зависать без движения.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6o00bfirhgs9wf81q3', 'cmmq0rh6o00bcirhgdpyisove', 'MISTAKES', 'Типичные ошибки', '- Оставить новый лид без задачи.
- Не зафиксировать потребность после разговора.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6u00btirhgiql0jx88', 'cmmq0rh6u00bsirhg12fa6ppv', 'RICH_TEXT', 'Основной материал', 'Если клиент не отвечает, сделка уходит в сценарий повторных касаний. Если клиент прямо говорит, что вернется к покупке через несколько месяцев, это уже «Отложенный спрос». В обоих случаях задача ставится на конкретную дату и цель контакта.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6v00buirhgrw7ef2nc', 'cmmq0rh6u00bsirhg12fa6ppv', 'RULES', 'Правила модуля', '- Неответ требует повторных попыток связи.
- Отложенный спрос фиксируется только при честно обозначенном горизонте.
- Даже длинный горизонт не отменяет регулярную коммуникацию.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6v00bvirhg2q96klww', 'cmmq0rh6u00bsirhg12fa6ppv', 'MISTAKES', 'Типичные ошибки', '- Закрыть клиента после одного неответа.
- Ставить задачу без времени.
- Путать отложенный спрос с забытым лидом.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6y00c0irhgplmqmcb2', 'cmmq0rh6y00bzirhgj3fp6z96', 'RICH_TEXT', 'Основной материал', 'Дата консультации — это не любой разговор, а фактическая консультация в офисе продаж или полноценная онлайн-консультация для удаленного клиента. После консультации менеджер фиксирует результат, обновляет поля сделки и ставит следующую задачу.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6y00c1irhg2fqn8l1b', 'cmmq0rh6y00bzirhgj3fp6z96', 'RULES', 'Правила модуля', '- Консультация — это отдельное подтвержденное действие.
- Онлайн-консультация — не просто короткий звонок.
- После встречи нужен комментарий, результат и следующая задача.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh6y00c2irhgwo2qv043', 'cmmq0rh6y00bzirhgj3fp6z96', 'MISTAKES', 'Типичные ошибки', '- Считать любой звонок консультацией.
- Не фиксировать итоги встречи.
- Оставить клиента без следующего шага после показа.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7400cgirhgzzafmnzi', 'cmmq0rh7400cfirhg59u6ev9w', 'RICH_TEXT', 'Основной материал', 'После консультации клиент может взять время на обдумывание, сравнение вариантов, сбор денег или ожидание ипотечного решения. Задача менеджера — зафиксировать причину паузы, следующий контакт и критерии, при которых клиент готов двигаться дальше. В бронь переводят только после реального выбора объекта.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7400chirhghw2j5hh7', 'cmmq0rh7400cfirhg59u6ev9w', 'RULES', 'Правила модуля', '- Причина паузы должна быть зафиксирована.
- Следующая задача ставится в адекватный срок.
- В бронь переводят только после выбора объекта.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7400ciirhgose6c7tf', 'cmmq0rh7400cfirhg59u6ev9w', 'MISTAKES', 'Типичные ошибки', '- Перевести в бронь без фактического выбора объекта.
- Оставить решение клиента без следующего контакта.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7800cpirhgczou1sbj', 'cmmq0rh7800coirhgfefwp0p2', 'RICH_TEXT', 'Основной материал', 'Перед переводом сделки в договор менеджер ЮСИ проверяет комплект документов клиента, статус брони, условия оплаты и все обязательные поля сделки. После подписания договора важно зафиксировать юридические услуги, обновить этап в amoCRM и оставить понятный комментарий по следующему шагу, чтобы сделка дошла до статуса «Успешно реализовано» без разрыва в истории.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7800cqirhggbrwe6r0', 'cmmq0rh7800coirhgfefwp0p2', 'RULES', 'Правила модуля', '- Модуль оставлен как качественная каркасная заготовка.
- Структура курса уже показывает масштабируемость редактора.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7h00d2irhg5bksih52', 'cmmq0rh7h00d1irhg7t4p8i6g', 'RICH_TEXT', 'Основной материал', 'Этап «Выявление потребностей» нужен, чтобы собрать цель обращения и базовые параметры объекта. «Горячий клиент» используется, когда интерес подтвержден, но клиент пока не готов к встрече. В обоих случаях оператор ставит понятную задачу и не теряет клиента из поля зрения.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7h00d3irhgrkpbxsf9', 'cmmq0rh7h00d1irhg7t4p8i6g', 'RULES', 'Правила модуля', '- Фиксируются параметры потребности клиента.
- Горячий клиент — это интерес есть, но встреча еще не назначена.
- Следующий контакт должен быть понятен по дате и цели.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7h00d4irhgpjwrqtnh', 'cmmq0rh7h00d1irhg7t4p8i6g', 'MISTAKES', 'Типичные ошибки', '- Не фиксировать параметры потребности.
- Оставить горячего клиента без плана.
- Путать горячего клиента с назначенной консультацией.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7w00dbirhggnanflar', 'cmmq0rh7w00dairhg6kuvdulm', 'RICH_TEXT', 'Основной материал', 'Перед переводом в этап «Первичная консультация назначена» оператор ЮСИ фиксирует дату и канал консультации, актуализирует телефон и источник обращения, а также оставляет комментарий с контекстом потребности клиента. Менеджер ОП должен открыть сделку и сразу понимать, что уже выяснено, по какому объекту есть интерес и какое действие ожидается после консультации.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7w00dcirhgcp5p0fe3', 'cmmq0rh7w00dairhg6kuvdulm', 'RULES', 'Правила модуля', '- В сделке должна быть назначенная консультация с датой и временем.
- В комментарии фиксируются потребность клиента, объект и важные договоренности.
- Передача в ОП делается только после проверки полноты контактов и следующего шага.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7z00dhirhgkcx1c03s', 'cmmq0rh7z00dgirhglwkv1seb', 'RICH_TEXT', 'Основной материал', 'Передача в ОП считается качественной, если в сделке есть подтвержденная консультация, понятный комментарий по потребности клиента, актуальные контакты и следующая задача. Нельзя передавать лида «пустым»: менеджер ОП должен видеть, что уже выяснил оператор, к какому объекту или сценарию проявлен интерес и когда требуется следующий контакт.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh7z00diirhgw6zy245s', 'cmmq0rh7z00dgirhglwkv1seb', 'RULES', 'Правила модуля', '- Передача оформляется только с полным комментарием и актуальными данными клиента.
- Следующая задача ставится на сделке, а не на контакте.
- Контекст по клиенту должен быть понятен менеджеру ОП без дополнительных уточнений.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh8t00dnirhgcvwgwcnj', 'cmmq0rh8t00dmirhghc0ty91n', 'RICH_TEXT', 'Основной материал', 'Подбор в Allio строится на уже выявленной потребности: комнатность, ЖК, этаж, бюджет, способ оплаты, срок сделки. Чем точнее параметры в CRM, тем меньше шум в подборке и тем выше шанс, что клиент дойдет до брони.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh8t00doirhgegnq02kw', 'cmmq0rh8t00dmirhghc0ty91n', 'RULES', 'Правила модуля', '- Сначала фиксируется потребность клиента.
- Подбор строится по параметрам, а не по случайным объектам.
- После отправки вариантов нужна задача на обратную связь.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh8w00dtirhgelkkygsh', 'cmmq0rh8w00dsirhgcgu3ikg6', 'RICH_TEXT', 'Основной материал', 'Отправка коммерческого предложения помогает клиенту принять решение, но сама по себе не означает бронирование. Бронь появляется только тогда, когда клиент выбрал объект и менеджер зафиксировал это действие в Allio с актуальным сроком.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh8w00duirhg31fvge47', 'cmmq0rh8w00dsirhgcgu3ikg6', 'RULES', 'Правила модуля', '- КП помогает клиенту сравнить и выбрать.
- Бронь ставится только после фактического выбора объекта.
- После КП нужна задача на обратную связь.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9000e6irhgnkkufhnt', 'cmmq0rh9000e5irhgjj8tmfgb', 'RICH_TEXT', 'Основной материал', 'Проблемы возникают в трех местах: бронь в Allio истекла, а в CRM сделка осталась на броне; бронь снята, но клиентская пауза не отражена в следующем этапе; менеджер не обновил дату окончания или исполнителя. Поэтому любая бронь — это проверка данных и комментария в обоих сервисах.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9000e7irhgo1dyo8jf', 'cmmq0rh9000e5irhgjj8tmfgb', 'RULES', 'Правила модуля', '- Проверять соответствие статуса между Allio и amoCRM.
- Контролировать сроки окончания брони.
- Не переводить сделку на новый этап без фактического основания.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9t00eyirhgll6sl505', 'cmmq0rh9s00exirhg4buxurda', 'RICH_TEXT', 'Основной материал', 'В примере обучения рабочий стол показывает, как менеджер собирает персональный дашборд из нужных виджетов. Виджеты по просроченным задачам, воронкам и собственным сделкам помогают не искать риски вручную и видеть проблемные зоны до того, как клиент выпадет из процесса.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9t00ezirhgj84rb5ao', 'cmmq0rh9s00exirhg4buxurda', 'RULES', 'Правила модуля', '- Виджеты создаются из фильтров по сделкам и задачам.
- Рабочий стол нужен для быстрых управленческих срезов.
- Фильтр можно сохранить как виджет и не собирать заново.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9t00f0irhgy3ckyhv0', 'cmmq0rh9s00exirhg4buxurda', 'MISTAKES', 'Типичные ошибки', '- Работать только из общего списка сделок.
- Не отслеживать просроченные задачи.
- Путать рабочий стол с местом ручного ведения сделки.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9y00feirhgzzde8k1b', 'cmmq0rh9y00fdirhgp57ffgwi', 'RICH_TEXT', 'Основной материал', 'Регламент прямо говорит: основная работа менеджера ведется из сущности «Задачи». Активная сделка без задачи означает отсутствие следующего шага. Контакт хранит данные о человеке, но вся управляемая работа должна идти через карточку сделки: комментарии, задачи, статус и история движения.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9y00ffirhgtqxttorn', 'cmmq0rh9y00fdirhgp57ffgwi', 'RULES', 'Правила модуля', '- На каждой активной сделке должна быть задача.
- Задача ставится только на сделку.
- Задача имеет конкретную дату и время.
- Общий контекст сделки пишется в комментариях, а не в тексте задачи.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rh9y00fgirhg6jrcjczv', 'cmmq0rh9y00fdirhgp57ffgwi', 'MISTAKES', 'Типичные ошибки', '- Ставить задачу на контакт.
- Оставлять сделку без следующего шага.
- Выполнять задачу без комментария.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rha700fvirhgbf759jnm', 'cmmq0rha700fuirhg7m7jynt7', 'RICH_TEXT', 'Основной материал', 'Перед ручным созданием контакта или сделки менеджер обязан проверить клиента в amoCRM по номеру телефона. Если активная сделка уже существует, новая закрывается как дубль, а при пересечении менеджеры обязаны уведомить друг друга. Игнорирование подсказок системы и скрытие пересечений — уже антифрод-риск.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rha700fwirhg1rwn35fh', 'cmmq0rha700fuirhg7m7jynt7', 'RULES', 'Правила модуля', '- Проверка телефона выполняется до создания сделки.
- При найденной активной сделке новая закрывается как дубль.
- О пересечении нужно сообщить сразу.
- Дубль по контакту уходит в техподдержку на объединение.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rha700fxirhgroqqbxg3', 'cmmq0rha700fuirhg7m7jynt7', 'MISTAKES', 'Типичные ошибки', '- Создать сделку, а потом проверять номер.
- Игнорировать предупреждение о существующем контакте.
- Скрывать пересечение.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhad00gbirhg3iqw00cg', 'cmmq0rhad00gairhgxp5swvdj', 'RICH_TEXT', 'Основной материал', 'Изменений в сделке не должно быть без подтвержденной коммуникации. Для звонка это запись разговора, для переписки — скрин WhatsApp, для встречи — офлайн-примечание. Менеджер обязан не просто закрыть задачу, а зафиксировать, что произошло, к чему договорились и какой следующий шаг поставлен.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhad00gcirhg29eg6omo', 'cmmq0rhad00gairhgxp5swvdj', 'RULES', 'Правила модуля', '- После звонка нужен комментарий и подтверждение.
- После WhatsApp нужен комментарий и скрин.
- После офлайн-встречи — понятное примечание.
- Любое изменение статуса опирается на подтвержденное действие.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhad00gdirhg7s8gfpxq', 'cmmq0rhad00gairhgxp5swvdj', 'MISTAKES', 'Типичные ошибки', '- Закрыть задачу без итога.
- Перевести сделку без подтверждения коммуникации.
- Откладывать фиксацию на потом.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhal00grirhgq6vl57so', 'cmmq0rhal00gqirhgzspuocv4', 'RICH_TEXT', 'Основной материал', 'Антифрод считает нарушением ситуацию, когда сделка находится в этапе, не соответствующем реальному прогрессу продажи. Этап нужен для управленческого контроля и следующего действия. Возврат назад по воронке ограничен и допустим только в специальных регламентных случаях.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhal00gsirhgkmmyl2n6', 'cmmq0rhal00gqirhgzspuocv4', 'RULES', 'Правила модуля', '- Этап должен соответствовать фактическому состоянию сделки.
- Перевод на новый этап опирается на подтвержденную коммуникацию.
- Возврат назад по воронке ограничен.
- Ответственный сотрудник меняется по этапам согласно регламенту.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhal00gtirhgye8z36ad', 'cmmq0rhal00gqirhgzspuocv4', 'MISTAKES', 'Типичные ошибки', '- Двигать сделку вперед для красоты отчета.
- Возвращать сделку назад без основания.
- Оставлять сделку на старом этапе после новой встречи.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhas00h7irhguqtrpvuz', 'cmmq0rhas00h6irhgchhe2vxs', 'RICH_TEXT', 'Основной материал', 'Закрытая сделка должна быть отмечена корректной причиной отказа, соответствующей реальному сценарию. Это влияет на отчетность, контроль качества и повторы коммуникации. Перед переводом в «Успешно реализовано» обязательно проверяются поля сделки и контакта.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhas00h8irhgv73oxs6a', 'cmmq0rhas00h6irhgchhe2vxs', 'RULES', 'Правила модуля', '- Причина отказа должна соответствовать факту.
- Дубль закрывается как дубль.
- Перед успехом проверяются поля сделки и контакта.
- Нецелевые причины не подменяют целевые без основания.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhas00h9irhg86fzlx0p', 'cmmq0rhas00h6irhgchhe2vxs', 'MISTAKES', 'Типичные ошибки', '- Ставить формальную причину ради скорости.
- Закрывать без проверки данных.
- Оставлять сделку без причины отказа.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhay00hnirhgq30ql0n1', 'cmmq0rhay00hmirhgufb3yvmn', 'RICH_TEXT', 'Основной материал', 'К антифрод-рискам относятся: активная сделка без задачи более двух суток, просроченная задача более пяти дней, отсутствие коммуникации без объективной причины, ручные дубли без проверки и скрытые пересечения. Если сотрудник сомневается в праве забрать сделку, он должен согласовать это с руководителем.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhay00hoirhg3hwb76l6', 'cmmq0rhay00hmirhgufb3yvmn', 'RULES', 'Правила модуля', '- Сделка без задачи более 2 суток — нарушение.
- Просрочка более 5 дней — нарушение.
- Скрытие пересечения — умышленное нарушение.
- Неправомерная смена ответственного подлежит откату.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhay00hpirhgnrruxdc7', 'cmmq0rhay00hmirhgufb3yvmn', 'MISTAKES', 'Типичные ошибки', '- Оставить сделку без следующего шага.
- Поставить задачу на неадекватно дальний срок.
- Забрать сделку без обоснования.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhb700i4irhgv7fo5ahu', 'cmmq0rhb700i3irhg0so8v7vy', 'RICH_TEXT', 'Основной материал', 'Бронирование в Allio влияет на состояние сделки в CRM. Если дата окончания брони просрочена, исполнитель не указан или бронь снята без отражения в amoCRM, сделка легко уходит в некорректный этап. Любая бронь требует проверки объекта, срока и ответственного.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhb700i5irhgxdsj3rdt', 'cmmq0rhb700i3irhg0so8v7vy', 'RULES', 'Правила модуля', '- В броне указан объект.
- Заполнена дата окончания брони.
- Указан сотрудник, поставивший бронь.
- Просроченная бронь не должна оставаться без решения.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhb700i6irhgog56z51s', 'cmmq0rhb700i3irhg0so8v7vy', 'MISTAKES', 'Типичные ошибки', '- Оставить просроченную бронь в воронке.
- Не обновить дату повторной брони.
- Не синхронизировать отмену брони с CRM.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcd00isirhgrud8eapp', 'cmmq0rhcd00irirhgc7g3r0rx', 'RICH_TEXT', 'Основной материал', 'В партнерском отделе в сделке должны быть корректно связаны минимум два контакта: клиент и агент. Если работа идет через агентство, дополнительно создается или привязывается компания агентства. Такая структура позволяет отслеживать принадлежность клиента и видеть агентскую активность.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcd00itirhgywwad2sf', 'cmmq0rhcd00irirhgc7g3r0rx', 'RULES', 'Правила модуля', '- В сделке должен быть контакт клиента.
- В сделке должен быть контакт агента.
- При работе через агентство нужно привязать компанию агентства.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcd00iuirhg914i4u1f', 'cmmq0rhcd00irirhgc7g3r0rx', 'MISTAKES', 'Типичные ошибки', '- Вести партнерскую сделку только с контактом клиента.
- Не фиксировать агента отдельным контактом.
- Создавать дубли компаний агентств.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcm00j8irhg1v8j7m9i', 'cmmq0rhcm00j7irhgh3z62u9e', 'RICH_TEXT', 'Основной материал', 'В партнерском отделе менеджер проверяет не только клиента, но и агента, а также дополнительные номера. При активной фиксации за другим агентом или менеджером нужно не создавать вторую параллельную историю, а сразу поднять вопрос о пересечении.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcm00j9irhgyqug41af', 'cmmq0rhcm00j7irhgh3z62u9e', 'RULES', 'Правила модуля', '- Проверять нужно клиента и агента.
- Дополнительные номера тоже идут в проверку.
- При пересечении нужно уведомить вовлеченных участников.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcm00jairhgylznu0mb', 'cmmq0rhcm00j7irhgh3z62u9e', 'MISTAKES', 'Типичные ошибки', '- Проверить только клиента и забыть про агента.
- Создать новую сделку при активной фиксации.
- Скрыть пересечение до момента брони.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcs00joirhgvy0ddmsh', 'cmmq0rhcs00jnirhgwcpvimar', 'RICH_TEXT', 'Основной материал', 'Менеджер партнерского отдела ведет коммуникацию и с агентом, и с клиентом. Любой следующий шаг должен быть ясен обеим сторонам: назначена ли встреча, нужно ли агенту срочно связаться с клиентом, подтвердил ли клиент интерес. Если агент перестает отвечать, перед закрытием нужно выполнить установленное число попыток связи.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcs00jpirhgf4hlo8ij', 'cmmq0rhcs00jnirhgwcpvimar', 'RULES', 'Правила модуля', '- Следующая задача ставится на сделке.
- Итог разговора с агентом фиксируется в комментарии.
- Если агент не отвечает, выполняются минимум 3 попытки связи за 2 дня.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcs00jqirhg696ekipi', 'cmmq0rhcs00jnirhgwcpvimar', 'MISTAKES', 'Типичные ошибки', '- Работать только с клиентом, не фиксируя контакты с агентом.
- Закрыть сделку по неответу после одной попытки связи.', NULL, 3);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcy00jxirhgk6t7o0qk', 'cmmq0rhcy00jwirhghpz7gv8l', 'RICH_TEXT', 'Основной материал', 'В партнерской сделке бронирование подтверждает, что клиент и агент доведены до следующего этапа без конфликта по фиксации. Перед переводом в договор менеджер ЮСИ проверяет срок фиксации клиента за агентом, статус брони в Allio, корректность компании агентства и все договоренности, которые влияют на закрытие сделки. Любое изменение статуса синхронизируется с amoCRM и подтверждается комментариями по агенту и клиенту.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhcy00jyirhgdoengb6s', 'cmmq0rhcy00jwirhghpz7gv8l', 'RULES', 'Правила модуля', '- Перед бронью проверяются клиент, агент, срок фиксации и статус в Allio.
- Переход в договор делается только после подтвержденных договоренностей с агентом и клиентом.
- Изменения в партнерской сделке синхронизируются между Allio и amoCRM без задержки.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhdy00k3irhg1h7wof0z', 'cmmq0rhdy00k2irhgg3l7xijx', 'RICH_TEXT', 'Основной материал', 'Сделка без задачи больше двух суток уже попадает в зону нарушения. Просроченная задача более пяти дней — следующий красный флаг. Для руководителя это означает, что клиент выпал из управляемого процесса, а отчетность перестает отражать реальную работу.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhdy00k4irhghm99fwmk', 'cmmq0rhdy00k2irhgg3l7xijx', 'RULES', 'Правила модуля', '- Активная сделка без задачи более 2 суток — нарушение.
- Просрочка более 5 дней — нарушение.
- По каждой задаче должен быть виден итог и следующий шаг.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhe300kairhg1eqjwt24', 'cmmq0rhe200k9irhghazyak8s', 'RICH_TEXT', 'Основной материал', 'Пересечение — это сценарий, при котором один и тот же клиент параллельно общается с разными менеджерами или через агентство. Параллельное общение — близкий сценарий, когда с разными сотрудниками параллельно работают члены одной семьи. Оба случая требуют моментального уведомления коллег.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhe300kbirhg026xoudv', 'cmmq0rhe200k9irhghazyak8s', 'RULES', 'Правила модуля', '- О пересечении нужно сообщить сразу.
- Скрывать дубль или пересечение нельзя.
- Приоритет определяется по регламенту, а не по удобству менеджера.', NULL, 2);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhe500kgirhg1vrvide0', 'cmmq0rhe500kfirhg7mut1h49', 'RICH_TEXT', 'Основной материал', 'Если сотрудник уходит в отпуск или на больничный, он обязан согласовать замещающего и оставить понятный контекст по сделкам. При смене ответственного должно быть обоснование. Закрытие сделки тоже нельзя делать «вслепую»: причина отказа должна соответствовать реальности.', NULL, 1);

INSERT INTO lesson_blocks (`id`, `lesson_id`, `block_type`, `title`, `body`, `payload`, `sort_order`) VALUES ('cmmq0rhe500khirhgggrvqlox', 'cmmq0rhe500kfirhg7mut1h49', 'RULES', 'Правила модуля', '- Замещение согласуется и подтверждается.
- Смена ответственного сопровождается обоснованием.
- Причина отказа выбирается по факту, а не ради красоты отчета.', NULL, 2);

INSERT INTO media_assets (`id`, `kind`, `title`, `original_name`, `file_name`, `mime_type`, `size_bytes`, `duration_sec`, `width`, `height`, `storage_provider`, `storage_path`, `public_url`, `bucket`, `metadata_json`, `uploaded_by_id`, `course_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh2d000wirhgf79agm1q', 'DOCUMENT', 'Чек-лист сделки в amoCRM', 'amo-checklist.txt', 'amo-checklist.txt', 'text/plain', 486, NULL, NULL, NULL, 'LOCAL', '/demo/amo-checklist.txt', '/demo/amo-checklist.txt', NULL, NULL, 'cmmq0rh23000mirhgcq9pi09y', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO media_assets (`id`, `kind`, `title`, `original_name`, `file_name`, `mime_type`, `size_bytes`, `duration_sec`, `width`, `height`, `storage_provider`, `storage_path`, `public_url`, `bucket`, `metadata_json`, `uploaded_by_id`, `course_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh2e000zirhg4fg9jt7j', 'DOCUMENT', 'Памятка по синхронизации Allio', 'allio-sync-memo.txt', 'allio-sync-memo.txt', 'text/plain', 579, NULL, NULL, NULL, 'LOCAL', '/demo/allio-sync-memo.txt', '/demo/allio-sync-memo.txt', NULL, NULL, 'cmmq0rh23000mirhgcq9pi09y', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO media_assets (`id`, `kind`, `title`, `original_name`, `file_name`, `mime_type`, `size_bytes`, `duration_sec`, `width`, `height`, `storage_provider`, `storage_path`, `public_url`, `bucket`, `metadata_json`, `uploaded_by_id`, `course_id`, `created_at`, `updated_at`) VALUES ('cmmq0rh2e0010irhgbgqyjawy', 'DOCUMENT', 'Антифрод-памятка ЮСИ', 'antifraud-checklist.txt', 'antifraud-checklist.txt', 'text/plain', 562, NULL, NULL, NULL, 'LOCAL', '/demo/antifraud-checklist.txt', '/demo/antifraud-checklist.txt', NULL, NULL, 'cmmq0rh23000mirhgcq9pi09y', NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO lesson_attachments (`id`, `lesson_id`, `asset_id`, `label`, `sort_order`) VALUES ('cmmq0rh9200e8irhgof02wjqa', 'cmmq0rh9000e5irhgjj8tmfgb', 'cmmq0rh2e000zirhg4fg9jt7j', 'Памятка по синхронизации Allio', 1);

INSERT INTO lesson_attachments (`id`, `lesson_id`, `asset_id`, `label`, `sort_order`) VALUES ('cmmq0rha100fhirhggalm0p4d', 'cmmq0rh9y00fdirhgp57ffgwi', 'cmmq0rh2d000wirhgf79agm1q', 'Чек-лист сделки в amoCRM', 1);

INSERT INTO lesson_attachments (`id`, `lesson_id`, `asset_id`, `label`, `sort_order`) VALUES ('cmmq0rhaz00hqirhg4qvu3bo5', 'cmmq0rhay00hmirhgufb3yvmn', 'cmmq0rh2e0010irhgbgqyjawy', 'Антифрод-памятка ЮСИ', 1);

INSERT INTO lesson_attachments (`id`, `lesson_id`, `asset_id`, `label`, `sort_order`) VALUES ('cmmq0rhb800i7irhgsru2obdc', 'cmmq0rhb700i3irhg0so8v7vy', 'cmmq0rh2e000zirhg4fg9jt7j', 'Памятка по синхронизации Allio', 1);

INSERT INTO lesson_attachments (`id`, `lesson_id`, `asset_id`, `label`, `sort_order`) VALUES ('cmmq0rhe000k5irhgqrnu7hy6', 'cmmq0rhdy00k2irhgg3l7xijx', 'cmmq0rh2e0010irhgbgqyjawy', 'Антифрод-памятка ЮСИ', 1);

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh330011irhguei8majw', 'q_tasks_core', 'Из какого раздела ведется основная работа менеджера в amoCRM?', 'SINGLE', 'Регламент фиксирует работу из задач.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh360015irhgvi1veew9', 'q_active_task', 'На каждой активной сделке должна быть актуальная задача.', 'BOOLEAN', 'Сделка без задачи считается нарушением.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh380018irhgkjdfo17e', 'q_task_on_deal', 'Где должна ставиться задача по клиенту?', 'SINGLE', 'Задача ставится на сделку.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3a001cirhg9hgn8zus', 'q_confirm_comm', 'Что считается подтверждением выполненной задачи?', 'MULTIPLE', 'Нужен след коммуникации.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3b001iirhg2cqqewgl', 'q_mass_move', 'Массово переносить задачи без согласования с РОП запрещено.', 'BOOLEAN', 'Это прямое правило стандарта.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3c001lirhghhslntrp', 'q_duplicate_check', 'Что нужно сделать перед ручным созданием сделки?', 'SINGLE', 'Сначала проверяется телефон на дубль.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3e001pirhggl5b94y6', 'q_duplicate_close', 'Найдена старая активная сделка по клиенту. Что делать с новой?', 'CASE', 'Новая дублирующая сделка закрывается.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3f001tirhgwan576pr', 'q_backwards_forbidden', 'Сделку можно свободно двигать назад по воронке без оснований.', 'BOOLEAN', 'Возврат назад ограничен регламентом.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3g001wirhgcy9x54oz', 'q_target_reasons', 'Какие причины относятся к корректным целевым причинам закрытия?', 'MULTIPLE', 'Целевые причины перечислены отдельно.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3i0023irhg0mjewvqf', 'q_filter_without_task', 'Почему сделка может попасть в фильтр «без задач», хотя задача вроде есть?', 'SINGLE', 'Частая причина — задача стоит на контакте.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3j0027irhgwhznivr7', 'q_stage_responsible', 'Соотнесите этап и базово ответственного.', 'MATCHING', 'До первичной консультации отвечает оператор КЦ, далее — менеджер ОП.', NULL, '{"choices":["Оператор КЦ","Менеджер ОП"]}', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3k002cirhgnmeoavjo', 'q_success_check', 'Что нужно проверить перед переводом сделки в «Успешно реализовано»?', 'SINGLE', 'Перед успехом проверяются поля сделки и контакта.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3n002girhg1bgm2zpj', 'q_profile_phone', 'В профиле amoCRM запрещено указывать личный номер сотрудника.', 'BOOLEAN', 'Используется корпоративный номер.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3p002jirhgs2f7ai0k', 'q_vacation_delegate', 'Менеджер уходит в отпуск. Что делать по сделкам?', 'CASE', 'Нужно согласовать замещение и оставить контекст.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3s002nirhgtgljtkzr', 'q_no_task_violation', 'Какой срок активной сделки без задачи уже считается нарушением?', 'SINGLE', 'Более двух суток — нарушение.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3t002rirhg7t9p1pku', 'q_specific_date', 'Если клиент попросил позвонить в точную дату, задачу нужно поставить на этот срок.', 'BOOLEAN', 'Это отдельное правило постановки задач.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3v002uirhgopz6yjdr', 'q_partner_contacts', 'Какие сущности минимум должны быть в партнерской сделке?', 'SINGLE', 'Минимум нужны клиент и агент.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3w002yirhgdeul715j', 'q_allio_fields', 'Что обязательно фиксируется при бронировании в Allio?', 'MULTIPLE', 'Нужны объект, срок и исполнитель.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3y0034irhgg9kc9csj', 'q_intersection_violation', 'Что является умышленным нарушением при пересечении?', 'SINGLE', 'Скрытие пересечения или игнорирование проверки.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh3z0038irhgprr5w457', 'q_dashboard_widgets', 'Рабочий стол может настраиваться под отдел или конкретного менеджера.', 'BOOLEAN', 'Это видно в примере обучения.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh40003birhg0twe8x83', 'q_intro_decision', 'Кто принимает финальное решение после прохождения обучения?', 'SINGLE', 'Финальное решение закреплено за руководителем.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh41003firhgq6452dq5', 'q_status_review', 'Какой статус ставится после успешной сдачи курса до решения руководителя?', 'SINGLE', 'Результат уходит руководителю.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh44003jirhgvht1ezb3', 'q_intro_scope', 'Что включает сервис СтройТех?', 'MULTIPLE', 'В сервис входят роли, каталог, уроки и кабинеты.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh47003tirhgqcd6rs6b', 'q_callcenter_lead', 'Какой этап предназначен для новых обращений и первичной квалификации?', 'SINGLE', 'Новый клиент сначала в «Лиде».', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh49003xirhg8qapws99', 'q_callcenter_no_answer_once', 'Клиента можно закрыть после одного неответа.', 'BOOLEAN', 'Для неответа нужны повторные касания.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4a0040irhgb7jytd7r', 'q_callcenter_delay', 'Когда используется этап «Отложенный спрос»?', 'SINGLE', 'Когда клиент сам обозначил долгий горизонт покупки.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4b0044irhgfjkogteu', 'q_callcenter_hot', 'Какой этап используют для клиента с интересом, но без готовности к встрече?', 'SINGLE', 'Это «Горячий клиент».', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4c0048irhgdbhcizra', 'q_consultation_real', 'Короткий уточняющий звонок не считается полноценной консультацией.', 'BOOLEAN', 'Консультация — отдельное содержательное действие.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4e004birhgal2mchf2', 'q_op_buffer', 'Что верно для этапа «Передано в ОП»?', 'SINGLE', 'Он не должен быть длительным буфером.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4f004firhgcl4msz6b', 'q_decision_stage', 'Как называется этап, где клиент взял паузу после консультации?', 'SINGLE', 'Это этап принятия решения.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4g004jirhgkwldz94k', 'q_booking_stage', 'Какой этап используется для устной брони объекта в Allio?', 'SINGLE', 'Устная бронь фиксируется на броне.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4i004nirhg499fgzso', 'q_op_six_calls', 'Клиент перестал отвечать после передачи в ОП. Когда допустимо закрывать сделку?', 'CASE', 'Нужно сделать минимум 6 звонков в разные дни и время.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4j004rirhgn1n1tugz', 'q_partner_unique_agent', 'В партнерской логике на уникальность нужно проверять и клиента, и агента.', 'BOOLEAN', 'Проверяются обе стороны сделки.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4m004uirhgnzntef81', 'q_partner_not_answering', 'Сколько попыток связи нужно сделать, если агент перестал отвечать?', 'SINGLE', 'Минимум три попытки за два дня.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4n004yirhgy0efusjx', 'q_partner_structure', 'Соотнесите сущность и ее назначение в партнерской сделке.', 'MATCHING', 'Клиент, агент и компания агентства фиксируют разные роли.', NULL, '{"choices":["Покупатель","Посредник","Юр. оболочка агентства"]}', '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4p0052irhgmumw0gmy', 'q_antifraud_overdue', 'Просроченная задача более 5 дней — это нарушение.', 'BOOLEAN', 'Это один из базовых антифрод-критериев.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO questions (`id`, `topic`, `prompt`, `question_type`, `explanation`, `difficulty`, `meta_json`, `created_at`, `updated_at`) VALUES ('cmmq0rh4q0055irhghhjp8xsj', 'q_antifraud_no_proof', 'Задача закрыта, но нет записи разговора, скрина или офлайн-примечания. Как трактовать ситуацию?', 'CASE', 'Это нарушение по подтверждению коммуникации.', NULL, NULL, '2026-03-14 07:43:43', '2026-03-14 07:43:43');

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh330012irhg8g5v0bf2', 'cmmq0rh330011irhguei8majw', 'Из раздела «Задачи»', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh330013irhg2mohyhh3', 'cmmq0rh330011irhguei8majw', 'Из аналитики', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh330014irhgjqy9vxad', 'cmmq0rh330011irhguei8majw', 'Из переписки', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh360016irhgfvpblg2x', 'cmmq0rh360015irhgvi1veew9', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh360017irhgkxumiscj', 'cmmq0rh360015irhgvi1veew9', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh380019irhgak99eqbl', 'cmmq0rh380018irhgkjdfo17e', 'На карточке сделки', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh38001airhgz3p97hew', 'cmmq0rh380018irhgkjdfo17e', 'На карточке контакта', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh38001birhgxrumjn8e', 'cmmq0rh380018irhgkjdfo17e', 'В профиле сотрудника', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3a001dirhg3195rzpa', 'cmmq0rh3a001cirhg9hgn8zus', 'Запись разговора', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3a001eirhg2zqpe3k3', 'cmmq0rh3a001cirhg9hgn8zus', 'Скрин WhatsApp', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3a001firhgzs6733vn', 'cmmq0rh3a001cirhg9hgn8zus', 'Примечание об офлайн-консультации', 1, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3a001girhgc36f4pw7', 'cmmq0rh3a001cirhg9hgn8zus', 'Пустая закрытая задача', 0, NULL, 4);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3a001hirhgzblfutdx', 'cmmq0rh3a001cirhg9hgn8zus', 'Смена ответственного без комментария', 0, NULL, 5);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3b001jirhgxy25041h', 'cmmq0rh3b001iirhg2cqqewgl', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3b001kirhgy4rdlto7', 'cmmq0rh3b001iirhg2cqqewgl', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3d001mirhgfuykkiwr', 'cmmq0rh3c001lirhghhslntrp', 'Проверить номер телефона клиента в amoCRM', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3d001nirhgb55b1384', 'cmmq0rh3c001lirhghhslntrp', 'Закрыть старую сделку заранее', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3d001oirhgxaqznwo6', 'cmmq0rh3c001lirhghhslntrp', 'Поставить личный номер менеджера', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3e001qirhg2kqjdxp6', 'cmmq0rh3e001pirhggl5b94y6', 'Закрыть новую сделку с причиной «дубль»', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3e001rirhgkyabek7w', 'cmmq0rh3e001pirhggl5b94y6', 'Оставить обе в работе', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3e001sirhg9zyvhzrq', 'cmmq0rh3e001pirhggl5b94y6', 'Удалить старую сделку', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3f001uirhgb22ppmtn', 'cmmq0rh3f001tirhgwan576pr', 'Верно', 0, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3f001virhg5j311cqb', 'cmmq0rh3f001tirhgwan576pr', 'Неверно', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g001xirhgja2wtuh4', 'cmmq0rh3g001wirhgcy9x54oz', 'Неплатежеспособен', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g001yirhgplmwvsv1', 'cmmq0rh3g001wirhgcy9x54oz', 'Купил другое', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g001zirhglvi4ipe9', 'cmmq0rh3g001wirhgcy9x54oz', 'Не подходит срок сдачи', 1, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g0020irhgyfv3zcd2', 'cmmq0rh3g001wirhgcy9x54oz', 'Нет квартир в сданных домах', 1, NULL, 4);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g0021irhgs3elthm6', 'cmmq0rh3g001wirhgcy9x54oz', 'Дубль', 0, NULL, 5);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3g0022irhgl65kgzi3', 'cmmq0rh3g001wirhgcy9x54oz', 'Неверный телефон', 0, NULL, 6);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3i0024irhgbrn99aqd', 'cmmq0rh3i0023irhg0mjewvqf', 'Потому что задача поставлена на контакт, а не на сделку', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3i0025irhgde57udre', 'cmmq0rh3i0023irhg0mjewvqf', 'Потому что удалена аналитика', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3i0026irhguvyou9uv', 'cmmq0rh3i0023irhg0mjewvqf', 'Потому что нет аватара', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3j0028irhgpc8v4vtf', 'cmmq0rh3j0027irhgwhznivr7', 'Лид', 1, 'Оператор КЦ', 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3j0029irhg8prbhcdv', 'cmmq0rh3j0027irhgwhznivr7', 'Не отвечает', 1, 'Оператор КЦ', 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3j002airhg95z9afms', 'cmmq0rh3j0027irhgwhznivr7', 'Проведение встреч/показов', 1, 'Менеджер ОП', 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3j002birhg781bcm71', 'cmmq0rh3j0027irhgwhznivr7', 'Заключение договора', 1, 'Менеджер ОП', 4);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3k002dirhg78wkgvne', 'cmmq0rh3k002cirhgnmeoavjo', 'Корректность заполнения сделки и карточки контакта', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3k002eirhgowwtwmgb', 'cmmq0rh3k002cirhgnmeoavjo', 'Только дату первого звонка', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3k002firhgdi6gqfx6', 'cmmq0rh3k002cirhgnmeoavjo', 'Только цвет карточки', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3n002hirhgg6kxhedi', 'cmmq0rh3n002girhg1bgm2zpj', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3n002iirhg6mxg9xng', 'cmmq0rh3n002girhg1bgm2zpj', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3p002kirhge5567zpl', 'cmmq0rh3p002jirhgs2f7ai0k', 'Согласовать замещение, описать контекст и назначить ответственных', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3p002lirhgd38mt13x', 'cmmq0rh3p002jirhgs2f7ai0k', 'Просто перенести все задачи вперед', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3p002mirhg8vyy0ax2', 'cmmq0rh3p002jirhgs2f7ai0k', 'Удалить активные задачи', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3s002oirhgfr9q7dr8', 'cmmq0rh3s002nirhgtgljtkzr', 'Более 2 суток', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3s002pirhgyjos9tyl', 'cmmq0rh3s002nirhgtgljtkzr', 'Более 30 суток', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3s002qirhgcqlvkz6k', 'cmmq0rh3s002nirhgtgljtkzr', 'Любой срок допустим', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3t002sirhgsc6bh6v9', 'cmmq0rh3t002rirhg7t9p1pku', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3t002tirhgl0irz5vu', 'cmmq0rh3t002rirhg7t9p1pku', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3v002virhgsirpe8el', 'cmmq0rh3v002uirhgopz6yjdr', 'Клиент и агент, а при необходимости еще и компания агентства', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3v002wirhgvsfdm08d', 'cmmq0rh3v002uirhgopz6yjdr', 'Только клиент', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3v002xirhgclk8siwt', 'cmmq0rh3v002uirhgopz6yjdr', 'Только агентство', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3w002zirhgo1uesf6m', 'cmmq0rh3w002yirhgdeul715j', 'Объект', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3w0030irhg55nb42rp', 'cmmq0rh3w002yirhgdeul715j', 'Дата окончания брони', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3w0031irhg0oa8rw6q', 'cmmq0rh3w002yirhgdeul715j', 'Кто поставил бронь', 1, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3w0032irhgjtw4ymgz', 'cmmq0rh3w002yirhgdeul715j', 'Личный номер менеджера', 0, NULL, 4);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3w0033irhgh0jdbobi', 'cmmq0rh3w002yirhgdeul715j', 'Причина недовольства клиента', 0, NULL, 5);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3y0035irhgje74x09g', 'cmmq0rh3y0034irhgg9kc9csj', 'Игнорирование проверки клиента на пересечение', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3y0036irhgk89mv1dn', 'cmmq0rh3y0034irhgg9kc9csj', 'Корректная фиксация отказа', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3y0037irhgznoji8hj', 'cmmq0rh3y0034irhgg9kc9csj', 'Постановка задачи на сделке', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3z0039irhgqhs47j1l', 'cmmq0rh3z0038irhgprr5w457', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh3z003airhgj8t1gr8n', 'cmmq0rh3z0038irhgprr5w457', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh40003cirhgsdmekr7i', 'cmmq0rh40003birhg0twe8x83', 'Руководитель', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh40003dirhgzphqcmfj', 'cmmq0rh40003birhg0twe8x83', 'Ученик', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh40003eirhgc6w1fnqr', 'cmmq0rh40003birhg0twe8x83', 'Техподдержка', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh41003girhggqm4qv3m', 'cmmq0rh41003firhgq6452dq5', 'Отправлен руководителю', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh41003hirhg7ju379oe', 'cmmq0rh41003firhgq6452dq5', 'Архив', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh41003iirhgkgd8khia', 'cmmq0rh41003firhgq6452dq5', 'Скрыт', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh44003kirhgy4ajtcj2', 'cmmq0rh44003jirhgvht1ezb3', 'Каталог курсов', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh44003lirhgo1242i5p', 'cmmq0rh44003jirhgvht1ezb3', 'Кабинет руководителя', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh44003mirhgy1gsf0kd', 'cmmq0rh44003jirhgvht1ezb3', 'Редактор курсов', 1, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh44003nirhgk7kq33ta', 'cmmq0rh44003jirhgvht1ezb3', 'Реальная интеграция с amoCRM', 0, NULL, 4);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh44003oirhgcgydjxuh', 'cmmq0rh44003jirhgvht1ezb3', 'HRM с зарплатой', 0, NULL, 5);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh47003uirhguzb7170x', 'cmmq0rh47003tirhgqcd6rs6b', 'Лид', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh47003virhgrmjd6ui5', 'cmmq0rh47003tirhgqcd6rs6b', 'Бронирование', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh47003wirhgbc6obdpe', 'cmmq0rh47003tirhgqcd6rs6b', 'Успешно реализовано', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh49003yirhgb73votmw', 'cmmq0rh49003xirhg8qapws99', 'Верно', 0, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh49003zirhgk79vbtyk', 'cmmq0rh49003xirhg8qapws99', 'Неверно', 1, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4a0041irhg2u1j28ow', 'cmmq0rh4a0040irhgb7jytd7r', 'Когда клиент честно обозначил долгий горизонт покупки', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4a0042irhgblvyziy7', 'cmmq0rh4a0040irhgb7jytd7r', 'Когда менеджер забыл позвонить', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4a0043irhg0qys5alw', 'cmmq0rh4a0040irhgb7jytd7r', 'После оплаты договора', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4b0045irhg6i1upraj', 'cmmq0rh4b0044irhgfjkogteu', 'Горячий клиент', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4b0046irhgficiwc7t', 'cmmq0rh4b0044irhgfjkogteu', 'Успешно реализовано', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4b0047irhgwm1hh9nz', 'cmmq0rh4b0044irhgfjkogteu', 'Закрыто и нереализовано', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4d0049irhgghku1ifq', 'cmmq0rh4c0048irhgdbhcizra', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4d004airhgkxdxqz7x', 'cmmq0rh4c0048irhgdbhcizra', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4e004cirhgckkw6gmq', 'cmmq0rh4e004birhgal2mchf2', 'К концу дня сделки на нем должны быть обработаны', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4e004dirhgovtcg0dy', 'cmmq0rh4e004birhgal2mchf2', 'Он используется для хранения всей недели', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4e004eirhgcjgc7508', 'cmmq0rh4e004birhgal2mchf2', 'Он равен успеху сделки', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4f004girhge37i83xa', 'cmmq0rh4f004firhgcl4msz6b', 'Принятие решения', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4f004hirhgukfpxkzh', 'cmmq0rh4f004firhgcl4msz6b', 'Лид', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4f004iirhg27qb4w4u', 'cmmq0rh4f004firhgcl4msz6b', 'Не отвечает', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4g004kirhglf7bu8sm', 'cmmq0rh4g004jirhgkwldz94k', 'Бронирование', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4g004lirhghubkoer9', 'cmmq0rh4g004jirhgkwldz94k', 'Лид', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4g004mirhg7e7253pt', 'cmmq0rh4g004jirhgkwldz94k', 'Горячий клиент', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4i004oirhgua44ijxm', 'cmmq0rh4i004nirhg499fgzso', 'После не менее чем 6 звонков в разные дни и время', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4i004pirhgyfm3i2tb', 'cmmq0rh4i004nirhg499fgzso', 'После одного звонка', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4i004qirhgry5u6iqs', 'cmmq0rh4i004nirhg499fgzso', 'Сразу в конце дня', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4k004sirhghl46q36x', 'cmmq0rh4j004rirhgn1n1tugz', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4k004tirhgiy1jf0hp', 'cmmq0rh4j004rirhgn1n1tugz', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4m004virhggyz0m3h6', 'cmmq0rh4m004uirhgnzntef81', 'Не менее 3 попыток за 2 дня', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4m004wirhghwq80w5x', 'cmmq0rh4m004uirhgnzntef81', 'Одну попытку', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4m004xirhgbyijiirg', 'cmmq0rh4m004uirhgnzntef81', 'Десять попыток за час', 0, NULL, 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4o004zirhgmkytwmbn', 'cmmq0rh4n004yirhgy0efusjx', 'Контакт клиента', 1, 'Покупатель', 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4o0050irhg5cksdzm0', 'cmmq0rh4n004yirhgy0efusjx', 'Контакт агента', 1, 'Посредник', 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4o0051irhgxyzsoqtd', 'cmmq0rh4n004yirhgy0efusjx', 'Компания агентства', 1, 'Юр. оболочка агентства', 3);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4p0053irhgbzfhhngr', 'cmmq0rh4p0052irhgmumw0gmy', 'Верно', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4p0054irhg8uouplq0', 'cmmq0rh4p0052irhgmumw0gmy', 'Неверно', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4q0056irhgqltizhe5', 'cmmq0rh4q0055irhghhjp8xsj', 'Как нарушение антифрод-правил', 1, NULL, 1);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4q0057irhg653riatq', 'cmmq0rh4q0055irhghhjp8xsj', 'Как нормальный сценарий', 0, NULL, 2);

INSERT INTO answer_options (`id`, `question_id`, `label`, `is_correct`, `match_key`, `sort_order`) VALUES ('cmmq0rh4q0058irhgmnfmdjin', 'cmmq0rh4q0055irhghhjp8xsj', 'Как успешное завершение сделки', 0, NULL, 3);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4v005girhgf8o98e26', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh40003birhg0twe8x83', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4v005hirhggk9ih89t', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh41003firhgq6452dq5', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4v005iirhgq8qbtmjm', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh44003jirhgvht1ezb3', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4v005kirhghwo28c9e', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh3z0038irhgprr5w457', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006kirhgvrokqmpm', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh4e004birhgal2mchf2', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006mirhgdk1ono1h', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh4f004firhgcl4msz6b', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006oirhga37q2dll', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh4g004jirhgkwldz94k', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006pirhgsc1zknpo', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh3k002cirhgnmeoavjo', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006qirhgravvcllj', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh4c0048irhgdbhcizra', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006rirhggx93jbk1', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh4i004nirhg499fgzso', 6, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006sirhgvhidwbav', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh3g001wirhgcy9x54oz', 7, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006tirhggeqr984h', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh3w002yirhgdeul715j', 8, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006uirhg6q887j8z', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh3f001tirhgwan576pr', 9, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006virhgh1jxkk8k', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh3e001pirhggl5b94y6', 10, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh5s009dirhg025ddzj2', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh4e004birhgal2mchf2', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh5s009eirhgv32c6bgf', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh380018irhgkjdfo17e', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh5s009firhgu4fzo1ab', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh360015irhgvi1veew9', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh5s009girhgj2xkdoh7', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh3a001cirhg9hgn8zus', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh5s009hirhguxn0yr6b', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh330011irhguei8majw', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh60009tirhglmqym4fl', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh4c0048irhgdbhcizra', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh60009uirhgfzswg2ut', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh3a001cirhg9hgn8zus', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh60009virhgf587kslk', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh3k002cirhgnmeoavjo', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh60009wirhgz78z500w', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh330011irhguei8majw', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh60009xirhg6gbl4g4y', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh3t002rirhg7t9p1pku', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6400a2irhgvwgpxngz', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh40003birhg0twe8x83', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6500a3irhg6jsfh17i', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh44003jirhgvht1ezb3', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6500a4irhgqldcbebu', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh3z0038irhgprr5w457', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6a00agirhgne2bgne9', 'cmmq0rh6a00aeirhglkydgepl', 'cmmq0rh41003firhgq6452dq5', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6a00ahirhgc6gyee7g', 'cmmq0rh6a00aeirhglkydgepl', 'cmmq0rh40003birhg0twe8x83', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0064irhgpkh2q3kl', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh47003tirhgqcd6rs6b', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0067irhgve377r9w', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh49003xirhg8qapws99', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006airhgza2ed3ee', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh4a0040irhgb7jytd7r', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006dirhgf7v1xph0', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh4b0044irhgfjkogteu', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006firhgryliwoax', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh360015irhgvi1veew9', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006hirhg5cjkmzja', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh380018irhgkjdfo17e', 6, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006iirhgqd6y52s7', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh3t002rirhg7t9p1pku', 7, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006jirhge9aj5g21', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh3a001cirhg9hgn8zus', 8, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006lirhgqvk22z8o', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh3i0023irhg0mjewvqf', 9, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006nirhg6cmwwid3', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh40003birhg0twe8x83', 10, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6l00b4irhg0lah7hd3', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh47003tirhgqcd6rs6b', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6l00b5irhg00e88wia', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh360015irhgvi1veew9', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6l00b6irhg98c4rjtl', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh380018irhgkjdfo17e', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6l00b7irhg93crndxg', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh40003birhg0twe8x83', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6l00b8irhgaa6f4d0g', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh3t002rirhg7t9p1pku', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6r00bkirhga4u48rzk', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh49003xirhg8qapws99', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6r00blirhgfa6sd8ft', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh4a0040irhgb7jytd7r', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6r00bmirhg94fw2sxq', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh3t002rirhg7t9p1pku', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6r00bnirhg57aid1dn', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh360015irhgvi1veew9', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh6r00boirhgzeisvkp2', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh3b001iirhg2cqqewgl', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7100c7irhga2mghlyo', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh4f004firhgcl4msz6b', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7100c8irhgz31wyvye', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh4g004jirhgkwldz94k', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7100c9irhgismn9wzs', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh3w002yirhgdeul715j', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7100cairhgcqwos38b', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh360015irhgvi1veew9', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7100cbirhglq0ctzpx', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh3f001tirhgwan576pr', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7e00ctirhg1v3g0wl3', 'cmmq0rh7e00crirhg6fuh1l6u', 'cmmq0rh4b0044irhgfjkogteu', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7e00cuirhg9dr4eprp', 'cmmq0rh7e00crirhg6fuh1l6u', 'cmmq0rh47003tirhgqcd6rs6b', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7e00cvirhg4a61qlly', 'cmmq0rh7e00crirhg6fuh1l6u', 'cmmq0rh3t002rirhg7t9p1pku', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7e00cwirhgfk7cxeft', 'cmmq0rh7e00crirhg6fuh1l6u', 'cmmq0rh360015irhgvi1veew9', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh7e00cxirhgyl8f6424', 'cmmq0rh7e00crirhg6fuh1l6u', 'cmmq0rh3a001cirhg9hgn8zus', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh8y00dxirhgg3yi3wvt', 'cmmq0rh8y00dvirhg1m4fju5k', 'cmmq0rh3w002yirhgdeul715j', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh8y00dyirhgrkmj00gw', 'cmmq0rh8y00dvirhg1m4fju5k', 'cmmq0rh4g004jirhgkwldz94k', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh8y00dzirhg5hd8wgll', 'cmmq0rh8y00dvirhg1m4fju5k', 'cmmq0rh3f001tirhgwan576pr', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh8y00e0irhg9zqbo1ob', 'cmmq0rh8y00dvirhg1m4fju5k', 'cmmq0rh3k002cirhgnmeoavjo', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh8y00e1irhg1rd95hpe', 'cmmq0rh8y00dvirhg1m4fju5k', 'cmmq0rh360015irhgvi1veew9', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005oirhgts3xjuwr', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh330011irhguei8majw', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005pirhgr4rft393', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh360015irhgvi1veew9', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005rirhgfwio5sc6', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh380018irhgkjdfo17e', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005sirhg6b78ah5b', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3a001cirhg9hgn8zus', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005tirhgn2w85wcb', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3b001iirhg2cqqewgl', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005uirhg5fsuikhq', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3c001lirhghhslntrp', 6, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005virhggizh6xe2', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3e001pirhggl5b94y6', 7, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005wirhga3lppxo1', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3f001tirhgwan576pr', 8, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005xirhgpc5x9fes', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3g001wirhgcy9x54oz', 9, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005yirhgq92yz54x', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3i0023irhg0mjewvqf', 10, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w005zirhgbmgvgkut', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3j0027irhgwhznivr7', 11, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0060irhg55c4i1yn', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3k002cirhgnmeoavjo', 12, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0061irhgwbvrj1fg', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3n002girhg1bgm2zpj', 13, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0062irhg9np8l21v', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3p002jirhgs2f7ai0k', 14, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0063irhgf4m3m54e', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3s002nirhgtgljtkzr', 15, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0065irhg4epxmklc', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3t002rirhg7t9p1pku', 16, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0066irhgc8r7jpfl', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3v002uirhgopz6yjdr', 17, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w0068irhgwm44cn06', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3w002yirhgdeul715j', 18, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006birhgicnprrx7', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3y0034irhgg9kc9csj', 19, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006cirhgkrpw0mvu', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh3z0038irhgprr5w457', 20, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006eirhgjenezzgq', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh40003birhg0twe8x83', 21, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4w006girhgn5zkulx4', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh41003firhgq6452dq5', 22, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9o00epirhgepa8qgc7', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh3z0038irhgprr5w457', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9o00eqirhgav58o6mz', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh330011irhguei8majw', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9o00erirhgfromyv1q', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh360015irhgvi1veew9', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9o00esirhgsaz2rc29', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh3i0023irhg0mjewvqf', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9o00etirhgwb905suz', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh44003jirhgvht1ezb3', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9w00f5irhg0hhzia1h', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh330011irhguei8majw', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9w00f6irhg2mud6cyt', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh360015irhgvi1veew9', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9w00f7irhgs45oo4ff', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh380018irhgkjdfo17e', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9w00f8irhgpgcbgc0a', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh3a001cirhg9hgn8zus', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh9w00f9irhgazk7zu12', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh3i0023irhg0mjewvqf', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rha400fmirhgxx0ygi07', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh3c001lirhghhslntrp', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rha400fnirhgs5eiyv1o', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh3e001pirhggl5b94y6', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rha400foirhgb0rbznuu', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh3y0034irhgg9kc9csj', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rha400fpirhgfmtny9kn', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh360015irhgvi1veew9', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rha400fqirhgp4oylgjb', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh3n002girhg1bgm2zpj', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhaa00g2irhgkx5vrid0', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh3a001cirhg9hgn8zus', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhaa00g3irhge8bdsbir', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh360015irhgvi1veew9', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhaa00g4irhgth99e25h', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh330011irhguei8majw', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhaa00g5irhgi2m8tqa6', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh4q0055irhghhjp8xsj', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhaa00g6irhgsrsuyos4', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh3t002rirhg7t9p1pku', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhah00giirhgf2c4gjjv', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh3f001tirhgwan576pr', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhah00gjirhg6zkken9p', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh3j0027irhgwhznivr7', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhah00gkirhg558sedan', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh3k002cirhgnmeoavjo', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhah00glirhghubnvejl', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh360015irhgvi1veew9', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhah00gmirhg5qr7l8os', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh4b0044irhgfjkogteu', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhap00gyirhgtcwi6psa', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh3g001wirhgcy9x54oz', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhap00gzirhgwmd54xft', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh3e001pirhggl5b94y6', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhap00h0irhgj6y684w2', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh3k002cirhgnmeoavjo', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhap00h1irhg9e1u5q1j', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh3n002girhg1bgm2zpj', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhap00h2irhgh8ruwk9l', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh40003birhg0twe8x83', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhav00heirhg3dxlghu3', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh3s002nirhgtgljtkzr', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhav00hfirhgnsn7zhab', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh4p0052irhgmumw0gmy', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhav00hgirhgkwhy6xis', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh4q0055irhghhjp8xsj', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhav00hhirhgtrrfh34z', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh3y0034irhgg9kc9csj', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhav00hiirhgkro7dbo6', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh3p002jirhgs2f7ai0k', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhb400hvirhgaqznjk2r', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh3w002yirhgdeul715j', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhb400hwirhg3qwh05cq', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh4g004jirhgkwldz94k', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhb400hxirhgxjjbrajb', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh3f001tirhgwan576pr', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhb400hyirhg9546h2ns', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh3k002cirhgnmeoavjo', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhb400hzirhgpud3dkjx', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh4b0044irhgfjkogteu', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x007wirhgsa3vsnl2', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh3v002uirhgopz6yjdr', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x007xirhgpl9j010w', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh4j004rirhgn1n1tugz', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x007yirhglxvx3wuh', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh4m004uirhgnzntef81', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x007zirhgiql4kg80', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh4n004yirhgy0efusjx', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0080irhgyvrl50y8', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh3c001lirhghhslntrp', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0081irhggo29tbzh', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh3e001pirhggl5b94y6', 6, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0082irhga6md50zo', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh3y0034irhgg9kc9csj', 7, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0083irhgnch3ztni', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh380018irhgkjdfo17e', 8, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0084irhgtq8s5p5n', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh3a001cirhg9hgn8zus', 9, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rh4x0085irhgfkhaqzab', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh360015irhgvi1veew9', 10, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhca00ijirhgynvou3x4', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh3v002uirhgopz6yjdr', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhca00ikirhgd5973qjb', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh4n004yirhgy0efusjx', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhca00ilirhgqgk38o8g', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh4j004rirhgn1n1tugz', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhca00imirhghvi28jhx', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh380018irhgkjdfo17e', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhca00inirhgvgi4ndl2', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh3a001cirhg9hgn8zus', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcj00izirhggffistp8', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh4j004rirhgn1n1tugz', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcj00j0irhgc4ynqs0e', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh3y0034irhgg9kc9csj', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcj00j1irhgfjpyro7m', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh3c001lirhghhslntrp', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcj00j2irhgwjhys6ry', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh3e001pirhggl5b94y6', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcj00j3irhgjx60gmj5', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh4q0055irhghhjp8xsj', 5, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcq00jfirhgxkw9ds9a', 'cmmq0rhcq00jdirhg80m7uzvn', 'cmmq0rh4m004uirhgnzntef81', 1, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcq00jgirhgr03h0ufb', 'cmmq0rhcq00jdirhg80m7uzvn', 'cmmq0rh3a001cirhg9hgn8zus', 2, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcq00jhirhgek4vlc0l', 'cmmq0rhcq00jdirhg80m7uzvn', 'cmmq0rh380018irhgkjdfo17e', 3, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcq00jiirhgrn0620jf', 'cmmq0rhcq00jdirhg80m7uzvn', 'cmmq0rh4n004yirhgy0efusjx', 4, 1);

INSERT INTO quiz_questions (`id`, `quiz_id`, `question_id`, `sort_order`, `points`) VALUES ('cmmq0rhcq00jjirhgq7lqg6kh', 'cmmq0rhcq00jdirhg80m7uzvn', 'cmmq0rh3t002rirhg7t9p1pku', 5, 1);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhec00kjirhgp8h3lws8', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rh23000mirhgcq9pi09y', 'COMPLETED', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhev00l5irhg45yvp775', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rh23000mirhgcq9pi09y', 'IN_PROGRESS', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL, NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhg500mtirhgfhyszxxw', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rh23000mirhgcq9pi09y', 'IN_PROGRESS', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL, NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhgu00ntirhgga2uzh68', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rh23000mirhgcq9pi09y', 'COMPLETED', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhhg00ofirhggfeo0imc', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rh23000mirhgcq9pi09y', 'RECOMMENDED_FOR_ACCESS', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 12:06:02', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhix00qfirhg6abdirre', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rh23000mirhgcq9pi09y', 'REPEAT_TRAINING', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 12:06:19', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhjl00rfirhgedv7jg40', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rh23000mirhgcq9pi09y', 'COMPLETED', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhk100s1irhgsyrr5imi', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhc800ibirhg6gct05li', 'cmmq0rh23000mirhgcq9pi09y', 'REPEAT_TRAINING', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL);

INSERT INTO enrollments (`id`, `user_id`, `course_id`, `assigned_by_id`, `status`, `assigned_at`, `started_at`, `completed_at`, `due_at`) VALUES ('cmmq0rhkn00szirhg350704vm', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rh23000mirhgcq9pi09y', 'FAILED', '2026-03-14 07:43:44', '2026-03-14 07:43:44', NULL, NULL);

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhep00l3irhgymol8hlp', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rhec00kjirhgp8h3lws8', 100, 4, 4, 2, 2, 'COMPLETED', 'cmmq0rh6e00arirhgwavbt8i6', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhg000mrirhg6eja40wf', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rhev00l5irhg45yvp775', 38, 6, 16, 3, 8, 'IN_PROGRESS', 'cmmq0rha900fzirhged9eeo3t', '2026-03-14 07:43:44', NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgs00nrirhg97cji6a8', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6j00atirhgiy2kz3z7', 'cmmq0rhg500mtirhgfhyszxxw', 38, 3, 8, 1, 5, 'IN_PROGRESS', 'cmmq0rh6u00bsirhg12fa6ppv', '2026-03-14 07:43:44', NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhe00odirhgpvpqr65o', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rhgu00ntirhgga2uzh68', 100, 4, 4, 2, 2, 'COMPLETED', 'cmmq0rh6e00arirhgwavbt8i6', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhir00qbirhgheojw3qa', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9l00ecirhgu22760el', 'cmmq0rhhg00ofirhggfeo0imc', 100, 16, 16, 8, 8, 'RECOMMENDED_FOR_ACCESS', 'cmmq0rhb900i9irhg480rxbn4', '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhji00rbirhgxjeqn29z', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh5p0092irhgzw7oxjul', 'cmmq0rhix00qfirhg6abdirre', 86, 6, 7, 3, 4, 'REPEAT_TRAINING', 'cmmq0rh7500ckirhg93ydcom9', '2026-03-14 12:06:19', '2026-03-14 12:06:19', '2026-03-14 07:43:44', '2026-03-14 12:06:19');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjy00rzirhglsxf30ic', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh4x0087irhgdorgouv1', 'cmmq0rhjl00rfirhgedv7jg40', 100, 4, 4, 2, 2, 'COMPLETED', 'cmmq0rh6e00arirhgwavbt8i6', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkk00svirhgegjdsfo5', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhc800ibirhg6gct05li', 'cmmq0rhk100s1irhgsyrr5imi', 57, 4, 7, 2, 4, 'REPEAT_TRAINING', 'cmmq0rhco00jcirhgrudda1nl', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO progress (`id`, `user_id`, `course_id`, `enrollment_id`, `completion_percent`, `lessons_completed`, `lessons_total`, `modules_completed`, `modules_total`, `status`, `last_lesson_id`, `last_activity_at`, `completed_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkx00tdirhgrk0i8rbj', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh4w007airhgnxlfwibv', 'cmmq0rhkn00szirhg350704vm', 67, 2, 3, 2, 3, 'FAILED', 'cmmq0rhe200k9irhghazyak8s', '2026-03-14 07:43:44', NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhej00ktirhg0frz9p0g', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6600a6irhgfznreogh', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhel00kxirhghtuhada1', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6b00akirhgddy0euz0', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfh00m3irhgn9dj5jwf', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9q00evirhgh4icrtdw', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfl00m7irhgah03pfwp', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9x00fbirhg6ogxpvvc', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfq00mbirhg9o0pe2u0', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rha600fsirhg422jvah2', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfu00mfirhg25qt10yq', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhab00g8irhgrg55e86p', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfv00mhirhgcl8kgr5f', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhai00goirhg9mb67drv', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfw00mjirhgmw4x53zx', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhar00h4irhgys8cju75', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfx00mlirhgm7pu28wu', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhaw00hkirhgzwy531zq', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfy00mnirhgwmpp4huw', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhb500i1irhg8jsplhxr', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgf00nbirhgqupvxo6m', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6n00bairhgpxyyt15q', 'cmmq0rhg500mtirhgfhyszxxw', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgh00nfirhgxdvdyprh', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6t00bqirhgpr18dzj7', 'cmmq0rhg500mtirhgfhyszxxw', 50, 0, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgl00njirhgp5i2bbv2', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7g00czirhga4fnqf0u', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgn00nlirhg65m430ve', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7u00d8irhg2b9gbokz', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgo00nnirhgc8hff4yo', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7y00deirhgvxvei2rb', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhh800o3irhg9vy26rnj', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6600a6irhgfznreogh', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhha00o7irhgnuhp03ra', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6b00akirhgddy0euz0', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi600pdirhgf0skraxs', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9q00evirhgh4icrtdw', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi900phirhg9l3673qr', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9x00fbirhg6ogxpvvc', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhib00plirhgq2apt0ml', 'cmmq0rh28000sirhg8quemref', 'cmmq0rha600fsirhg422jvah2', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhid00ppirhg6eqgu5fl', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhab00g8irhgrg55e86p', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhii00ptirhgdzog4j28', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhai00goirhg9mb67drv', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhik00pxirhgosb8db20', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhar00h4irhgys8cju75', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhim00q1irhgs2kovlwl', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhaw00hkirhgzwy531zq', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhio00q5irhgahin4ovx', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhb500i1irhg8jsplhxr', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 12:06:02', '2026-03-14 12:06:02', '2026-03-14 07:43:44', '2026-03-14 12:06:02');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj700qvirhg4gnpa3b7', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh5t009jirhgggqhfrkl', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 12:06:19', '2026-03-14 12:06:19', '2026-03-14 07:43:44', '2026-03-14 12:06:19');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj900qzirhgdd02vki0', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh63009zirhgpcyn9y02', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 12:06:19', '2026-03-14 12:06:19', '2026-03-14 07:43:44', '2026-03-14 12:06:19');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjb00r3irhgeq5nahbs', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7300cdirhg9gyqacfr', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 12:06:19', '2026-03-14 12:06:19', '2026-03-14 07:43:44', '2026-03-14 12:06:19');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjf00r7irhgx4jtdvu5', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7600cmirhgrmptcrxx', 'cmmq0rhix00qfirhg6abdirre', 0, 1, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 12:06:19');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjq00rpirhgyx2azeut', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6600a6irhgfznreogh', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhju00rtirhgyftiah8p', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6b00akirhgddy0euz0', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkc00shirhghah0yldl', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcc00ipirhgum0oj68x', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkf00slirhg9jwket4p', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcl00j5irhgd6946q48', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkh00spirhg3fwujlrs', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcr00jlirhgwr6k4tm4', 'cmmq0rhk100s1irhgsyrr5imi', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhki00srirhgapiexoyw', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcw00juirhgzbp8uaeb', 'cmmq0rhk100s1irhgsyrr5imi', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhku00t7irhg934u1hc2', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhdw00k0irhgnuz0etkv', 'cmmq0rhkn00szirhg350704vm', 100, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkv00t9irhgku4z53oj', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhe100k7irhgtw0wbjmx', 'cmmq0rhkn00szirhg350704vm', 100, 0, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO module_progress (`id`, `user_id`, `module_id`, `enrollment_id`, `completion_percent`, `quiz_passed`, `completed_at`, `last_activity_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkw00tbirhg104zv2jy', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhe400kdirhggz35txua', 'cmmq0rhkn00szirhg350704vm', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhee00klirhgez8jjw1q', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6700a8irhgd2uu8exz', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhef00knirhgb9pzhg2q', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6900adirhgukyvjdr9', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rheg00kpirhg0qdvza5s', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6c00amirhg8ngntu43', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhei00krirhgjjhseuf4', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6e00arirhgwavbt8i6', 'cmmq0rhec00kjirhgp8h3lws8', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhew00l7irhgyl47035q', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9s00exirhg4buxurda', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhex00l9irhgxieqefl8', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9u00f2irhguwp5rqy4', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhez00lbirhg00t6mg4p', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh9y00fdirhgp57ffgwi', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf000ldirhg5y5s173l', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rha200fjirhg5panakde', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf100lfirhgu6pgylkq', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rha700fuirhg7m7jynt7', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf200lhirhgcbkiz2xh', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rha900fzirhged9eeo3t', 'cmmq0rhev00l5irhg45yvp775', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf300ljirhgt7ql3wwt', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhad00gairhgxp5swvdj', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf400llirhgad6q7wpv', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhaf00gfirhgayi98fse', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf500lnirhgju1sxr5i', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhal00gqirhgzspuocv4', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhf800lpirhg0qcwbjgz', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhan00gvirhgm318dfxx', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfa00lrirhg9rxbqv5o', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhas00h6irhgchhe2vxs', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfb00ltirhg5e9ahnva', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhau00hbirhgayzpmksb', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfd00lvirhgozgooj6w', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhay00hmirhgufb3yvmn', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfe00lxirhg9ej684dv', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhb100hsirhgnshj2dg3', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhff00lzirhg4pgrca68', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhb700i3irhg0so8v7vy', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhfg00m1irhgzqe8uyf0', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhb900i9irhg480rxbn4', 'cmmq0rhev00l5irhg45yvp775', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhg700mvirhgegmzz6xv', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6o00bcirhgdpyisove', 'cmmq0rhg500mtirhgfhyszxxw', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhg800mxirhgs922gkum', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6q00bhirhgmga6tia7', 'cmmq0rhg500mtirhgfhyszxxw', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhg900mzirhgs1yao1qt', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6u00bsirhg12fa6ppv', 'cmmq0rhg500mtirhgfhyszxxw', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhga00n1irhglvsjzw57', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh6x00bxirhgvzcgymz1', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgb00n3irhgjgafmn2l', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7h00d1irhg7t4p8i6g', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgc00n5irhgb50vsy6b', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7r00d6irhgcyw2r2h9', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhgd00n7irhgxyo2z76y', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7w00dairhg6kuvdulm', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhge00n9irhgrihl14pl', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rh7z00dgirhglwkv1seb', 'cmmq0rhg500mtirhgfhyszxxw', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhh400nvirhg3myq03m9', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6700a8irhgd2uu8exz', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhh500nxirhgjcft85zb', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6900adirhgukyvjdr9', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhh600nzirhgshvimfin', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6c00amirhg8ngntu43', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhh700o1irhg7yjls426', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6e00arirhgwavbt8i6', 'cmmq0rhgu00ntirhgga2uzh68', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhj00ohirhg3o7ikqky', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9s00exirhg4buxurda', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhl00ojirhgn31l8tsq', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9u00f2irhguwp5rqy4', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhm00olirhgowylvynu', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh9y00fdirhgp57ffgwi', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhn00onirhgslavywy3', 'cmmq0rh28000sirhg8quemref', 'cmmq0rha200fjirhg5panakde', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhho00opirhgqz5kk3zx', 'cmmq0rh28000sirhg8quemref', 'cmmq0rha700fuirhg7m7jynt7', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhq00orirhg93zxk08p', 'cmmq0rh28000sirhg8quemref', 'cmmq0rha900fzirhged9eeo3t', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhr00otirhgthktd5eu', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhad00gairhgxp5swvdj', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhs00ovirhgx5otu616', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhaf00gfirhgayi98fse', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhht00oxirhgeeeepcdy', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhal00gqirhgzspuocv4', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhu00ozirhgy6wrkrvi', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhan00gvirhgm318dfxx', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhw00p1irhg9jjbaiy5', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhas00h6irhgchhe2vxs', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhhx00p3irhgiy6ras51', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhau00hbirhgayzpmksb', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi100p5irhgaf00hymb', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhay00hmirhgufb3yvmn', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi300p7irhghmmxl96s', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhb100hsirhgnshj2dg3', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi400p9irhg0mcdhs54', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhb700i3irhg0so8v7vy', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhi500pbirhgci0ifuv4', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhb900i9irhg480rxbn4', 'cmmq0rhhg00ofirhggfeo0imc', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhiy00qhirhg99zas8b4', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh5v009lirhgj3w89ybi', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj000qjirhg8y9elsu8', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh5y009qirhg6cns25cv', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj100qlirhg4dpq44lf', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh6y00bzirhgj3fp6z96', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj200qnirhgx5ajz5uc', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7000c4irhgakifz9kc', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj300qpirhg0nxpku8y', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7400cfirhg59u6ev9w', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj500qrirhgunyzaox4', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7500ckirhg93ydcom9', 'cmmq0rhix00qfirhg6abdirre', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhj600qtirhgm6gh6s0d', 'cmmq0rh28000sirhg8quemref', 'cmmq0rh7800coirhgfefwp0p2', 'cmmq0rhix00qfirhg6abdirre', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjm00rhirhg1w0r9npi', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6700a8irhgd2uu8exz', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjn00rjirhgq5fdnc7p', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6900adirhgukyvjdr9', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjo00rlirhgju91hcee', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6c00amirhg8ngntu43', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhjp00rnirhgbu9yy0ky', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rh6e00arirhgwavbt8i6', 'cmmq0rhjl00rfirhgedv7jg40', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk200s3irhgjsrtxd3i', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcd00irirhgc7g3r0rx', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk400s5irhg2gy4rxak', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhch00iwirhgyk8w5jiv', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk500s7irhgk0hw8o1y', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcm00j7irhgh3z62u9e', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk600s9irhgrr8fe92q', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhco00jcirhgrudda1nl', 'cmmq0rhk100s1irhgsyrr5imi', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk700sbirhg9yd30isi', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcs00jnirhgwcpvimar', 'cmmq0rhk100s1irhgsyrr5imi', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhk800sdirhgvgt5toa5', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcu00jsirhg9a53m58p', 'cmmq0rhk100s1irhgsyrr5imi', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkb00sfirhghj3hu367', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhcy00jwirhghpz7gv8l', 'cmmq0rhk100s1irhgsyrr5imi', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhko00t1irhg3mmc5ykm', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhdy00k2irhgg3l7xijx', 'cmmq0rhkn00szirhg350704vm', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhkr00t3irhga4kgkp0t', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhe200k9irhghazyak8s', 'cmmq0rhkn00szirhg350704vm', 100, 1, '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO lesson_progress (`id`, `user_id`, `lesson_id`, `enrollment_id`, `watched_percent`, `is_completed`, `completed_at`, `last_visited_at`, `created_at`, `updated_at`) VALUES ('cmmq0rhks00t5irhg7z1u9nvb', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhe500kfirhg7mut1h49', 'cmmq0rhkn00szirhg350704vm', 0, 0, NULL, NULL, '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhek00kvirhgt4ed9joo', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhec00kjirhgp8h3lws8', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhem00kzirhgteyl2qym', 'cmmq0rh6a00aeirhglkydgepl', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhec00kjirhgp8h3lws8', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhen00l1irhg8xesn200', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhec00kjirhgp8h3lws8', 'SUBMITTED', 18, 22, 82.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhfi00m5irhgbmttbv8w', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhev00l5irhg45yvp775', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhfp00m9irhgd4zm2u9f', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhev00l5irhg45yvp775', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhfs00mdirhgpjg99nux', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhev00l5irhg45yvp775', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhfz00mpirhgdp22yhaf', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhev00l5irhg45yvp775', 'SUBMITTED', 11, 22, 50.0, 0, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhgg00ndirhgexzo6fkm', 'cmmq0rh6l00b2irhg26fygdly', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhg500mtirhgfhyszxxw', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhgi00nhirhghjtqdlo2', 'cmmq0rh6r00biirhgpmjvyesv', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhg500mtirhgfhyszxxw', 'SUBMITTED', 2, 5, 40.0, 0, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhgq00npirhgivx6jevv', 'cmmq0rh4v005lirhgl81opbfj', 'cmmq0rh26000qirhg5v3pco2h', 'cmmq0rhg500mtirhgfhyszxxw', 'SUBMITTED', 11, 22, 50.0, 0, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhh900o5irhgvf44cp87', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhgu00ntirhgga2uzh68', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhhb00o9irhgbxtoi7lt', 'cmmq0rh6a00aeirhglkydgepl', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhgu00ntirhgga2uzh68', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhhc00obirhgyt725sxu', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhgu00ntirhgga2uzh68', 'SUBMITTED', 18, 22, 82.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhi700pfirhgso4vdirl', 'cmmq0rh9o00enirhgvs72xcg4', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhia00pjirhgp545chtt', 'cmmq0rh9w00f3irhg9wzttzhd', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhic00pnirhgg9glwffm', 'cmmq0rha400fkirhge4xb0b4x', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhig00prirhggnhkqt4k', 'cmmq0rhaa00g0irhgvy14yxks', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhij00pvirhgvws7twpd', 'cmmq0rhah00ggirhg7mbj3v7k', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhil00pzirhg3akmi10x', 'cmmq0rhap00gwirhg1bepww7j', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhin00q3irhgsjoxzy3j', 'cmmq0rhav00hcirhgdey79qsv', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhip00q7irhgkrm901re', 'cmmq0rhb300htirhgnd4teoa4', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhiq00q9irhgpajlbaoo', 'cmmq0rh4v005firhg3pxnw9mx', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhhg00ofirhggfeo0imc', 'SUBMITTED', 18, 22, 82.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhj800qxirhgg96o9g9j', 'cmmq0rh5s009birhgxrg9mhsk', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhix00qfirhg6abdirre', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhja00r1irhg70jgp2o6', 'cmmq0rh60009rirhg3l4q41c5', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhix00qfirhg6abdirre', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhje00r5irhghxttgyks', 'cmmq0rh7100c5irhgtw77m3dp', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhix00qfirhg6abdirre', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhjg00r9irhg60cwwucp', 'cmmq0rh4w005nirhgflro31nj', 'cmmq0rh28000sirhg8quemref', 'cmmq0rhix00qfirhg6abdirre', 'SUBMITTED', 18, 22, 82.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhjr00rrirhg1bdxlnnt', 'cmmq0rh6400a0irhgnohr1g44', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhjl00rfirhgedv7jg40', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhjw00rvirhgkpmaba5u', 'cmmq0rh6a00aeirhglkydgepl', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhjl00rfirhgedv7jg40', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhjx00rxirhgebipfqqv', 'cmmq0rh4v005dirhgzq0u16m7', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhjl00rfirhgedv7jg40', 'SUBMITTED', 18, 22, 82.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhke00sjirhgxtagtz70', 'cmmq0rhca00ihirhg11f5wxsk', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhk100s1irhgsyrr5imi', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhkg00snirhgdr39q7zv', 'cmmq0rhcj00ixirhgut6ghsvv', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhk100s1irhgsyrr5imi', 'SUBMITTED', 4, 5, 80.0, 1, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO attempts (`id`, `quiz_id`, `user_id`, `enrollment_id`, `status`, `score`, `max_score`, `percentage`, `passed`, `answers_json`, `started_at`, `submitted_at`) VALUES ('cmmq0rhkj00stirhggw1t5fo2', 'cmmq0rh4x007uirhgyvoodiux', 'cmmq0rh2b000uirhghbj4y00i', 'cmmq0rhk100s1irhgsyrr5imi', 'SUBMITTED', 11, 22, 50.0, 0, '{}', '2026-03-14 07:43:44', '2026-03-14 07:43:44');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmq0rhit00qdirhg8x96isli', 'cmmq0rhhg00ofirhggfeo0imc', 'cmmq0rh25000oirhgeovr0ni1', 'RECOMMEND_ACCESS', 'Итоговый тест сдан уверенно. Рекомендован к выдаче доступа в amoCRM.', '2026-03-14 07:43:44');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmq0rhjj00rdirhg7vadu6jn', 'cmmq0rhix00qfirhg6abdirre', 'cmmq0rh25000oirhgeovr0ni1', 'RECOMMEND_ACCESS', 'Хорошо прошел ролевой курс. Можно использовать как демо успешного кейса.', '2026-03-14 07:43:44');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmq0rhkl00sxirhggu2msnpi', 'cmmq0rhk100s1irhgsyrr5imi', 'cmmq0rh25000oirhgeovr0ni1', 'REPEAT_TRAINING', 'Слабая работа по пересечениям и фиксации агента. Отправлен на повторное обучение.', '2026-03-14 07:43:44');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmqa4spa0005ircclgu2whcg', 'cmmq0rhhg00ofirhggfeo0imc', 'cmmq0rh25000oirhgeovr0ni1', 'RECOMMEND_ACCESS', '', '2026-03-14 12:06:02');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmqa5253000pirccw19hqldx', 'cmmq0rhix00qfirhg6abdirre', 'cmmq0rh25000oirhgeovr0ni1', 'REPEAT_TRAINING', '', '2026-03-14 12:06:14');

INSERT INTO supervisor_decisions (`id`, `enrollment_id`, `leader_id`, `decision`, `comment`, `created_at`) VALUES ('cmmqa569y0011irccx6ona057', 'cmmq0rhix00qfirhg6abdirre', 'cmmq0rh25000oirhgeovr0ni1', 'RETRAIN', '', '2026-03-14 12:06:19');

INSERT INTO notifications (`id`, `user_id`, `title`, `body`, `link`, `type`, `read_at`, `created_at`) VALUES ('cmmq0rhky00teirhgxdmnj7lw', 'cmmq0rh26000qirhg5v3pco2h', 'Продолжите базовый курс по amoCRM', 'У вас есть незавершенные модули по задачам и фиксации коммуникаций.', '/student', 'ACTION', NULL, '2026-03-14 07:43:44');

INSERT INTO notifications (`id`, `user_id`, `title`, `body`, `link`, `type`, `read_at`, `created_at`) VALUES ('cmmq0rhky00tfirhghryd6wj4', 'cmmq0rh28000sirhg8quemref', 'Рекомендация к выдаче доступа', 'Руководитель подтвердил успешное прохождение демо-курса.', '/leader', 'RESULT', NULL, '2026-03-14 07:43:44');

INSERT INTO notifications (`id`, `user_id`, `title`, `body`, `link`, `type`, `read_at`, `created_at`) VALUES ('cmmq0rhky00tgirhg6k8j9cw2', 'cmmq0rh2b000uirhghbj4y00i', 'Назначено повторное обучение', 'Руководитель отправил вас на повторный разбор пересечений и партнерской фиксации.', '/student', 'WARNING', NULL, '2026-03-14 07:43:44');

INSERT INTO notifications (`id`, `user_id`, `title`, `body`, `link`, `type`, `read_at`, `created_at`) VALUES ('cmmq0rhky00thirhg58hmcids', 'cmmq0rh25000oirhgeovr0ni1', 'Команда готова к демонстрации', 'В демо-данных есть сотрудник в процессе, успешный кейс и кейс повторного обучения.', '/leader', 'INFO', NULL, '2026-03-14 07:43:44');

INSERT INTO platform_settings (id, `key`, `value`, description, created_at, updated_at) VALUES
('setting-app-name', 'app_name', 'СтройТех', 'Название платформы', NOW(), NOW()),
('setting-subtitle', 'app_subtitle', 'Сервис обучения сотрудников ЮСИ по amoCRM, Allio и внутренним регламентам', 'Подзаголовок платформы', NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
