<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_itinerary_flight extends Model
{
    protected $table = 'log_itinerary_flight';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
 
    protected $fillable = [
							'id','booking_id', 'dt', 'flight_number', 'departure','arrival','departure_airport_code','arrival_airport_code'
    					];
}
