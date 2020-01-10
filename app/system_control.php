<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class system_control extends Model
{
    protected $table = 'system_control';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    
    protected $fillable = [
    						'id', 'name', `status`, 'created_by', 'updated_by'
    					];
}
