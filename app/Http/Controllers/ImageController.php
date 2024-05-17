<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image as InterventionImage;

class ImageController extends Controller
{

    public static array $imagesMimes=[
        'image/jpeg',
        'image/png',
    ];

    public function getImage($id){
        //TODO модификаторы приватности

        $image=Image::findOrFail($id)->image;

        if (!Storage::disk('private')->exists($image)) {
            abort(404, 'File not found');
        }
        $file = Storage::disk('private')->get($image);
        $mimeType = Storage::disk('private')->mimeType($image);

        if (in_array($mimeType, self::$imagesMimes)){
            //phpinfo();dd('qwe');
            $file = InterventionImage::read(Storage::disk('private')->path($image))
                ->scale($_GET['w']??null, $_GET['h']??null);
            $file=$file->encodeByMediaType();
        }

        return response($file, 200)
            ->header('Content-Type', $mimeType);
        //return Storage::disk('private')->download($image);
    }
}
