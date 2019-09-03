<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class destination extends Model
{
    protected $table = 'destination';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id',
							'name',
                            'note',
                            'image',
							'active',
							'created_at',
                            'updated_at',
                            'created_by',
							'updated_by',
    					];
}	
