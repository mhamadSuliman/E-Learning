<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstructorProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'specialization',
        'photo',
        'rating',
        'github',
        'linkedin',
        'website',
    ];
        public function user()
    {
        return $this->belongsTo(User::class);
    }

}
