<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tour_leader extends Model
{
    protected $table = 'tour_leader';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = ['id', 'name', 'address', 'phone', 'passport', 'passport_exp_date', 'issuing', 'gender', 'birth_date', 'birth_place', 'image', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function itinerary_detail()
    {
    	return $this->hasMany('App\itinerary_detail', 'id', 'id');
    }

}
