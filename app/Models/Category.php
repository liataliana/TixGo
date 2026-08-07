<?php
// [Magfi Adi Radza Putra] - Model Category

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'icon',
        'description',
    ];

    public function tixgoTickets()
    {
        return $this->hasMany(TixgoTicket::class);
    }
}
