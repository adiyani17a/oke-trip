<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class payment_history extends Model
{
    protected $table = 'payment_history';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id','code','booking_id', 'total_payment', 'payment_method', 'status_payment', 'created_at', 'updated_at', 'created_by', 'updated_by','type','itinerary_code'
    					];

    public function booking()
    {
    	return $this->belongsTo('App\booking', 'booking_id', 'id');
    }

    public function itinerary_detail()
    {
        return $this->belongsTo('App\itinerary_detail', 'itinerary_code', 'id');
    }

    public function payment_history_d()
    {
    	return $this->hasMany('App\payment_history_d', 'id', 'id');
    }
}
