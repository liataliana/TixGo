<?php
// [Magfi Adi Radza Putra] - Model PaymentMethod

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'method_name',
        'account_number',
        'account_name',
        'icon',
        'is_active',
    ];
}
