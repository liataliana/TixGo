<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingPassenger extends Model
{
    public function booking()
{
    return $this->belongsTo(Booking::class);
}

public function ticket()
{
    return $this->hasOne(Ticket::class);
}
}
