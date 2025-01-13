<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPaymentMethod extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_name',
        'account_number',
        'branch_code',
        'iban',
        'account_title',
        'swift_code',
        'user_id', // Assuming each payment method belongs to a user
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
