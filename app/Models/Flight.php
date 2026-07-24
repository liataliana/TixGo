<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    public function airline()
{
    return $this->belongsTo(Airline::class);
}

public function airplane()
{
    return $this->belongsTo(Airplane::class);
}

public function departureAirport()
{
    return $this->belongsTo(
        Airport::class,
        'departure_airport_id'
    );
}

public function arrivalAirport()
{
    return $this->belongsTo(
        Airport::class,
        'arrival_airport_id'
    );
}

public function prices()
{
    return $this->hasMany(FlightPrice::class);
}

public function bookings()
{
    return $this->hasMany(Booking::class);
}
}
