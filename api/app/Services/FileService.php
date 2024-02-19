<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class FileService
{
    /**
     * @param UploadedFile $file
     * @param string $filePath
     * @return string|null
     */
    public static function move(UploadedFile $file, string $filePath): ?string
    {
        if ($file->isValid()) {
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            if ($file->move($filePath, $fileName)) {
                return $fileName;
            }
        }
        return null;
    }

    /**
     * @param string $file
     * @param string|null $filePath
     * @return void
     */
    public static function delete(string $file, ?string $filePath = null): void
    {
        if (file_exists($filePath . '/' . $file)) {
            unlink($filePath . '/' . $file);
        }
    }
}
