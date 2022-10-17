<?php

namespace App\Services;

use App\Models\DefaultAvatars;
use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class MediaService
{
    /**
     * Загрузить медиа пользователя
     *
     * @param UploadedFile $media
     * @param string $type
     * @return string
     */
    public static function uploadMedia(UploadedFile $media, string $type): string
    {
//        if (Storage::exists($mediaPath)) {
//            self::deleteAvatar($mediaPath);
//        }

        return $media->store('public/'. $type .'s');
    }

    /**
     * Удалить аватар пользователя
     *
     * @param string $path
     * @return void
     */
    public static function deleteAvatar(string $path): void
    {
        Storage::delete($path);
    }

    /**
     * @param string $path
     * @param int $client_id
     * @param string $type
     * @return Media
     */
    public static function storeMedia(string $path, int $client_id, string $type): Media
    {
        return Media::query()->create([
            'client_id' => $client_id,
            'path' => $path,
            'type' => $type,
        ]);
    }

    /**
     * Установить аватарку пользователю по умолчанию
     *
     * @param int $id
     * @return int
     */
    public static function setFirstAvatar($id = 1): int
    {
        return Media::create([
            'client_id' => auth()->user()->id,
            'path' => DefaultAvatars::find($id)->path,
            'type' => 'avatar',
        ])->id;
    }
}
