<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_additional extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'booking_additional';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'id_booking_pax', 'dt', 'additional_id','id_booking_d'
    					];


    public function additional()
    {
    	return $this->belongsTo('App\additional', 'additional_id', 'id');
    }

    public function booking_pax()
    {
        return $this->belongsTo('App\booking_pax', 'dt', 'id_booking_pax')->where('booking_pax.id','booking_additional.id');
    }
}
