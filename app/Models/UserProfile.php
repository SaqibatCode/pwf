<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'cover_photo',
        'profile_photo'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
