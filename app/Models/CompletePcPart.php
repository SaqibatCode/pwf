<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompletePcPart extends Model
{
    use HasFactory;
    protected $fillable = [
        'key',         // Allow mass assignment on the 'key' field
        'value',       // You may also want to allow 'value' to be mass assignable
        // Add any other fields you want to be mass assignable
    ];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
