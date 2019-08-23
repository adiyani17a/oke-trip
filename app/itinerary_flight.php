<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itinerary_flight extends Model
{
    protected $table = 'itinerary_flight';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
 
    protected $fillable = [
							'id', 'dt', 'flight_number', 'departure','arrival','departure_airport_code','arrival_airport_code'
    					];
}
