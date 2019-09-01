<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = ['id', 'name', 'address', 'phone', 'email', 'city_id', 'image','active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function city()
    {
    	return $this->hasOne('App\city', 'id', 'city_id');
    }

}
