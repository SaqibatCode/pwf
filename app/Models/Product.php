<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\support\Str;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'category_id',
        'brand_id',
        'warranty',
        'price',
        'sale_price',
        'sku',
        'stock_quanity',
        'description',
        'year_of_make',
        'slug',
        'user_id',
        'condition'
        // Include any other fields here
    ];

    public static function generateSlug($productName, $sellerName)
    {
        // Combine product name and seller name to create the initial slug
        $slug = Str::slug($productName . ' ' . $sellerName);

        // Check if the slug already exists in the database
        $existingSlug = self::where('slug', $slug)->first();

        // If the slug exists, append a number to make it unique
        $count = 1;
        while ($existingSlug) {
            // Append '-1', '-2', etc. to the slug
            $slug = Str::slug($productName . ' ' . $sellerName) . '-' . $count;
            $existingSlug = self::where('slug', $slug)->first();
            $count++;
        }

        // Return the unique slug
        return $slug;
    }

    // If you also want to automatically handle timestamps
    public $timestamps = true; // Or false, if you don't want automatic timestamp handling
    // Each product belongs to a category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Each product belongs to a brand
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pictures()
    {
        return $this->hasMany(ProductPicture::class);
    }
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute');
    }
}
