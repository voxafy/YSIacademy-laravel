<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\LegacyDb;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use RuntimeException;

final class MediaService
{
    public function __construct(
        private readonly LegacyDb $db,
    ) {
    }

    public function uploadLessonVideo(string $lessonId, array $file, ?string $userId = null): string
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.id, m.course_id FROM lessons l INNER JOIN modules m ON m.id = l.module_id WHERE l.id = ? LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Урок не найден.');
        }

        $stored = $this->storeUploadedFile($file, 'VIDEO');
        $assetId = $this->insertMediaAsset($stored, 'VIDEO', $userId, (string) $lesson['course_id']);
        $existing = $this->db->fetchOne('SELECT * FROM lesson_videos WHERE lesson_id = ? LIMIT 1', [$lessonId]);

        if ($existing !== null) {
            $this->deleteAssetById((string) $existing['media_asset_id']);
            $this->db->execute(
                'UPDATE lesson_videos SET media_asset_id = ?, caption = ? WHERE id = ?',
                [$assetId, $stored['original_name'], $existing['id']],
            );
        } else {
            $this->db->execute(
                'INSERT INTO lesson_videos (id, lesson_id, media_asset_id, caption) VALUES (?, ?, ?, ?)',
                [str_id(), $lessonId, $assetId, $stored['original_name']],
            );
        }

        return $assetId;
    }

    public function deleteLessonVideo(string $lessonId): void
    {
        $existing = $this->db->fetchOne('SELECT * FROM lesson_videos WHERE lesson_id = ? LIMIT 1', [$lessonId]);
        if ($existing === null) {
            return;
        }

        $this->db->execute('DELETE FROM lesson_videos WHERE id = ?', [$existing['id']]);
        $this->deleteAssetById((string) $existing['media_asset_id']);
    }

    public function uploadLessonAttachment(string $lessonId, array $file, ?string $userId = null): string
    {
        $lesson = $this->db->fetchOne(
            'SELECT l.id, m.course_id FROM lessons l INNER JOIN modules m ON m.id = l.module_id WHERE l.id = ? LIMIT 1',
            [$lessonId],
        );

        if ($lesson === null) {
            throw new RuntimeException('Урок не найден.');
        }

        $stored = $this->storeUploadedFile($file, 'DOCUMENT');
        $assetId = $this->insertMediaAsset($stored, $stored['kind'], $userId, (string) $lesson['course_id']);
        $count = $this->db->fetchOne('SELECT COUNT(*) AS total FROM lesson_attachments WHERE lesson_id = ?', [$lessonId]);

        $this->db->execute(
            'INSERT INTO lesson_attachments (id, lesson_id, asset_id, label, sort_order) VALUES (?, ?, ?, ?, ?)',
            [str_id(), $lessonId, $assetId, $stored['original_name'], (int) ($count['total'] ?? 0) + 1],
        );

        return $assetId;
    }

    public function deleteLessonAttachment(string $lessonId, string $assetId): void
    {
        $attachment = $this->db->fetchOne(
            'SELECT * FROM lesson_attachments WHERE lesson_id = ? AND asset_id = ? LIMIT 1',
            [$lessonId, $assetId],
        );
        if ($attachment === null) {
            return;
        }

        $this->db->execute('DELETE FROM lesson_attachments WHERE id = ?', [$attachment['id']]);
        $this->deleteAssetById($assetId);
    }

    /**
     * @return array<string, mixed>
     */
    public function getAsset(string $assetId): array
    {
        $asset = $this->db->fetchOne('SELECT * FROM media_assets WHERE id = ? LIMIT 1', [$assetId]);
        if ($asset === null) {
            throw new RuntimeException('Файл не найден.');
        }

        return $asset;
    }

    public function streamAsset(string $assetId): BinaryFileResponse
    {
        $asset = $this->getAsset($assetId);
        $absolutePath = $this->absoluteStoragePath((string) $asset['storage_path']);

        if (!is_file($absolutePath)) {
            abort(404, 'File not found');
        }

        $mimeType = (string) ($asset['mime_type'] ?: 'application/octet-stream');
        $disposition = str_starts_with($mimeType, 'video/') || str_starts_with($mimeType, 'image/')
            ? 'inline'
            : 'attachment';

        if ($disposition === 'attachment') {
            return response()->download($absolutePath, (string) $asset['original_name'], [
                'Content-Type' => $mimeType,
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        return response()->file($absolutePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . rawurlencode((string) $asset['original_name']) . '"',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * @return array{original_name:string,file_name:string,mime_type:string,size_bytes:int,storage_path:string,kind:string}
     */
    private function storeUploadedFile(array $file, string $preferredKind): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Не удалось загрузить файл.');
        }

        $tmpName = (string) ($file['tmp_name'] ?? '');
        if ($tmpName === '' || !is_uploaded_file($tmpName)) {
            throw new RuntimeException('Некорректный временный файл загрузки.');
        }

        $originalName = trim((string) ($file['name'] ?? 'file'));
        $sizeBytes = (int) ($file['size'] ?? 0);
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = (string) $finfo->file($tmpName);
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        $kind = $this->resolveKind($preferredKind, $mimeType, $extension);
        $this->assertAllowedFile($kind, $mimeType, $extension, $sizeBytes);

        $relativeDir = match ($kind) {
            'VIDEO' => 'videos',
            'IMAGE', 'COVER' => 'images',
            default => 'files',
        };

        $safeBaseName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', pathinfo($originalName, PATHINFO_FILENAME)) ?: 'file';
        $fileName = str_id() . '-' . trim($safeBaseName, '-') . ($extension !== '' ? '.' . $extension : '');
        $absoluteDir = $this->absoluteStoragePath($relativeDir);

        if (!is_dir($absoluteDir) && !mkdir($absoluteDir, 0777, true) && !is_dir($absoluteDir)) {
            throw new RuntimeException('Не удалось создать директорию хранения.');
        }

        $absolutePath = $absoluteDir . DIRECTORY_SEPARATOR . $fileName;
        if (!move_uploaded_file($tmpName, $absolutePath)) {
            throw new RuntimeException('Не удалось сохранить загруженный файл.');
        }

        return [
            'original_name' => $originalName,
            'file_name' => $fileName,
            'mime_type' => $mimeType,
            'size_bytes' => $sizeBytes,
            'storage_path' => $relativeDir . '/' . $fileName,
            'kind' => $kind,
        ];
    }

    private function insertMediaAsset(array $stored, string $kind, ?string $userId, ?string $courseId): string
    {
        $assetId = str_id();
        $this->db->execute(
            'INSERT INTO media_assets (
                id, kind, title, original_name, file_name, mime_type, size_bytes, duration_sec,
                storage_provider, storage_path, public_url, bucket, metadata_json, uploaded_by_id, course_id, created_at, updated_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, NULL, ?, ?, NULL, NULL, NULL, ?, ?, NOW(), NOW())',
            [
                $assetId,
                $kind,
                $stored['original_name'],
                $stored['original_name'],
                $stored['file_name'],
                $stored['mime_type'],
                $stored['size_bytes'],
                'LOCAL',
                $stored['storage_path'],
                $userId,
                $courseId,
            ]
        );

        return $assetId;
    }

    private function deleteAssetById(string $assetId): void
    {
        $asset = $this->db->fetchOne('SELECT * FROM media_assets WHERE id = ? LIMIT 1', [$assetId]);
        if ($asset === null) {
            return;
        }

        $absolutePath = $this->absoluteStoragePath((string) $asset['storage_path']);
        if (is_file($absolutePath)) {
            @unlink($absolutePath);
        }

        $this->db->execute('DELETE FROM media_assets WHERE id = ?', [$assetId]);
    }

    private function resolveKind(string $preferredKind, string $mimeType, string $extension): string
    {
        if (str_starts_with($mimeType, 'video/')) {
            return 'VIDEO';
        }

        if (str_starts_with($mimeType, 'image/')) {
            return 'IMAGE';
        }

        if ($preferredKind === 'VIDEO') {
            return 'VIDEO';
        }

        if (in_array($extension, ['png', 'jpg', 'jpeg', 'webp', 'gif'], true)) {
            return 'IMAGE';
        }

        return 'DOCUMENT';
    }

    private function assertAllowedFile(string $kind, string $mimeType, string $extension, int $sizeBytes): void
    {
        $videoLimit = (int) env('MAX_VIDEO_SIZE_MB', 512) * 1024 * 1024;
        $fileLimit = (int) env('MAX_FILE_SIZE_MB', 20) * 1024 * 1024;

        $allowedVideo = ['mp4', 'webm', 'mov', 'm4v'];
        $allowedFiles = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'webp', 'gif'];

        if ($kind === 'VIDEO') {
            if (!in_array($extension, $allowedVideo, true) && !str_starts_with($mimeType, 'video/')) {
                throw new RuntimeException('Недопустимый формат видео.');
            }

            if ($sizeBytes > $videoLimit) {
                throw new RuntimeException('Видео превышает допустимый размер.');
            }

            return;
        }

        if (!in_array($extension, $allowedFiles, true)) {
            throw new RuntimeException('Недопустимый формат файла.');
        }

        if ($sizeBytes > $fileLimit) {
            throw new RuntimeException('Файл превышает допустимый размер.');
        }
    }

    private function absoluteStoragePath(string $relativePath): string
    {
        $normalized = str_replace(['\\', '..'], ['/', ''], $relativePath);
        $normalized = trim($normalized, '/');
        return storage_path('app/public/' . $normalized);
    }
}
