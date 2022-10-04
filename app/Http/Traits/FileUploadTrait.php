<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Image;

trait FileUploadTrait {
    public $destinationPath = 'files';

    public function fileUpload($file, $destinationPath)
    {
        $result = [];
        if ($file) {
            if (! empty($oldFileFullPath)) {
                $this->removeFile($oldFileFullPath);
            }

            $uploadedFile = $file;
            $filename = 'files-'.(Carbon::now()->timestamp + rand(1, 1000));
            $extension = $uploadedFile->getClientOriginalExtension();
            $fullname = $filename.'.'.strtolower($extension);
            $fileSize = $uploadedFile->getSize();

            // Check if directory exists
            if (! (\File::exists($destinationPath))) {
                \Log::debug('Debug on making directory', [
                    'destinationPath' => $destinationPath,
                ]);
                
                \File::makeDirectory($destinationPath, 0777, true, true);
            }

            // Check Mime Type
            if ($uploadedFile->getClientMimeType() === 'application/pdf') {
                // File is PDF
                $path = $uploadedFile->storeAs($destinationPath, $fullname);
            } else {
                $dimension = getimagesize($file);
                // File is image
                $extension = 'webp';
                $path = $destinationPath.'/'.$fullname;
                $imageResize = Image::make($uploadedFile)->encode('webp', 90);
                // Resize image
                // if ($imageResize->width() > 750){
                //     $imageResize->resize(750, null, function ($constraint) {
                //         $constraint->aspectRatio();
                //     });
                // }
                $imageResize->save($path);
            }

            $result = [
                'file' => [
                    'filename' => $filename,
                    'extension' => $extension,
                    'fullname' => $fullname,
                    'path' => $path,
                ],
                'dimension' => [
                    'width' => isset($dimension) ? $dimension[0] : null,
                    'height' => isset($dimension) ? $dimension[1] : null,
                ],
                'fileSize' => $fileSize,
            ];
        }

        return $result;
    }
}