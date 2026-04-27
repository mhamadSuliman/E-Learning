<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses_Categories extends Model
{
    protected $table = 'courses_categories';

    protected $fillable = [
        'title',
        'image'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }
}
