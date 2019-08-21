<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itinerary_schedule extends Model
{
    protected $table = 'itinerary_schedule';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
 
    protected $fillable = [
							'id', 'dt', 'caption', 'title', 'eat_service'
    					];
}
