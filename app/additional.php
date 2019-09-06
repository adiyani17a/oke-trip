<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class additional extends Model
{
    protected $table = 'additional';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id',
                            'name',
							'price',
							'note',
                            'image',
							'active',
							'created_at',
                            'updated_at',
                            'created_by',
							'updated_by',
    					];

    public function itinerary_additional()
    {
        return $this->hasMany('App\itinerary_additional', 'additional_id', 'id');
    }
}
