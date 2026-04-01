<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\AcademyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;

final class KnowledgeBaseController extends BasePageController
{
    public function __construct(
        \App\Support\PageRenderer $renderer,
        private readonly AcademyService $academy,
    ) {
        parent::__construct($renderer);
    }

    public function index(Request $request): Response
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        return $this->render('pages/knowledge-base', [
            'title' => 'База знаний',
            'user' => $user,
            'knowledgeBase' => $this->academy->getKnowledgeBaseIndex($user, [
                'q' => (string) $request->query('q', ''),
                'type' => (string) $request->query('type', ''),
                'category' => (string) $request->query('category', ''),
            ]),
        ]);
    }

    public function show(string $slug): Response
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        try {
            $article = $this->academy->getKnowledgeArticleBySlug($slug, $user);
        } catch (RuntimeException) {
            abort(404);
        }

        $knowledgeBase = $this->academy->getKnowledgeBaseIndex($user, []);

        return $this->render('pages/knowledge-article', [
            'title' => $article['article']['title'],
            'user' => $user,
            'knowledgeBase' => $knowledgeBase,
            'articleData' => $article,
        ]);
    }

    public function assistantSearch(Request $request): JsonResponse
    {
        $user = current_user();
        abort_unless($user !== null, 403);

        return response()->json(
            $this->academy->searchKnowledgeAssistant(
                $user,
                (string) $request->query('q', ''),
                max(3, min(10, (int) $request->query('limit', 6))),
            ),
        );
    }
}
