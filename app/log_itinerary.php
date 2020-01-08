<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log_itinerary extends Model
{
    protected $table = 'log_itinerary';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id','booking_id','code', 'name', 'highlight', 'term_condition', 'flight_by', 'additional_id', 'carousel_1', 'carousel_2', 'carousel_3', 'note_1', 'note_2', 'note_3', 'pdf', 'flayer_image', 'schedule', 'flight_detail', 'book_by', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at','hot_deals','summary'
    					];

    public function log_itinerary_detail()
    {
    	return $this->hasOne('App\log_itinerary_detail', 'id', 'id');
    }

    public function log_itinerary_flight()
    {
    	return $this->hasOne('App\log_itinerary_flight', 'id', 'id');
    }

    public function log_itinerary_schedule()
    {
    	return $this->hasOne('App\log_itinerary_schedule', 'id', 'id');
    }

    public function log_itinerary_destination()
    {
        return $this->hasOne('App\log_itinerary_destination', 'id', 'id');
    }

    public function log_itinerary_additional()
    {
        return $this->hasOne('App\log_itinerary_additional', 'id', 'id');
    }
}
