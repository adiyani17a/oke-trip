<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking_d extends Model
{
    use \Awobaz\Compoships\Compoships;
    protected $table = 'booking_d';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'dt', 'bed', 'total_bed', 'created_at', 'updated_at'
    					];

    public function booking_pax()
    {
    	return $this->hasMany('App\booking_pax', ['id_booking_d','id'], ['dt','id']);
    }

    public function booking()
    {
        return $this->belongsTo('App\booking', 'id', 'id');
    }
}
