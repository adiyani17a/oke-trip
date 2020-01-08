<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_itinerary_additional extends Model
{
    protected $table = 'log_itinerary_additional';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
 
    protected $fillable = [
							'id','booking_id','dt', 'additional_id'
    					];

    public function additional()
    {
    	return $this->belongsTo('App\additional', 'additional_id', 'id');
    }
}
