<?php
// [Magfi Adi Radza Putra] - Model TixgoTicket

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TixgoTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'ticket_code',
        'name',
        'description',
        'price',
        'stock',
        'location',
        'event_date',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class, 'ticket_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'ticket_id');
    }
}
