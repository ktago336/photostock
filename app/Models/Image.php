<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;


    /**
     * @param \Illuminate\Http\UploadedFile $file File from input
     * @return string Saved path (under /public/uploads)
     */
    public static function createFromUploaded(\Illuminate\Http\UploadedFile $file):self{
        if (!$file) {
            return '';
        }
        $name = Storage::disk('private')->put('',$file);
        $image = new self();
        $image->image = $name;
        return $image;
    }


    public function getUrlAttribute(){
        //TODO image size parameters
        return route('get.image',$this->id);
    }



    //It can be assigned to commentary, post, profile (user)
    public function imageable():MorphTo{
        return $this->morphTo();
    }


    public function author(): BelongsTo {
        return $this->belongsTo(User::class, 'author_id');
    }
}
