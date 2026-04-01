<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class MediaController extends Controller
{
    public function __construct(
        private readonly MediaService $media,
    ) {
    }

    public function show(string $assetId): BinaryFileResponse
    {
        return $this->media->streamAsset($assetId);
    }

    public function uploadLessonVideo(Request $request, string $lessonId): RedirectResponse
    {
        $user = $this->requireCourseEditorAccess();

        try {
            $file = $request->file('video');
            $this->media->uploadLessonVideo($lessonId, [
                'error' => $file?->isValid() ? UPLOAD_ERR_OK : UPLOAD_ERR_NO_FILE,
                'tmp_name' => $file?->getPathname(),
                'name' => $file?->getClientOriginalName(),
                'size' => $file?->getSize(),
            ], (string) $user['id']);

            return redirect('/admin/lessons/' . $lessonId)->with('success', 'Видео загружено.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/lessons/' . $lessonId)->with('error', $exception->getMessage());
        }
    }

    public function deleteLessonVideo(string $lessonId): RedirectResponse
    {
        $this->requireCourseEditorAccess();
        $this->media->deleteLessonVideo($lessonId);

        return redirect('/admin/lessons/' . $lessonId)->with('success', 'Видео удалено.');
    }

    public function uploadLessonAttachment(Request $request, string $lessonId): RedirectResponse
    {
        $user = $this->requireCourseEditorAccess();

        try {
            $file = $request->file('attachment');
            $this->media->uploadLessonAttachment($lessonId, [
                'error' => $file?->isValid() ? UPLOAD_ERR_OK : UPLOAD_ERR_NO_FILE,
                'tmp_name' => $file?->getPathname(),
                'name' => $file?->getClientOriginalName(),
                'size' => $file?->getSize(),
            ], (string) $user['id']);

            return redirect('/admin/lessons/' . $lessonId)->with('success', 'Материал добавлен.');
        } catch (RuntimeException $exception) {
            return redirect('/admin/lessons/' . $lessonId)->with('error', $exception->getMessage());
        }
    }

    public function deleteLessonAttachment(string $lessonId, string $assetId): RedirectResponse
    {
        $this->requireCourseEditorAccess();
        $this->media->deleteLessonAttachment($lessonId, $assetId);

        return redirect('/admin/lessons/' . $lessonId)->with('success', 'Материал удален.');
    }

    /**
     * @return array<string, mixed>
     */
    private function requireCourseEditorAccess(): array
    {
        $user = current_user();
        abort_unless($user && in_array($user['role_key'] ?? '', ['ADMIN', 'LEADER'], true), 403);

        return $user;
    }
}
