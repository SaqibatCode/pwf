<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    use HasFactory;
    protected $fillable = [
        'image',  // Add 'path' to the fillable array
        'product_id', // Include other fields that you want to mass-assign
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
