<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airline extends Model
{
    public function admins()
    {
    return $this->hasMany(User::class);
    }

    public function airplanes()
    {
    return $this->hasMany(Airplane::class);
    }

    public function flights()
    {
    return $this->hasMany(Flight::class);
    }
}
