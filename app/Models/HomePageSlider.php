<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSlider extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_heading',
        'heading',
        'description',
        'another_heading',
        'button_text',
        'button_url',
        'image_desktop',
        'image_mobile',
    ];
}
