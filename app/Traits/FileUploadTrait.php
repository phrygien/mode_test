<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait FileUploadTrait
{
    public function uploadFile($file, $directory = 'uploads')
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($directory, $fileName, 'public');
    }

    public function deleteFile($filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
