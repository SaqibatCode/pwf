<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'address', 'phone', 'email', 'delivery_instructions'];

    public function childOrders()
    {
        return $this->hasMany(ChildOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
