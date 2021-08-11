<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mark', 'model', 'year', 'description', 'slug', 'enabled', 'country', 'city', 'image_filename', 'author_id'
    ];
}
