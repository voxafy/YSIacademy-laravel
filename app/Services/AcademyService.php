<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\LegacyDb;
use RuntimeException;

final class AcademyService
{
    public function __construct(
        private readonly LegacyDb $db,
    ) {
    }

    /**
     * @return array{cities: array<int, array<string, mixed>>, departments: array<int, array<string, mixed>>, supervisors: array<int, array<string, mixed>>}
     */
    public function getPlatformOptions(): array
    {
        return [
            'cities' => $this->db->fetchAll('SELECT * FROM cities ORDER BY name ASC'),
            'departments' => $this->db->fetchAll('SELECT * FROM departments ORDER BY name ASC'),
            'supervisors' => $this->db->fetchAll(
                "SELECT u.id, u.full_name 
                 FROM users u 
                 INNER JOIN roles r ON r.id = u.role_id 
                 WHERE r.`key` = 'LEADER'
                 ORDER BY u.full_name ASC"
            ),
        ];
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<int, array<string, mixed>>
     */
    public function getPublishedCourses(?array $user = null): array
    {
        $params = [];
        $where = [
            "c.status = 'PUBLISHED'",
            'COALESCE(c.is_template, 0) = 0',
        ];

        if ($user !== null && ($user['role_key'] ?? '') === 'STUDENT') {
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id) OR EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id AND cc.city_id = ?))';
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id) OR EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id AND cd.department_id = ?))';
            $params[] = $user['city_id'] ?? '';
            $params[] = $user['department_id'] ?? '';
        }

        $courses = $this->db->fetchAll(
            'SELECT c.*, cc.title AS category_title, cc.slug AS category_slug
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             WHERE ' . implode(' AND ', $where) . '
             ORDER BY cc.sort_order ASC, c.title ASC',
            $params,
        );

        if ($courses === []) {
            return [];
        }

        $courseIds = array_column($courses, 'id');
        $modules = $this->db->fetchAll(
            sprintf(
                'SELECT m.*, COALESCE(lesson_counts.lessons_count, 0) AS lessons_count
                 FROM modules m
                 LEFT JOIN (
                    SELECT l.module_id, COUNT(l.id) AS lessons_count
                    FROM lessons l
                    GROUP BY l.module_id
                 ) AS lesson_counts ON lesson_counts.module_id = m.id
                 WHERE m.course_id IN (%s)
                 ORDER BY m.sort_order ASC',
                $this->placeholders(count($courseIds)),
            ),
            $courseIds,
        );

        $moduleGroups = $this->groupBy($modules, 'course_id');
        $enrollmentMap = [];

        if ($user !== null && isset($user['id'])) {
            $enrollments = $this->db->fetchAll(
                sprintf(
                    "SELECT e.*, p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
                     FROM enrollments e
                     LEFT JOIN progress p ON p.enrollment_id = e.id
                     WHERE e.user_id = ? AND e.course_id IN (%s)",
                    $this->placeholders(count($courseIds)),
                ),
                array_merge([(string) $user['id']], $courseIds),
            );

            foreach ($enrollments as $enrollment) {
                $enrollmentMap[(string) $enrollment['course_id']] = $enrollment;
            }
        }

        foreach ($courses as &$course) {
            $course['category'] = [
                'title' => $course['category_title'],
                'slug' => $course['category_slug'],
            ];
            $course['modules'] = $moduleGroups[(string) $course['id']] ?? [];
            $course['enrollment'] = $enrollmentMap[(string) $course['id']] ?? null;
        }
        unset($course);

        return $courses;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCourseBySlugForUser(string $slug, ?string $userId = null): array
    {
        $course = $this->db->fetchOne(
            'SELECT c.*, cc.title AS category_title, cc.slug AS category_slug
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             WHERE c.slug = ?
             LIMIT 1',
            [$slug],
        );

        if ($course === null) {
            throw new RuntimeException('Course not found.');
        }

        $modules = $this->db->fetchAll(
            'SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
            [$course['id']],
        );
        $moduleIds = array_column($modules, 'id');
        $lessons = $moduleIds === []
            ? []
            : $this->db->fetchAll(
                sprintf(
                    'SELECT * FROM lessons WHERE module_id IN (%s) ORDER BY sort_order ASC',
                    $this->placeholders(count($moduleIds)),
                ),
                $moduleIds,
            );

        $lessonGroups = $this->groupBy($lessons, 'module_id');
        foreach ($modules as &$module) {
            $module['lessons'] = $lessonGroups[(string) $module['id']] ?? [];
        }
        unset($module);

        $course['category'] = [
            'title' => $course['category_title'],
            'slug' => $course['category_slug'],
        ];
        $course['modules'] = $modules;
        $course['enrollment'] = null;

        if ($userId !== null) {
            $enrollment = $this->db->fetchOne(
                'SELECT e.*, p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total,
                        p.status AS progress_status, p.last_lesson_id, p.last_activity_at, p.completed_at AS progress_completed_at
                 FROM enrollments e
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ? AND e.course_id = ?
                 LIMIT 1',
                [$userId, $course['id']],
            );

            if ($enrollment !== null) {
                $moduleProgress = $this->db->fetchAll(
                    'SELECT * FROM module_progress WHERE enrollment_id = ?',
                    [$enrollment['id']],
                );
                $lessonProgress = $this->db->fetchAll(
                    'SELECT * FROM lesson_progress WHERE enrollment_id = ?',
                    [$enrollment['id']],
                );
                $latestDecision = $this->db->fetchOne(
                    'SELECT sd.*, u.full_name AS leader_name
                     FROM supervisor_decisions sd
                     INNER JOIN users u ON u.id = sd.leader_id
                     WHERE sd.enrollment_id = ?
                     ORDER BY sd.created_at DESC
                     LIMIT 1',
                    [$enrollment['id']],
                );

                $enrollment['module_progress'] = $moduleProgress;
                $enrollment['lesson_progress'] = $lessonProgress;
                $enrollment['latest_decision'] = $latestDecision;
                $course['enrollment'] = $enrollment;
            }
        }

        return $course;
    }

    /**
     * @return array{course: array<string,mixed>, lesson: array<string,mixed>}|null
     */
    public function getLessonView(string $slug, string $lessonId, ?string $userId = null): ?array
    {
        $course = $this->getCourseBySlugForUser($slug, $userId);
        $lesson = null;

        foreach ($course['modules'] as $module) {
            foreach ($module['lessons'] as $moduleLesson) {
                if ($moduleLesson['id'] === $lessonId) {
                    $lesson = $moduleLesson;
                    break 2;
                }
            }
        }

        if ($lesson === null) {
            return null;
        }

        $fullLesson = $this->db->fetchOne(
            'SELECT l.*, m.title AS module_title, m.course_id, c.title AS course_title
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             WHERE l.id = ?
             LIMIT 1',
            [$lessonId],
        );

        if ($fullLesson === null) {
            return null;
        }

        $blocks = $this->db->fetchAll(
            'SELECT * FROM lesson_blocks WHERE lesson_id = ? ORDER BY sort_order ASC',
            [$lessonId],
        );

        $video = $this->db->fetchOne(
            'SELECT lv.*, ma.id AS asset_id, ma.original_name, ma.size_bytes, ma.duration_sec, ma.mime_type, ma.public_url
             FROM lesson_videos lv
             INNER JOIN media_assets ma ON ma.id = lv.media_asset_id
             WHERE lv.lesson_id = ?
             LIMIT 1',
            [$lessonId],
        );

        $attachments = $this->db->fetchAll(
            'SELECT la.*, ma.id AS asset_id, ma.original_name, ma.mime_type, ma.public_url, ma.size_bytes
             FROM lesson_attachments la
             INNER JOIN media_assets ma ON ma.id = la.asset_id
             WHERE la.lesson_id = ?
             ORDER BY la.sort_order ASC',
            [$lessonId],
        );

        $quiz = null;
        if (!empty($fullLesson['quiz_id'])) {
            $quiz = $this->getQuizById((string) $fullLesson['quiz_id']);
        }

        $fullLesson['blocks'] = $blocks;
        $fullLesson['video'] = $video;
        $fullLesson['attachments'] = $attachments;
        $fullLesson['quiz'] = $quiz;

        return [
            'course' => $course,
            'lesson' => $fullLesson,
        ];
    }

    /**
     * @param array<string, mixed>|null $user
     * @param array<string, mixed> $filters
     * @return array<string, mixed>
     */
    public function getKnowledgeBaseIndex(?array $user, array $filters = []): array
    {
        $scopes = $this->knowledgeVisibilityScopes($user);
        $allowedTypes = ['DOCUMENT', 'INSTRUCTION', 'RULE', 'FAQ'];
        $query = trim((string) ($filters['q'] ?? ''));
        $type = strtoupper(trim((string) ($filters['type'] ?? '')));
        $category = trim((string) ($filters['category'] ?? ''));

        if (!in_array($type, $allowedTypes, true)) {
            $type = '';
        }

        $categoryRows = $this->db->fetchAll(
            sprintf(
                "SELECT kc.id,
                        kc.slug,
                        kc.title,
                        kc.description,
                        kc.accent_color,
                        kc.sort_order,
                        COUNT(ka.id) AS articles_count
                 FROM knowledge_categories kc
                 LEFT JOIN knowledge_articles ka
                    ON ka.category_id = kc.id
                   AND ka.status = 'PUBLISHED'
                   AND ka.visibility_scope IN (%s)
                 GROUP BY kc.id, kc.slug, kc.title, kc.description, kc.accent_color, kc.sort_order
                 ORDER BY kc.sort_order ASC, kc.title ASC",
                $this->placeholders(count($scopes)),
            ),
            $scopes,
        );

        $typeRows = $this->db->fetchAll(
            sprintf(
                "SELECT article_type, COUNT(*) AS total
                 FROM knowledge_articles
                 WHERE status = 'PUBLISHED'
                   AND visibility_scope IN (%s)
                 GROUP BY article_type",
                $this->placeholders(count($scopes)),
            ),
            $scopes,
        );

        $typeMap = [];
        foreach ($typeRows as $row) {
            $typeMap[(string) $row['article_type']] = (int) $row['total'];
        }

        $categoryRows = array_values(array_filter(
            $categoryRows,
            static fn (array $row): bool => (int) ($row['articles_count'] ?? 0) > 0,
        ));

        $where = ["ka.status = 'PUBLISHED'", sprintf('ka.visibility_scope IN (%s)', $this->placeholders(count($scopes)))];
        $params = $scopes;

        if ($query !== '') {
            $where[] = '(ka.title LIKE ? OR ka.excerpt LIKE ? OR ka.body LIKE ? OR ka.search_keywords LIKE ?)';
            $needle = '%' . $query . '%';
            array_push($params, $needle, $needle, $needle, $needle);
        }

        if ($type !== '') {
            $where[] = 'ka.article_type = ?';
            $params[] = $type;
        }

        if ($category !== '') {
            $where[] = 'kc.slug = ?';
            $params[] = $category;
        }

        $articles = $this->db->fetchAll(
            'SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
             FROM knowledge_articles ka
             INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
             WHERE ' . implode(' AND ', $where) . '
             ORDER BY ka.is_featured DESC, kc.sort_order ASC, ka.sort_order ASC, ka.updated_at DESC',
            $params,
        );

        $featured = $this->db->fetchAll(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.status = 'PUBLISHED'
                   AND ka.is_featured = 1
                   AND ka.visibility_scope IN (%s)
                 ORDER BY ka.sort_order ASC, ka.updated_at DESC
                 LIMIT 4",
                $this->placeholders(count($scopes)),
            ),
            $scopes,
        );

        $faq = $this->db->fetchAll(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.status = 'PUBLISHED'
                   AND ka.article_type = 'FAQ'
                   AND ka.visibility_scope IN (%s)
                 ORDER BY ka.is_featured DESC, ka.sort_order ASC, ka.updated_at DESC
                 LIMIT 6",
                $this->placeholders(count($scopes)),
            ),
            $scopes,
        );

        return [
            'filters' => [
                'q' => $query,
                'type' => $type,
                'category' => $category,
            ],
            'categories' => array_map(
                static fn (array $row): array => array_merge($row, [
                    'articles_count' => (int) ($row['articles_count'] ?? 0),
                ]),
                $categoryRows,
            ),
            'types' => array_map(
                static fn (string $value): array => [
                    'value' => $value,
                    'label' => knowledge_article_type_label($value),
                    'count' => $typeMap[$value] ?? 0,
                ],
                $allowedTypes,
            ),
            'featured' => $this->hydrateKnowledgeArticles($featured),
            'faq' => $this->hydrateKnowledgeArticles($faq),
            'articles' => $this->hydrateKnowledgeArticles($articles),
            'totals' => [
                'articles_total' => array_sum(array_map(static fn (array $row): int => (int) ($row['articles_count'] ?? 0), $categoryRows)),
                'categories_total' => count($categoryRows),
                'faq_total' => $typeMap['FAQ'] ?? 0,
                'featured_total' => count($featured),
            ],
        ];
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<string, mixed>
     */
    public function getKnowledgeArticleBySlug(string $slug, ?array $user): array
    {
        $scopes = $this->knowledgeVisibilityScopes($user);

        $article = $this->db->fetchOne(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.slug = ?
                   AND ka.status = 'PUBLISHED'
                   AND ka.visibility_scope IN (%s)
                 LIMIT 1",
                $this->placeholders(count($scopes)),
            ),
            array_merge([$slug], $scopes),
        );

        if ($article === null) {
            throw new RuntimeException('Knowledge article not found.');
        }

        $related = $this->db->fetchAll(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.status = 'PUBLISHED'
                   AND ka.id <> ?
                   AND ka.category_id = ?
                   AND ka.visibility_scope IN (%s)
                 ORDER BY ka.is_featured DESC, ka.sort_order ASC, ka.updated_at DESC
                 LIMIT 5",
                $this->placeholders(count($scopes)),
            ),
            array_merge([(string) $article['id'], (string) $article['category_id']], $scopes),
        );

        $faq = $this->db->fetchAll(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.status = 'PUBLISHED'
                   AND ka.article_type = 'FAQ'
                   AND ka.id <> ?
                   AND ka.visibility_scope IN (%s)
                 ORDER BY ka.is_featured DESC, ka.sort_order ASC, ka.updated_at DESC
                 LIMIT 4",
                $this->placeholders(count($scopes)),
            ),
            array_merge([(string) $article['id']], $scopes),
        );

        $hydratedArticle = $this->hydrateKnowledgeArticles([$article]);

        return [
            'article' => $hydratedArticle[0],
            'related' => $this->hydrateKnowledgeArticles($related),
            'faq' => $this->hydrateKnowledgeArticles($faq),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getKnowledgeBaseAdminResources(): array
    {
        $categories = $this->db->fetchAll(
            "SELECT kc.id,
                    kc.slug,
                    kc.title,
                    kc.description,
                    kc.accent_color,
                    kc.sort_order,
                    COUNT(ka.id) AS articles_count,
                    SUM(CASE WHEN ka.status = 'PUBLISHED' THEN 1 ELSE 0 END) AS published_count,
                    MAX(ka.updated_at) AS last_article_at
             FROM knowledge_categories kc
             LEFT JOIN knowledge_articles ka ON ka.category_id = kc.id
             GROUP BY kc.id, kc.slug, kc.title, kc.description, kc.accent_color, kc.sort_order
             ORDER BY kc.sort_order ASC, kc.title ASC"
        );

        $articles = $this->db->fetchAll(
            'SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description,
                    kc.accent_color AS category_accent, u.full_name AS author_name
             FROM knowledge_articles ka
             INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
             LEFT JOIN users u ON u.id = ka.author_id
             ORDER BY ka.status = "PUBLISHED" DESC, kc.sort_order ASC, ka.sort_order ASC, ka.updated_at DESC'
        );

        $articleStats = $this->db->fetchOne(
            "SELECT
                COUNT(*) AS articles_total,
                SUM(CASE WHEN status = 'PUBLISHED' THEN 1 ELSE 0 END) AS published_total,
                SUM(CASE WHEN article_type = 'FAQ' THEN 1 ELSE 0 END) AS faq_total
             FROM knowledge_articles"
        ) ?? [];

        $lessonStats = $this->db->fetchOne(
            "SELECT COUNT(DISTINCT l.id) AS lesson_sources_total
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             WHERE c.status = 'PUBLISHED'
               AND m.is_published = 1"
        ) ?? [];

        return [
            'categories' => array_map(static function (array $row): array {
                $row['articles_count'] = (int) ($row['articles_count'] ?? 0);
                $row['published_count'] = (int) ($row['published_count'] ?? 0);

                return $row;
            }, $categories),
            'articles' => $this->hydrateKnowledgeArticles($articles),
            'article_types' => $this->knowledgeArticleTypeOptions(),
            'visibility_scopes' => $this->knowledgeVisibilityOptions(),
            'statuses' => $this->knowledgeArticleStatusOptions(),
            'stats' => [
                'categories_total' => count($categories),
                'articles_total' => (int) ($articleStats['articles_total'] ?? 0),
                'published_total' => (int) ($articleStats['published_total'] ?? 0),
                'faq_total' => (int) ($articleStats['faq_total'] ?? 0),
                'lesson_sources_total' => (int) ($lessonStats['lesson_sources_total'] ?? 0),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getKnowledgeArticleEditorData(string $articleId): array
    {
        $article = $this->db->fetchOne(
            'SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description,
                    kc.accent_color AS category_accent, u.full_name AS author_name
             FROM knowledge_articles ka
             INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
             LEFT JOIN users u ON u.id = ka.author_id
             WHERE ka.id = ?
             LIMIT 1',
            [$articleId],
        );

        if ($article === null) {
            throw new RuntimeException('Knowledge article not found.');
        }

        $hydratedArticle = $this->hydrateKnowledgeArticles([$article])[0];

        return [
            'article' => $hydratedArticle,
            'categories' => $this->db->fetchAll('SELECT * FROM knowledge_categories ORDER BY sort_order ASC, title ASC'),
            'article_types' => $this->knowledgeArticleTypeOptions(),
            'visibility_scopes' => $this->knowledgeVisibilityOptions(),
            'statuses' => $this->knowledgeArticleStatusOptions(),
        ];
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<string, mixed>
     */
    public function searchKnowledgeAssistant(?array $user, string $query, int $limit = 8): array
    {
        $query = trim($query);
        if ($query === '') {
            return [
                'query' => '',
                'answer' => [
                    'status' => 'empty',
                    'lead' => 'Задайте рабочий вопрос.',
                    'summary' => 'Помощник ищет ответы одновременно по справочнику, инструкциям, правилам и опубликованным урокам.',
                    'next_steps' => 'Например: как проверить дубль клиента, что фиксировать после звонка, как работает статус повторного обучения.',
                ],
                'results' => [],
                'sources_total' => 0,
            ];
        }

        $results = array_merge(
            $this->searchKnowledgeAssistantArticles($user, $query),
            $this->searchKnowledgeAssistantLessons($user, $query),
        );

        usort($results, static function (array $left, array $right): int {
            $scoreComparison = (int) ($right['score'] ?? 0) <=> (int) ($left['score'] ?? 0);
            if ($scoreComparison !== 0) {
                return $scoreComparison;
            }

            return strcmp((string) ($left['title'] ?? ''), (string) ($right['title'] ?? ''));
        });

        $results = array_values(array_slice($results, 0, $limit));

        if ($results === []) {
            return [
                'query' => $query,
                'answer' => [
                    'status' => 'empty',
                    'lead' => 'Точного совпадения пока нет.',
                    'summary' => 'По вашему запросу помощник не нашёл уверенный материал ни в справочнике, ни в опубликованных уроках.',
                    'next_steps' => 'Уточните формулировку, используйте ключевые слова процесса или добавьте новый материал в редакторе базы знаний.',
                ],
                'results' => [],
                'sources_total' => 0,
            ];
        }

        $primary = $results[0];
        $supporting = array_slice($results, 1, 3);

        return [
            'query' => $query,
            'answer' => [
                'status' => 'ok',
                'lead' => ($primary['source_kind'] ?? '') === 'lesson'
                    ? 'Основной ответ найден в учебном материале.'
                    : 'Основной ответ найден в базе знаний.',
                'summary' => $primary['snippet'] ?? '',
                'next_steps' => $supporting === []
                    ? 'Откройте материал целиком и при необходимости уточните вопрос.'
                    : 'Если ответа недостаточно, проверьте ещё связанные материалы ниже.',
            ],
            'results' => $results,
            'sources_total' => count($results),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getStudentDashboard(string $userId): array
    {
        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name, c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             LEFT JOIN users s ON s.id = u.supervisor_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($user === null) {
            throw new RuntimeException('User not found.');
        }

        $enrollments = $this->db->fetchAll(
            'SELECT e.*, c.slug AS course_slug, c.title AS course_title, c.short_description, cc.title AS category_title,
                    p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
             FROM enrollments e
             INNER JOIN courses c ON c.id = e.course_id
             INNER JOIN course_categories cc ON cc.id = c.category_id
             LEFT JOIN progress p ON p.enrollment_id = e.id
             WHERE e.user_id = ?
             ORDER BY e.assigned_at DESC',
            [$userId],
        );

        foreach ($enrollments as &$enrollment) {
            $enrollment['course'] = [
                'slug' => $enrollment['course_slug'],
                'title' => $enrollment['course_title'],
                'short_description' => $enrollment['short_description'],
                'category' => [
                    'title' => $enrollment['category_title'],
                ],
            ];
            $enrollment['progress'] = [
                'completion_percent' => (int) ($enrollment['completion_percent'] ?? 0),
                'lessons_completed' => (int) ($enrollment['lessons_completed'] ?? 0),
                'lessons_total' => (int) ($enrollment['lessons_total'] ?? 0),
                'modules_completed' => (int) ($enrollment['modules_completed'] ?? 0),
                'modules_total' => (int) ($enrollment['modules_total'] ?? 0),
            ];
            $enrollment['latest_decision'] = $this->db->fetchOne(
                'SELECT sd.*, u.full_name AS leader_name
                 FROM supervisor_decisions sd
                 INNER JOIN users u ON u.id = sd.leader_id
                 WHERE sd.enrollment_id = ?
                 ORDER BY sd.created_at DESC
                 LIMIT 1',
                [$enrollment['id']],
            );
            $enrollment['latest_attempts'] = $this->db->fetchAll(
                'SELECT * FROM attempts WHERE enrollment_id = ? ORDER BY submitted_at DESC LIMIT 3',
                [$enrollment['id']],
            );
        }
        unset($enrollment);

        $notifications = $this->db->fetchAll(
            'SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5',
            [$userId],
        );

        return [
            'user' => $user,
            'enrollments' => $enrollments,
            'notifications' => $notifications,
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getLeaderDashboard(string $leaderId): array
    {
        $team = $this->db->fetchAll(
            'SELECT u.*, c.name AS city_name, d.name AS department_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             WHERE u.supervisor_id = ?
             ORDER BY u.full_name ASC',
            [$leaderId],
        );

        foreach ($team as &$member) {
            $member['enrollments'] = $this->db->fetchAll(
                'SELECT e.*, co.title AS course_title, co.slug AS course_slug,
                        p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total
                 FROM enrollments e
                 INNER JOIN courses co ON co.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ?
                 ORDER BY e.assigned_at DESC',
                [$member['id']],
            );

            foreach ($member['enrollments'] as &$enrollment) {
                $enrollment['latest_decision'] = $this->db->fetchOne(
                    'SELECT * FROM supervisor_decisions WHERE enrollment_id = ? ORDER BY created_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
                $enrollment['latest_attempt'] = $this->db->fetchOne(
                    'SELECT * FROM attempts WHERE enrollment_id = ? ORDER BY submitted_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
            }
            unset($enrollment);
        }
        unset($member);

        return $team;
    }

    /**
     * @return array<string, mixed>
     */
    public function getLeaderEmployeeDetail(string $employeeId, string $leaderId): array
    {
        $employee = $this->db->fetchOne(
            'SELECT u.*, c.name AS city_name, d.name AS department_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             WHERE u.id = ? AND u.supervisor_id = ?
             LIMIT 1',
            [$employeeId, $leaderId],
        );

        if ($employee === null) {
            throw new RuntimeException('Employee not found.');
        }

        $employee['enrollments'] = $this->fetchEmployeeEnrollments($employeeId);
        $employee['training_summary'] = $this->buildTrainingSummary($employee['enrollments']);
        $employee['latest_decision'] = $employee['training_summary']['latest_decision'];
        $employee['decision_anchor_enrollment_id'] = $employee['training_summary']['decision_anchor_enrollment_id'];

        return $employee;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminDashboard(): array
    {
        $counts = [
            'users' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM users')['total'] ?? 0),
            'courses' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM courses')['total'] ?? 0),
            'enrollments' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM enrollments')['total'] ?? 0),
            'media' => (int) ($this->db->fetchOne('SELECT COUNT(*) AS total FROM media_assets')['total'] ?? 0),
        ];

        return [
            'counts' => $counts,
            'recent_courses' => $this->db->fetchAll(
                'SELECT c.*, cc.title AS category_title,
                        (SELECT COUNT(*) FROM modules m WHERE m.course_id = c.id) AS modules_count
                 FROM courses c
                 INNER JOIN course_categories cc ON cc.id = c.category_id
                 ORDER BY c.updated_at DESC
                 LIMIT 6'
            ),
            'recent_users' => $this->db->fetchAll(
                'SELECT u.*, r.key AS role_key, c.name AS city_name, d.name AS department_name
                 FROM users u
                 INNER JOIN roles r ON r.id = u.role_id
                 LEFT JOIN cities c ON c.id = u.city_id
                 LEFT JOIN departments d ON d.id = u.department_id
                 ORDER BY u.created_at DESC
                 LIMIT 6'
            ),
            'results' => $this->db->fetchAll(
                'SELECT e.*, u.full_name, c.title AS course_title, p.completion_percent
                 FROM enrollments e
                 INNER JOIN users u ON u.id = e.user_id
                 INNER JOIN courses c ON c.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 ORDER BY e.assigned_at DESC
                 LIMIT 8'
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminResources(): array
    {
        return [
            'users' => $this->db->fetchAll(
                'SELECT u.*, r.key AS role_key, r.name AS role_name,
                        c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
                 FROM users u
                 INNER JOIN roles r ON r.id = u.role_id
                 LEFT JOIN cities c ON c.id = u.city_id
                 LEFT JOIN departments d ON d.id = u.department_id
                 LEFT JOIN users s ON s.id = u.supervisor_id
                 ORDER BY u.full_name ASC'
            ),
            'courses' => $this->getAdminCoursesList(),
            'categories' => $this->getCourseCategoryResources(),
            'media' => $this->getAdminMediaLibrary(),
            'questions' => $this->getQuestionBank(),
            'enrollments' => $this->db->fetchAll(
                'SELECT e.*, u.full_name, r.key AS role_key, r.name AS role_name, c.title AS course_title, p.completion_percent
                 FROM enrollments e
                 INNER JOIN users u ON u.id = e.user_id
                 INNER JOIN roles r ON r.id = u.role_id
                 INNER JOIN courses c ON c.id = e.course_id
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 ORDER BY e.assigned_at DESC'
            ),
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getCourseCategoryResources(): array
    {
        return $this->db->fetchAll(
            'SELECT cc.*,
                    COUNT(c.id) AS courses_count,
                    SUM(CASE WHEN c.status = "PUBLISHED" THEN 1 ELSE 0 END) AS published_count
             FROM course_categories cc
             LEFT JOIN courses c ON c.category_id = cc.id
             GROUP BY cc.id, cc.slug, cc.title, cc.description, cc.sort_order
             ORDER BY cc.sort_order ASC, cc.title ASC'
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAdminMediaLibrary(): array
    {
        return $this->db->fetchAll(
            'SELECT ma.*,
                    c.title AS course_title,
                    u.full_name AS uploader_name,
                    lv.lesson_id AS video_lesson_id,
                    l_video.title AS video_lesson_title,
                    la.lesson_id AS attachment_lesson_id,
                    l_file.title AS attachment_lesson_title,
                    CASE
                        WHEN lv.lesson_id IS NOT NULL THEN 1
                        WHEN la.lesson_id IS NOT NULL THEN 1
                        ELSE 0
                    END AS is_in_use
             FROM media_assets ma
             LEFT JOIN courses c ON c.id = ma.course_id
             LEFT JOIN users u ON u.id = ma.uploaded_by_id
             LEFT JOIN lesson_videos lv ON lv.media_asset_id = ma.id
             LEFT JOIN lessons l_video ON l_video.id = lv.lesson_id
             LEFT JOIN lesson_attachments la ON la.asset_id = ma.id
             LEFT JOIN lessons l_file ON l_file.id = la.lesson_id
             ORDER BY ma.created_at DESC'
        );
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAdminResultSummaries(): array
    {
        $users = $this->db->fetchAll(
            'SELECT DISTINCT u.id, u.full_name, c.name AS city_name, d.name AS department_name
             FROM users u
             INNER JOIN enrollments e ON e.user_id = u.id
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             ORDER BY u.full_name ASC'
        );

        foreach ($users as &$user) {
            $user['enrollments'] = $this->db->fetchAll(
                'SELECT e.*, p.completion_percent
                 FROM enrollments e
                 LEFT JOIN progress p ON p.enrollment_id = e.id
                 WHERE e.user_id = ?
                 ORDER BY e.assigned_at DESC',
                [$user['id']],
            );

            $latestDecision = null;
            foreach ($user['enrollments'] as &$enrollment) {
                $decision = $this->db->fetchOne(
                    'SELECT * FROM supervisor_decisions WHERE enrollment_id = ? ORDER BY created_at DESC LIMIT 1',
                    [$enrollment['id']],
                );
                $enrollment['latest_decision'] = $decision;
                if ($latestDecision === null && $decision !== null) {
                    $latestDecision = $decision;
                }
            }
            unset($enrollment);
            $user['latest_decision'] = $latestDecision;
        }
        unset($user);

        return $users;
    }

    /**
     * @return array<string, mixed>
     */
    public function getAdminEmployeeResultDetail(string $userId): array
    {
        $employee = $this->db->fetchOne(
            'SELECT u.*, c.name AS city_name, d.name AS department_name, s.full_name AS supervisor_name
             FROM users u
             LEFT JOIN cities c ON c.id = u.city_id
             LEFT JOIN departments d ON d.id = u.department_id
             LEFT JOIN users s ON s.id = u.supervisor_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($employee === null) {
            throw new RuntimeException('Employee not found.');
        }

        $employee['enrollments'] = $this->fetchEmployeeEnrollments($userId);

        return $employee;
    }

    /**
     * @return array<string, mixed>
     */
    public function getUserById(string $userId): array
    {
        $user = $this->db->fetchOne(
            'SELECT u.*, r.key AS role_key, r.name AS role_name
             FROM users u
             INNER JOIN roles r ON r.id = u.role_id
             WHERE u.id = ?
             LIMIT 1',
            [$userId],
        );

        if ($user === null) {
            throw new RuntimeException('User not found.');
        }

        return $user;
    }

    /**
     * @return array<string, mixed>
     */
    public function getCourseEditorData(string $courseId): array
    {
        $course = $this->db->fetchOne('SELECT * FROM courses WHERE id = ? LIMIT 1', [$courseId]);
        if ($course === null) {
            throw new RuntimeException('Course not found.');
        }

        $course['city_ids'] = array_map(
            static fn (array $row): string => (string) $row['city_id'],
            $this->db->fetchAll('SELECT city_id FROM course_cities WHERE course_id = ? ORDER BY city_id ASC', [$courseId]),
        );
        $course['department_ids'] = array_map(
            static fn (array $row): string => (string) $row['department_id'],
            $this->db->fetchAll('SELECT department_id FROM course_departments WHERE course_id = ? ORDER BY department_id ASC', [$courseId]),
        );

        $modules = $this->db->fetchAll('SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC', [$courseId]);
        foreach ($modules as &$module) {
            $module['lessons'] = $this->db->fetchAll(
                'SELECT * FROM lessons WHERE module_id = ? ORDER BY sort_order ASC',
                [$module['id']],
            );
        }
        unset($module);

        $course['modules'] = $modules;

        return $course;
    }

    /**
     * @return array<string, mixed>
     */
    public function getLessonEditorData(string $lessonId): array
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.*, m.title AS module_title, m.course_id, c.title AS course_title
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             WHERE l.id = ?
             LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Lesson not found.');
        }

        $lesson['blocks'] = $this->db->fetchAll(
            'SELECT * FROM lesson_blocks WHERE lesson_id = ? ORDER BY sort_order ASC',
            [$lessonId],
        );
        $lesson['video'] = $this->db->fetchOne(
            'SELECT lv.*, ma.id AS media_asset_id, ma.original_name, ma.size_bytes, ma.duration_sec
             FROM lesson_videos lv
             INNER JOIN media_assets ma ON ma.id = lv.media_asset_id
             WHERE lv.lesson_id = ?
             LIMIT 1',
            [$lessonId],
        );
        $lesson['attachments'] = $this->db->fetchAll(
            'SELECT la.*, ma.original_name, ma.size_bytes
             FROM lesson_attachments la
             INNER JOIN media_assets ma ON ma.id = la.asset_id
             WHERE la.lesson_id = ?
             ORDER BY la.sort_order ASC',
            [$lessonId],
        );
        $lesson['quiz'] = empty($lesson['quiz_id']) ? null : $this->getQuizById((string) $lesson['quiz_id']);
        $lesson['selected_question_ids'] = array_map(
            static fn (array $item): string => (string) $item['question_id'],
            $lesson['quiz']['questions'] ?? [],
        );

        return $lesson;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRoles(): array
    {
        return $this->db->fetchAll('SELECT * FROM roles ORDER BY name ASC');
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getQuestionBank(): array
    {
        $questions = $this->db->fetchAll('SELECT * FROM questions ORDER BY created_at DESC');
        foreach ($questions as &$question) {
            $question['options'] = $this->db->fetchAll(
                'SELECT * FROM answer_options WHERE question_id = ? ORDER BY sort_order ASC',
                [$question['id']],
            );
            $question['quiz_links'] = $this->db->fetchAll(
                'SELECT * FROM quiz_questions WHERE question_id = ?',
                [$question['id']],
            );
            $question['usage_count'] = count($question['quiz_links']);
            $question['correct_count'] = count(array_filter(
                $question['options'],
                static fn (array $option): bool => (int) ($option['is_correct'] ?? 0) === 1,
            ));
        }
        unset($question);

        return $questions;
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuizById(string $quizId): array
    {
        $quiz = $this->db->fetchOne('SELECT * FROM quizzes WHERE id = ? LIMIT 1', [$quizId]);
        if ($quiz === null) {
            throw new RuntimeException('Quiz not found.');
        }

        $questions = $this->db->fetchAll(
            'SELECT qq.*, q.topic, q.prompt, q.question_type, q.explanation, q.meta_json
             FROM quiz_questions qq
             INNER JOIN questions q ON q.id = qq.question_id
             WHERE qq.quiz_id = ?
             ORDER BY qq.sort_order ASC',
            [$quizId],
        );

        foreach ($questions as &$item) {
            $item['options'] = $this->db->fetchAll(
                'SELECT * FROM answer_options WHERE question_id = ? ORDER BY sort_order ASC',
                [$item['question_id']],
            );
        }
        unset($item);

        $quiz['questions'] = $questions;

        return $quiz;
    }

    /**
     * @return array<string, mixed>
     */
    public function getQuizForAttempt(string $quizId): array
    {
        $quiz = $this->getQuizById($quizId);
        $relation = $this->db->fetchOne(
            'SELECT
                (SELECT id FROM courses WHERE final_quiz_id = ? LIMIT 1) AS final_course_id,
                (SELECT id FROM modules WHERE quiz_id = ? LIMIT 1) AS module_id,
                (SELECT id FROM lessons WHERE quiz_id = ? LIMIT 1) AS lesson_id',
            [$quizId, $quizId, $quizId],
        );

        $quiz['final_course_id'] = $relation['final_course_id'] ?? null;
        $quiz['module_id'] = $relation['module_id'] ?? null;
        $quiz['lesson_id'] = $relation['lesson_id'] ?? null;

        return $quiz;
    }

    private function getAdminCoursesList(): array
    {
        $courses = $this->db->fetchAll(
            'SELECT c.*, cc.title AS category_title
             FROM courses c
             INNER JOIN course_categories cc ON cc.id = c.category_id
             ORDER BY cc.sort_order ASC, c.title ASC'
        );

        foreach ($courses as &$course) {
            $modules = $this->db->fetchAll(
                'SELECT id, title, sort_order FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
                [$course['id']],
            );
            $course['modules'] = $modules;
            $course['category'] = [
                'title' => $course['category_title'],
            ];
            $course['cities'] = $this->db->fetchAll(
                'SELECT cc.*, c.name FROM course_cities cc INNER JOIN cities c ON c.id = cc.city_id WHERE cc.course_id = ?',
                [$course['id']],
            );
            $course['departments'] = $this->db->fetchAll(
                'SELECT cd.*, d.name FROM course_departments cd INNER JOIN departments d ON d.id = cd.department_id WHERE cd.course_id = ?',
                [$course['id']],
            );
        }
        unset($course);

        return $courses;
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<int, array<string, mixed>>
     */
    private function searchKnowledgeAssistantArticles(?array $user, string $query): array
    {
        $scopes = $this->knowledgeVisibilityScopes($user);
        $rows = $this->db->fetchAll(
            sprintf(
                "SELECT ka.*, kc.title AS category_title, kc.slug AS category_slug, kc.description AS category_description, kc.accent_color AS category_accent
                 FROM knowledge_articles ka
                 INNER JOIN knowledge_categories kc ON kc.id = ka.category_id
                 WHERE ka.status = 'PUBLISHED'
                   AND ka.visibility_scope IN (%s)
                 ORDER BY ka.is_featured DESC, kc.sort_order ASC, ka.sort_order ASC, ka.updated_at DESC",
                $this->placeholders(count($scopes)),
            ),
            $scopes,
        );

        $results = [];
        foreach ($this->hydrateKnowledgeArticles($rows) as $article) {
            $score = $this->knowledgeSearchScore($query, [
                ['text' => $article['title'] ?? '', 'weight' => 6],
                ['text' => $article['excerpt'] ?? '', 'weight' => 5],
                ['text' => $article['body'] ?? '', 'weight' => 4],
                ['text' => $article['search_keywords'] ?? '', 'weight' => 5],
                ['text' => $article['category']['title'] ?? '', 'weight' => 2],
            ]);

            if ($score <= 0) {
                continue;
            }

            $snippetSource = (string) ($article['excerpt'] ?: $article['body']);

            $results[] = [
                'id' => (string) $article['id'],
                'source_kind' => 'article',
                'source_label' => 'Справочник',
                'title' => (string) $article['title'],
                'href' => '/knowledge-base/' . $article['slug'],
                'context' => (string) ($article['category']['title'] ?? ''),
                'badge' => knowledge_article_type_label((string) $article['article_type']),
                'snippet' => $this->knowledgeSearchSnippet($snippetSource, $query),
                'score' => $score,
            ];
        }

        return $results;
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<int, array<string, mixed>>
     */
    private function searchKnowledgeAssistantLessons(?array $user, string $query): array
    {
        [$whereSql, $params] = $this->knowledgeLessonAssistantConditions($user);
        $rows = $this->db->fetchAll(
            'SELECT l.id,
                    l.title,
                    l.description,
                    l.lesson_type,
                    m.title AS module_title,
                    m.sort_order AS module_sort_order,
                    c.slug AS course_slug,
                    c.title AS course_title,
                    GROUP_CONCAT(COALESCE(lb.body, "") ORDER BY lb.sort_order SEPARATOR "\n\n") AS lesson_content
             FROM lessons l
             INNER JOIN modules m ON m.id = l.module_id
             INNER JOIN courses c ON c.id = m.course_id
             LEFT JOIN lesson_blocks lb ON lb.lesson_id = l.id
             WHERE ' . $whereSql . '
             GROUP BY l.id, l.title, l.description, l.lesson_type, m.title, m.sort_order, c.slug, c.title
             ORDER BY c.title ASC, m.sort_order ASC, l.sort_order ASC',
            $params,
        );

        $results = [];
        foreach ($rows as $lesson) {
            $score = $this->knowledgeSearchScore($query, [
                ['text' => $lesson['title'] ?? '', 'weight' => 6],
                ['text' => $lesson['description'] ?? '', 'weight' => 4],
                ['text' => $lesson['lesson_content'] ?? '', 'weight' => 3],
                ['text' => $lesson['module_title'] ?? '', 'weight' => 2],
                ['text' => $lesson['course_title'] ?? '', 'weight' => 2],
            ]);

            if ($score <= 0) {
                continue;
            }

            $content = trim((string) ($lesson['lesson_content'] ?: $lesson['description']));

            $results[] = [
                'id' => (string) $lesson['id'],
                'source_kind' => 'lesson',
                'source_label' => 'Учебный материал',
                'title' => (string) $lesson['title'],
                'href' => '/courses/' . $lesson['course_slug'] . '/lessons/' . $lesson['id'],
                'context' => trim((string) $lesson['course_title'] . ' / ' . (string) $lesson['module_title']),
                'badge' => lesson_type_label((string) ($lesson['lesson_type'] ?? 'TEXT')),
                'snippet' => $this->knowledgeSearchSnippet($content, $query),
                'score' => $score,
            ];
        }

        return $results;
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array{0:string,1:array<int,string>}
     */
    private function knowledgeLessonAssistantConditions(?array $user): array
    {
        $where = ["c.status = 'PUBLISHED'", 'm.is_published = 1'];
        $params = [];

        $role = (string) ($user['role_key'] ?? '');
        if ($role === 'STUDENT') {
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id) OR EXISTS (SELECT 1 FROM course_cities cc WHERE cc.course_id = c.id AND cc.city_id = ?))';
            $where[] = '(NOT EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id) OR EXISTS (SELECT 1 FROM course_departments cd WHERE cd.course_id = c.id AND cd.department_id = ?))';
            $params[] = (string) ($user['city_id'] ?? '');
            $params[] = (string) ($user['department_id'] ?? '');
        }

        return [implode(' AND ', $where), $params];
    }

    /**
     * @param array<int, array{text:string,weight:int}> $weightedTexts
     */
    private function knowledgeSearchScore(string $query, array $weightedTexts): int
    {
        $normalizedQuery = $this->normalizeKnowledgeText($query);
        $terms = $this->knowledgeSearchTerms($query);
        $score = 0;

        foreach ($weightedTexts as $item) {
            $text = $this->normalizeKnowledgeText((string) ($item['text'] ?? ''));
            $weight = (int) ($item['weight'] ?? 1);

            if ($text === '') {
                continue;
            }

            if ($normalizedQuery !== '' && str_contains($text, $normalizedQuery)) {
                $score += $weight * 5;
            }

            foreach ($terms as $term) {
                if ($term !== '' && str_contains($text, $term)) {
                    $score += $weight;
                }
            }
        }

        return $score;
    }

    /**
     * @return array<int, string>
     */
    private function knowledgeSearchTerms(string $query): array
    {
        $terms = preg_split('/[\s,.;:!?\/\\\\()\-]+/u', mb_strtolower(trim($query))) ?: [];
        $terms = array_values(array_unique(array_filter($terms, static fn (string $term): bool => mb_strlen($term) >= 2)));

        return $terms === [] ? [mb_strtolower(trim($query))] : $terms;
    }

    private function normalizeKnowledgeText(string $value): string
    {
        $value = strip_tags($value);
        $value = preg_replace('/\s+/u', ' ', trim($value)) ?? trim($value);

        return mb_strtolower($value);
    }

    private function knowledgeSearchSnippet(string $text, string $query, int $length = 240): string
    {
        $plain = preg_replace('/\s+/u', ' ', trim(strip_tags($text))) ?? trim(strip_tags($text));
        if ($plain === '') {
            return 'Откройте источник, чтобы посмотреть полный материал.';
        }

        $position = mb_stripos($plain, $query);
        if ($position === false) {
            foreach ($this->knowledgeSearchTerms($query) as $term) {
                $position = mb_stripos($plain, $term);
                if ($position !== false) {
                    break;
                }
            }
        }

        if ($position === false) {
            return mb_strlen($plain) > $length ? mb_substr($plain, 0, $length - 1) . '…' : $plain;
        }

        $start = max(0, $position - (int) floor($length / 3));
        $snippet = mb_substr($plain, $start, $length);
        $snippet = trim($snippet);

        if ($start > 0) {
            $snippet = '…' . ltrim($snippet);
        }

        if ($start + $length < mb_strlen($plain)) {
            $snippet .= '…';
        }

        return $snippet;
    }

    /**
     * @return array<int, array{value:string,label:string}>
     */
    private function knowledgeArticleTypeOptions(): array
    {
        return array_map(static fn (string $value): array => [
            'value' => $value,
            'label' => knowledge_article_type_label($value),
        ], ['DOCUMENT', 'INSTRUCTION', 'RULE', 'FAQ']);
    }

    /**
     * @return array<int, array{value:string,label:string}>
     */
    private function knowledgeVisibilityOptions(): array
    {
        return array_map(static fn (string $value): array => [
            'value' => $value,
            'label' => knowledge_visibility_label($value),
        ], ['ALL', 'STUDENT', 'LEADER', 'ADMIN']);
    }

    /**
     * @return array<int, array{value:string,label:string}>
     */
    private function knowledgeArticleStatusOptions(): array
    {
        return array_map(static fn (string $value): array => [
            'value' => $value,
            'label' => knowledge_article_status_label($value),
        ], ['DRAFT', 'PUBLISHED']);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function fetchEmployeeEnrollments(string $userId): array
    {
        $enrollments = $this->db->fetchAll(
            'SELECT e.*, c.title AS course_title, c.slug AS course_slug, c.id AS course_ref_id,
                    p.completion_percent, p.lessons_completed, p.lessons_total, p.modules_completed, p.modules_total,
                    p.last_activity_at
             FROM enrollments e
             INNER JOIN courses c ON c.id = e.course_id
             LEFT JOIN progress p ON p.enrollment_id = e.id
             WHERE e.user_id = ?
             ORDER BY e.assigned_at DESC',
            [$userId],
        );

        foreach ($enrollments as &$enrollment) {
            $enrollment['course_modules'] = $this->db->fetchAll(
                'SELECT * FROM modules WHERE course_id = ? ORDER BY sort_order ASC',
                [$enrollment['course_id']],
            );
            $enrollment['attempts'] = $this->db->fetchAll(
                'SELECT a.*, q.title AS quiz_title
                 FROM attempts a
                 INNER JOIN quizzes q ON q.id = a.quiz_id
                 WHERE a.enrollment_id = ?
                 ORDER BY a.submitted_at DESC',
                [$enrollment['id']],
            );
            $enrollment['decisions'] = $this->db->fetchAll(
                'SELECT sd.*, u.full_name AS leader_name
                 FROM supervisor_decisions sd
                 INNER JOIN users u ON u.id = sd.leader_id
                 WHERE sd.enrollment_id = ?
                 ORDER BY sd.created_at DESC',
                [$enrollment['id']],
            );
        }
        unset($enrollment);

        return $enrollments;
    }

    /**
     * @param array<int, array<string, mixed>> $enrollments
     * @return array{
     *     overall_completion_percent:int,
     *     overall_status:string,
     *     modules_completed:int,
     *     modules_total:int,
     *     lessons_completed:int,
     *     lessons_total:int,
     *     courses_total:int,
     *     completed_courses:int,
     *     latest_decision:array<string, mixed>|null,
     *     decision_anchor_enrollment_id:string|null
     * }
     */
    private function buildTrainingSummary(array $enrollments): array
    {
        $modulesCompleted = 0;
        $modulesTotal = 0;
        $lessonsCompleted = 0;
        $lessonsTotal = 0;
        $completedCourses = 0;
        $latestDecision = null;
        $decisionAnchorEnrollmentId = $enrollments[0]['id'] ?? null;
        $statuses = [];
        $completionValues = [];

        foreach ($enrollments as $enrollment) {
            $statuses[] = (string) ($enrollment['status'] ?? 'NOT_STARTED');
            $completionValues[] = (int) ($enrollment['completion_percent'] ?? 0);
            $modulesCompleted += (int) ($enrollment['modules_completed'] ?? 0);
            $modulesTotal += (int) ($enrollment['modules_total'] ?? 0);
            $lessonsCompleted += (int) ($enrollment['lessons_completed'] ?? 0);
            $lessonsTotal += (int) ($enrollment['lessons_total'] ?? 0);

            if ((string) ($enrollment['status'] ?? '') === 'COMPLETED') {
                $completedCourses++;
            }

            $decision = $enrollment['decisions'][0] ?? null;
            if ($decision === null) {
                continue;
            }

            if ($latestDecision === null || strtotime((string) $decision['created_at']) > strtotime((string) $latestDecision['created_at'])) {
                $latestDecision = $decision;
                $decisionAnchorEnrollmentId = (string) $enrollment['id'];
            }
        }

        if ($lessonsTotal > 0) {
            $overallCompletionPercent = (int) round(($lessonsCompleted / $lessonsTotal) * 100);
        } elseif ($modulesTotal > 0) {
            $overallCompletionPercent = (int) round(($modulesCompleted / $modulesTotal) * 100);
        } else {
            $overallCompletionPercent = average_progress($completionValues);
        }

        return [
            'overall_completion_percent' => $overallCompletionPercent,
            'overall_status' => overall_status($statuses),
            'modules_completed' => $modulesCompleted,
            'modules_total' => $modulesTotal,
            'lessons_completed' => $lessonsCompleted,
            'lessons_total' => $lessonsTotal,
            'courses_total' => count($enrollments),
            'completed_courses' => $completedCourses,
            'latest_decision' => $latestDecision,
            'decision_anchor_enrollment_id' => $decisionAnchorEnrollmentId,
        ];
    }

    /**
     * @param array<int, array<string, mixed>> $rows
     * @return array<string, array<int, array<string, mixed>>>
     */
    private function groupBy(array $rows, string $key): array
    {
        $grouped = [];
        foreach ($rows as $row) {
            $grouped[(string) $row[$key]][] = $row;
        }

        return $grouped;
    }

    private function placeholders(int $count): string
    {
        return implode(',', array_fill(0, $count, '?'));
    }

    /**
     * @param array<string, mixed>|null $user
     * @return array<int, string>
     */
    private function knowledgeVisibilityScopes(?array $user): array
    {
        $scopes = ['ALL'];
        $role = (string) ($user['role_key'] ?? '');

        if (in_array($role, ['STUDENT', 'LEADER', 'ADMIN'], true)) {
            $scopes[] = $role;
        }

        return $scopes;
    }

    /**
     * @param array<int, array<string, mixed>> $articles
     * @return array<int, array<string, mixed>>
     */
    private function hydrateKnowledgeArticles(array $articles): array
    {
        foreach ($articles as &$article) {
            $article['keywords'] = $this->parseKnowledgeKeywords($article['search_keywords'] ?? null);
            $article['category'] = [
                'title' => $article['category_title'] ?? '',
                'slug' => $article['category_slug'] ?? '',
                'description' => $article['category_description'] ?? null,
                'accent_color' => $article['category_accent'] ?? null,
            ];
        }
        unset($article);

        return $articles;
    }

    /**
     * @return array<int, string>
     */
    private function parseKnowledgeKeywords(?string $value): array
    {
        $parts = preg_split('/[,;]+/', trim((string) $value)) ?: [];

        return array_values(array_filter(array_map(
            static fn (string $item): string => trim($item),
            $parts,
        )));
    }
}
