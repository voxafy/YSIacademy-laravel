SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS audit_logs;
DROP TABLE IF EXISTS platform_settings;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS supervisor_decisions;
DROP TABLE IF EXISTS attempts;
DROP TABLE IF EXISTS lesson_progress;
DROP TABLE IF EXISTS module_progress;
DROP TABLE IF EXISTS progress;
DROP TABLE IF EXISTS enrollments;
DROP TABLE IF EXISTS quiz_questions;
DROP TABLE IF EXISTS answer_options;
DROP TABLE IF EXISTS questions;
DROP TABLE IF EXISTS quizzes;
DROP TABLE IF EXISTS lesson_attachments;
DROP TABLE IF EXISTS lesson_videos;
DROP TABLE IF EXISTS media_assets;
DROP TABLE IF EXISTS lesson_blocks;
DROP TABLE IF EXISTS lessons;
DROP TABLE IF EXISTS modules;
DROP TABLE IF EXISTS course_departments;
DROP TABLE IF EXISTS course_cities;
DROP TABLE IF EXISTS courses;
DROP TABLE IF EXISTS course_categories;
DROP TABLE IF EXISTS auth_sessions;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS departments;
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS companies;
DROP TABLE IF EXISTS roles;

CREATE TABLE roles (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    `key` VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE companies (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    name VARCHAR(190) NOT NULL UNIQUE,
    slug VARCHAR(190) NOT NULL UNIQUE,
    subtitle VARCHAR(255) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cities (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    name VARCHAR(190) NOT NULL UNIQUE,
    slug VARCHAR(190) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE departments (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    name VARCHAR(190) NOT NULL UNIQUE,
    slug VARCHAR(190) NOT NULL UNIQUE,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE users (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    email VARCHAR(190) NOT NULL UNIQUE,
    full_name VARCHAR(190) NOT NULL,
    phone VARCHAR(50) NULL,
    title VARCHAR(190) NULL,
    password_hash VARCHAR(255) NOT NULL,
    approval_status ENUM('ACTIVE', 'PENDING', 'SUSPENDED') NOT NULL DEFAULT 'ACTIVE',
    role_id VARCHAR(36) NOT NULL,
    company_id VARCHAR(36) NULL,
    city_id VARCHAR(36) NULL,
    department_id VARCHAR(36) NULL,
    supervisor_id VARCHAR(36) NULL,
    bio TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id),
    CONSTRAINT fk_users_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL,
    CONSTRAINT fk_users_city FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE SET NULL,
    CONSTRAINT fk_users_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL,
    CONSTRAINT fk_users_supervisor FOREIGN KEY (supervisor_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_users_role (role_id),
    INDEX idx_users_supervisor (supervisor_id),
    INDEX idx_users_city (city_id),
    INDEX idx_users_department (department_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE auth_sessions (
    session_id VARCHAR(128) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    user_agent VARCHAR(500) NULL,
    ip_address VARCHAR(64) NULL,
    last_activity_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_auth_sessions_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_auth_sessions_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE course_categories (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    slug VARCHAR(190) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE courses (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    slug VARCHAR(190) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255) NULL,
    short_description TEXT NULL,
    description LONGTEXT NOT NULL,
    hero_title VARCHAR(255) NULL,
    hero_description TEXT NULL,
    target_audience VARCHAR(255) NULL,
    accent_color VARCHAR(20) NULL,
    dark_accent_color VARCHAR(20) NULL,
    status ENUM('DRAFT', 'PUBLISHED', 'TEMPLATE', 'ARCHIVED') NOT NULL DEFAULT 'DRAFT',
    is_template TINYINT(1) NOT NULL DEFAULT 0,
    estimated_minutes INT NULL,
    pass_score INT NOT NULL DEFAULT 70,
    category_id VARCHAR(36) NOT NULL,
    company_id VARCHAR(36) NULL,
    created_by_id VARCHAR(36) NULL,
    cover_asset_id VARCHAR(36) NULL,
    final_quiz_id VARCHAR(36) NULL,
    template_source_id VARCHAR(36) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_courses_category FOREIGN KEY (category_id) REFERENCES course_categories(id),
    CONSTRAINT fk_courses_company FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE SET NULL,
    CONSTRAINT fk_courses_creator FOREIGN KEY (created_by_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_courses_category (category_id),
    INDEX idx_courses_company (company_id),
    INDEX idx_courses_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE course_cities (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    course_id VARCHAR(36) NOT NULL,
    city_id VARCHAR(36) NOT NULL,
    CONSTRAINT fk_course_cities_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_course_cities_city FOREIGN KEY (city_id) REFERENCES cities(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_course_city (course_id, city_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE course_departments (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    course_id VARCHAR(36) NOT NULL,
    department_id VARCHAR(36) NOT NULL,
    CONSTRAINT fk_course_departments_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_course_departments_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_course_department (course_id, department_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quizzes (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    scope ENUM('MODULE', 'FINAL', 'LESSON') NOT NULL,
    pass_score INT NOT NULL DEFAULT 70,
    max_attempts INT NULL,
    shuffle_questions TINYINT(1) NOT NULL DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modules (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    course_id VARCHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    summary TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    estimated_minutes INT NULL,
    pass_score INT NOT NULL DEFAULT 70,
    is_published TINYINT(1) NOT NULL DEFAULT 1,
    quiz_id VARCHAR(36) NULL UNIQUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_modules_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_modules_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE SET NULL,
    INDEX idx_modules_course (course_id),
    INDEX idx_modules_order (course_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lessons (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    module_id VARCHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(190) NOT NULL,
    description TEXT NOT NULL,
    summary TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    lesson_type ENUM('TEXT', 'VIDEO', 'MIXED', 'QUIZ') NOT NULL,
    estimated_minutes INT NULL,
    is_required TINYINT(1) NOT NULL DEFAULT 1,
    quiz_id VARCHAR(36) NULL UNIQUE,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_lessons_module FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
    CONSTRAINT fk_lessons_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE SET NULL,
    UNIQUE KEY uniq_module_slug (module_id, slug),
    INDEX idx_lessons_order (module_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lesson_blocks (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    lesson_id VARCHAR(36) NOT NULL,
    block_type ENUM('RICH_TEXT', 'RULES', 'MISTAKES', 'CALLOUT', 'CHECKLIST', 'FILES') NOT NULL,
    title VARCHAR(255) NULL,
    body LONGTEXT NULL,
    payload LONGTEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_lesson_blocks_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    INDEX idx_lesson_blocks_order (lesson_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE media_assets (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    kind ENUM('IMAGE', 'VIDEO', 'DOCUMENT', 'COVER') NOT NULL,
    title VARCHAR(255) NULL,
    original_name VARCHAR(255) NOT NULL,
    file_name VARCHAR(255) NOT NULL,
    mime_type VARCHAR(255) NOT NULL,
    size_bytes INT NOT NULL,
    duration_sec INT NULL,
    width INT NULL,
    height INT NULL,
    storage_provider ENUM('LOCAL', 'MINIO') NOT NULL DEFAULT 'LOCAL',
    storage_path VARCHAR(255) NOT NULL,
    public_url VARCHAR(255) NULL,
    bucket VARCHAR(255) NULL,
    metadata_json LONGTEXT NULL,
    uploaded_by_id VARCHAR(36) NULL,
    course_id VARCHAR(36) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_media_assets_user FOREIGN KEY (uploaded_by_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_media_assets_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    INDEX idx_media_kind (kind),
    INDEX idx_media_course (course_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE courses
    ADD CONSTRAINT fk_courses_cover_asset FOREIGN KEY (cover_asset_id) REFERENCES media_assets(id) ON DELETE SET NULL,
    ADD CONSTRAINT fk_courses_final_quiz FOREIGN KEY (final_quiz_id) REFERENCES quizzes(id) ON DELETE SET NULL,
    ADD CONSTRAINT fk_courses_template_source FOREIGN KEY (template_source_id) REFERENCES courses(id) ON DELETE SET NULL;

CREATE TABLE lesson_videos (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    lesson_id VARCHAR(36) NOT NULL UNIQUE,
    media_asset_id VARCHAR(36) NOT NULL UNIQUE,
    caption VARCHAR(255) NULL,
    CONSTRAINT fk_lesson_videos_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_lesson_videos_asset FOREIGN KEY (media_asset_id) REFERENCES media_assets(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lesson_attachments (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    lesson_id VARCHAR(36) NOT NULL,
    asset_id VARCHAR(36) NOT NULL,
    label VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_lesson_attachments_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_lesson_attachments_asset FOREIGN KEY (asset_id) REFERENCES media_assets(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_lesson_asset (lesson_id, asset_id),
    INDEX idx_lesson_attachments_order (lesson_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE questions (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    topic VARCHAR(190) NULL,
    prompt LONGTEXT NOT NULL,
    question_type ENUM('SINGLE', 'MULTIPLE', 'BOOLEAN', 'MATCHING', 'CASE') NOT NULL,
    explanation LONGTEXT NULL,
    difficulty INT NULL,
    meta_json LONGTEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE answer_options (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    question_id VARCHAR(36) NOT NULL,
    label LONGTEXT NOT NULL,
    is_correct TINYINT(1) NOT NULL DEFAULT 0,
    match_key VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    CONSTRAINT fk_answer_options_question FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    INDEX idx_answer_options_order (question_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE quiz_questions (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    quiz_id VARCHAR(36) NOT NULL,
    question_id VARCHAR(36) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    points INT NOT NULL DEFAULT 1,
    CONSTRAINT fk_quiz_questions_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    CONSTRAINT fk_quiz_questions_question FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_quiz_question (quiz_id, question_id),
    INDEX idx_quiz_questions_order (quiz_id, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE enrollments (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    course_id VARCHAR(36) NOT NULL,
    assigned_by_id VARCHAR(36) NULL,
    status ENUM('NOT_STARTED', 'IN_PROGRESS', 'FAILED', 'COMPLETED', 'SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS', 'REPEAT_TRAINING') NOT NULL DEFAULT 'NOT_STARTED',
    assigned_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    started_at DATETIME NULL,
    completed_at DATETIME NULL,
    due_at DATETIME NULL,
    CONSTRAINT fk_enrollments_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_enrollments_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_enrollments_assigner FOREIGN KEY (assigned_by_id) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE KEY uniq_enrollment (user_id, course_id),
    INDEX idx_enrollments_status (status),
    INDEX idx_enrollments_assigned_at (assigned_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE progress (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    course_id VARCHAR(36) NOT NULL,
    enrollment_id VARCHAR(36) NOT NULL UNIQUE,
    completion_percent INT NOT NULL DEFAULT 0,
    lessons_completed INT NOT NULL DEFAULT 0,
    lessons_total INT NOT NULL DEFAULT 0,
    modules_completed INT NOT NULL DEFAULT 0,
    modules_total INT NOT NULL DEFAULT 0,
    status ENUM('NOT_STARTED', 'IN_PROGRESS', 'FAILED', 'COMPLETED', 'SENT_TO_REVIEW', 'RECOMMENDED_FOR_ACCESS', 'REPEAT_TRAINING') NOT NULL DEFAULT 'NOT_STARTED',
    last_lesson_id VARCHAR(36) NULL,
    last_activity_at DATETIME NULL,
    completed_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_progress_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_progress_course FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
    CONSTRAINT fk_progress_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    CONSTRAINT fk_progress_last_lesson FOREIGN KEY (last_lesson_id) REFERENCES lessons(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE module_progress (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    module_id VARCHAR(36) NOT NULL,
    enrollment_id VARCHAR(36) NOT NULL,
    completion_percent INT NOT NULL DEFAULT 0,
    quiz_passed TINYINT(1) NOT NULL DEFAULT 0,
    completed_at DATETIME NULL,
    last_activity_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_module_progress_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_module_progress_module FOREIGN KEY (module_id) REFERENCES modules(id) ON DELETE CASCADE,
    CONSTRAINT fk_module_progress_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_module_progress (user_id, module_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE lesson_progress (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    lesson_id VARCHAR(36) NOT NULL,
    enrollment_id VARCHAR(36) NOT NULL,
    watched_percent INT NOT NULL DEFAULT 0,
    is_completed TINYINT(1) NOT NULL DEFAULT 0,
    completed_at DATETIME NULL,
    last_visited_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_lesson_progress_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_lesson_progress_lesson FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE,
    CONSTRAINT fk_lesson_progress_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    UNIQUE KEY uniq_lesson_progress (user_id, lesson_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE attempts (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    quiz_id VARCHAR(36) NOT NULL,
    user_id VARCHAR(36) NOT NULL,
    enrollment_id VARCHAR(36) NULL,
    status ENUM('IN_PROGRESS', 'SUBMITTED') NOT NULL DEFAULT 'SUBMITTED',
    score INT NOT NULL DEFAULT 0,
    max_score INT NOT NULL DEFAULT 0,
    percentage DECIMAL(5,2) NOT NULL DEFAULT 0,
    passed TINYINT(1) NOT NULL DEFAULT 0,
    answers_json LONGTEXT NULL,
    started_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    submitted_at DATETIME NULL,
    CONSTRAINT fk_attempts_quiz FOREIGN KEY (quiz_id) REFERENCES quizzes(id) ON DELETE CASCADE,
    CONSTRAINT fk_attempts_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_attempts_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE SET NULL,
    INDEX idx_attempts_quiz (quiz_id),
    INDEX idx_attempts_enrollment (enrollment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE supervisor_decisions (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    enrollment_id VARCHAR(36) NOT NULL,
    leader_id VARCHAR(36) NOT NULL,
    decision ENUM('RECOMMEND_ACCESS', 'RETRAIN', 'REPEAT_TRAINING') NOT NULL,
    comment TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_supervisor_decisions_enrollment FOREIGN KEY (enrollment_id) REFERENCES enrollments(id) ON DELETE CASCADE,
    CONSTRAINT fk_supervisor_decisions_leader FOREIGN KEY (leader_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_supervisor_decisions_enrollment (enrollment_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE notifications (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NOT NULL,
    title VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    link VARCHAR(255) NULL,
    type ENUM('INFO', 'WARNING', 'ACTION', 'RESULT') NOT NULL DEFAULT 'INFO',
    read_at DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_notifications_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_notifications_user (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE platform_settings (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    `key` VARCHAR(190) NOT NULL UNIQUE,
    `value` LONGTEXT NULL,
    description TEXT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE audit_logs (
    id VARCHAR(36) NOT NULL PRIMARY KEY,
    user_id VARCHAR(36) NULL,
    action VARCHAR(190) NOT NULL,
    entity_type VARCHAR(190) NULL,
    entity_id VARCHAR(36) NULL,
    payload_json LONGTEXT NULL,
    ip_address VARCHAR(64) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_audit_logs_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_audit_logs_entity (entity_type, entity_id),
    INDEX idx_audit_logs_action (action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
