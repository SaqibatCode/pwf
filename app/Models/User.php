<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class User extends Model implements AuthenticatableContract
{
    use Authenticatable;
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'father_name',
        'email',
        'dob',
        'address',
        'cnic',
        'type',
        'phone',
        'password',
        'verification',
        'terms',
    ];

    public function user_verification()
    {
        return $this->hasOne(Verification::class);
    }
}
