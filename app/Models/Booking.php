<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function flight()
{
    return $this->belongsTo(Flight::class);
}

public function passengers()
{
    return $this->hasMany(BookingPassenger::class);
}

public function payment()
{
    return $this->hasOne(Payment::class);
}

public function tickets()
{
    return $this->hasMany(Ticket::class);
}
}
