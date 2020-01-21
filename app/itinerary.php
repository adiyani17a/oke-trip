<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itinerary extends Model
{
    protected $table = 'itinerary';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'code', 'name', 'highlight', 'term_condition', 'flight_by', 'additional_id', 'carousel_1', 'carousel_2', 'carousel_3', 'note_1', 'note_2', 'note_3', 'pdf', 'flayer_image', 'schedule', 'flight_detail', 'book_by', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at','hot_deals','summary','archive'
    					];

    public function itinerary_detail()
    {
    	return $this->hasMany('App\itinerary_detail', 'id', 'id');
    }

    public function itinerary_flight()
    {
    	return $this->hasMany('App\itinerary_flight', 'id', 'id');
    }

    public function itinerary_schedule()
    {
    	return $this->hasMany('App\itinerary_schedule', 'id', 'id');
    }

    public function itinerary_destination()
    {
        return $this->hasMany('App\itinerary_destination', 'id', 'id');
    }

    public function itinerary_additional()
    {
        return $this->hasMany('App\itinerary_additional', 'id', 'id');
    }

    public function create()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
