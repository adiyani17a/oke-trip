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
							'id', 'id_booking_d', 'dt', 'additional_id'
    					];

    public function booking()
    {
    	return $this->belongsTo('App\booking', 'id', 'id');
    }

    public function booking_d()
    {
    	return $this->belongsTo('App\booking_d', 'id', 'id')->where('dt','id_booking_d');
    }
}
