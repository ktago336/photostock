<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getImage($id){
        //TODO модификатоы размера
        //TODO модификаторы приватности

        $image=Image::findOrFail($id)->image;

        if (!Storage::disk('private')->exists($image)) {
            abort(404, 'File not found');
        }
        $file = Storage::disk('private')->get($image);
        $mimeType = Storage::disk('private')->mimeType($image);

        return response($file, 200)
            ->header('Content-Type', $mimeType);
        //return Storage::disk('private')->download($image);
    }
}
