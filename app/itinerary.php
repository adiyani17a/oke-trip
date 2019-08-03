<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class itinerary extends Model
{
    protected $table = 'itinerarty';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'code', 'name', 'destination_id', 'highlight', 'term_condition', 'flight_by', 'additional_id', 'bg_image', 'pdf', 'flayer_image', 'schedule', 'flight_detail', 'book_by', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'
    					];
}
