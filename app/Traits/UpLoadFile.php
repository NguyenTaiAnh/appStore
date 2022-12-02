<?php


namespace App\Traits;


trait UpLoadFile {

    function storeImage($request, $fileName, $pathDir) {
        $file = $request->file($fileName);
        if ($file) {
            $s3 = \Storage::disk('s3');
            $time = time();
            $extension = $file->getClientOriginalExtension();
            $fileNameCustom = md5(rand()) . '_' . $time . '.' . $extension;
            $filePath = "/assets/{$pathDir}/{$fileNameCustom}";
            $result = $s3->put($filePath, file_get_contents($file), 'public');
            return $result ? $filePath : '';
        }
    }
}
