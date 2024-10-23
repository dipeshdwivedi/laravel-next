<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    use HasFactory;
    protected $fillable = [
        'name',
        'path',
        'size',
        'mime_type',
        'user_id',
        'image_id',
    ];
    public function imageVariations() {
        return $this->hasMany(Image::class, 'image_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
