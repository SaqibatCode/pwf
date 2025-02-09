<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Notifications\Notifiable;

class User extends Model implements AuthenticatableContract, CanResetPassword
{
    use Authenticatable;
    use HasFactory;
    use CanResetPasswordTrait;
    use Notifiable;
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate slug when creating a new user
        static::creating(function ($user) {
            if (empty($user->slug)) {
                $user->slug = static::generateUniqueSlug($user->getFullName());
            }
        });
    }

    /**
     * Generate a unique slug for the user.
     *
     * @param string $name
     * @return string
     */
    protected static function generateUniqueSlug($name)
    {
        $slug = Str::slug($name, '-');
        $count = self::where('slug', 'LIKE', "{$slug}%")->count();

        // If a similar slug exists, append a number to make it unique
        return $count ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get the full name of the user by combining first and last name.
     *
     * @return string
     */
    public function getFullName()
    {
        return trim("{$this->first_name} {$this->last_name}");
    }

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
        'city',
        'slug'
    ];

    public function user_verification()
    {
        return $this->hasOne(Verification::class);
    }
    public function payment_methods()
    {
        return $this->hasMany(SellerPaymentMethod::class);
    }
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function sellerChildOrders()
    {
        return $this->hasMany(ChildOrder::class, 'seller_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }
}
