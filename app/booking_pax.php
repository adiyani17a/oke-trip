<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_pax extends Model
{
    protected $table = 'booking_pax';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'dt', 'id_booking_d', 'name', 'passport', 'exp_date', 'issuing', 'gender', 'birth_date', 'birth_place', 'remark', 'passport_image', 'type', 'created_at', 'updated_at'
    					];

    public function booking_additional()
    {
    	return $this->hasMany('App\booking_additional', 'id_bookin_pax', 'dt')->where('booking_additional.id','booking_pax.id');
    }

    public function booking_d()
    {
        return $this->belongsTo('App\booking_d', 'dt', 'id_booking_d')->where('booking_d.id','booking_pax.id');
    }
}
