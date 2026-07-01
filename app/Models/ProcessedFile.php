<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProcessedFile extends Model
{
    const TYPE_SINGLE = 'single';
    const TYPE_ARCHIVE = 'archive';

    protected $fillable = [
        'anonymous_id',
        'user_id',
        'type',
        'original_name',
        'path',
        'size',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'size' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Проверка существования файла
    public function fileExists(): bool
    {
        // TODO: путь в стораж должен состоять из /{anonymous_id}/file_path или /user-{user_id}/file_path
        // Для зарегистрированных и незарегистрированных пользователей
        return $this->path && Storage::disk('public')->exists($this->path);
    }

    // Удаление физического файла
    public function deleteFile(): void
    {
        // TODO: путь в стораж должен состоять из /{anonymous_id}/file_path или /user-{user_id}/file_path
        // Для зарегистрированных и незарегистрированных пользователей
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }
    }

    // Получение полного URL для скачивания
    public function getDownloadUrl(): string
    {
        // TODO: путь к файлу по сути - это всегда path, я думаю не нужен route отдельный
        return route('files.download', $this->id);
    }

    // Форматированный размер
    public function getFormattedSize(): string
    {
        $bytes = $this->size;
        if ($bytes < 1024) return $bytes . ' B';
        if ($bytes < 1024 * 1024) return round($bytes / 1024, 1) . ' KB';
        if ($bytes < 1024 * 1024 * 1024) return round($bytes / (1024 * 1024), 1) . ' MB';
        return round($bytes / (1024 * 1024 * 1024), 1) . ' GB';
    }
}
