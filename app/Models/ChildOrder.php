<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildOrder extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'seller_id', 'quantity', 'payment_screenshot', 'status', 'payment_type', 'tracking_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
