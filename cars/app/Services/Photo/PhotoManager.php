<?php

namespace App\Services\Photo;

use App\Domain\Photo\PhotoManagerInterface;
use Illuminate\Http\Request;
use Image;
use File;

class PhotoManager implements PhotoManagerInterface
{
    public function deleteOldPhoto(string $filename): bool
    {
        if($filename != 'no-photo.jpg') {
            File::delete(public_path('uploads/car_image/'.$filename));
        }

        return true;
    }

    public function uploadCarImage($uploadedFile): string
    {
        $fileName = date('YmdHis').'.'.$uploadedFile->getClientOriginalExtension();

        $img = Image::make($uploadedFile->path());

        $img->resize(300, 230, function ($constraint) {
            $constraint->aspectRatio();
        })->save('uploads/car_image/'.$fileName);

        return $fileName;
    }
}