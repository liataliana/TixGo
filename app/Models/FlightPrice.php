<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FlightPrice extends Model
{
    public function flight()
{
    return $this->belongsTo(Flight::class);
}
}
