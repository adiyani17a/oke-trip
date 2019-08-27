<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_d extends Model
{
    protected $table = 'booking_d';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'dt', 'bed', 'name', 'passport', 'exp_date', 'issuing', 'gender', 'birth_date', 'birth_place', 'room', 'reference', 'status_person', 'image', 'created_at', 'updated_at'
    					];

    public function booking_d()
    {
    	return $this->belongsTO('App\booking_d', 'id', 'id');
    }

    public function booking_additional()
    {
    	return $this->hasMany('App\booking_additional', 'id', 'id')->where('dt','id_booking_d');
    }
}
