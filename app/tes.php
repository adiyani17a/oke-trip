<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tes extends Model
{
    protected $table = 'tes';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = [
    						'id'
    					];

}
