<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_itinerary_schedule extends Model
{
    protected $table = 'log_itinerary_schedule';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
 
    protected $fillable = [
							'id','booking_id','dt', 'caption', 'title', 'eat_service'
    					];
}
