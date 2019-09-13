<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
protected $table = 'booking';
protected $primaryKey = 'id';
public $incrementing = false;
public $remember_token = false;
const UPDATED_AT = 'updated_at';
const CREATED_AT = 'created_at';
protected $fillable = [
						'id', 'kode', 'users_id', 'telp', 'itinerary_code', 'status', 'name', 'total_adult', 'total_child_no_bed', 'total_child_with_bed', 'total_infant', 'remark', 'total_additional', 'total_room', 'tax', 'visa', 'agent_com','staff_com', 'tips', 'total', 'handle_by', 'created_by', 'updated_by', 'created_at', 'updated_at','payment_status'
					];

    public function booking_d()
    {
    	return $this->hasMany('App\booking_d', 'id', 'id');
    }

    public function payment_history()
    {
        return $this->hasMany('App\payment_history', 'id', 'booking_id');
    }

    public function users()
    {
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

    public function handle_by()
    {
        return $this->belongsTo('App\User', 'handle_by', 'id');
    }
}
