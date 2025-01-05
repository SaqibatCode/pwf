<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cnic_front_picture',
        'cnic_back_picture',
        'shop_name',
        'shop_picture',
        'shop_business_card_picture',
        'shop_address',
        'rep_post_link',
    ];

    /**
     * A Verification belongs to a User.
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
