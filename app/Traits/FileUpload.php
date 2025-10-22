<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileUpload
{
    /**
     * Upload a single file
     */
    public function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($directory, $fileName, 'public');
        
        return $filePath;
    }

    /**
     * Upload multiple files
     */
    public function uploadMultipleFiles(array $files, string $directory = 'uploads'): array
    {
        $filePaths = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs($directory, $fileName, 'public');
                $filePaths[] = $filePath;
            }
        }
        
        return $filePaths;
    }

    /**
     * Delete a file
     */
    public function deleteFile(string $filePath): bool
    {
        if (Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        
        return false;
    }

    /**
     * Delete multiple files
     */
    public function deleteMultipleFiles(array $filePaths): void
    {
        foreach ($filePaths as $filePath) {
            $this->deleteFile($filePath);
        }
    }
}