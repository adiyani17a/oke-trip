<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_additional extends Model
{
    protected $table = 'booking_additional';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'id_booking_pax', 'dt', 'additional_id'
    					];


    public function additional()
    {
    	return $this->belongsTo('App\additional', 'id', 'additional_id');
    }

    public function booking_pax()
    {
        return $this->belongsTo('App\booking_pax', 'dt', 'id_booking_pax')->where('booking_pax.id','booking_additional.id');
    }
}
