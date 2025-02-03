<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'bank_name', 'account_number', 'branch_code', 'iban', 'account_title', 'swift_code',
    ];
}
