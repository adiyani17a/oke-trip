<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $table = 'regencies';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    public $timestamps = false;
    protected $fillable = ['id', 'province_id', 'name'];
}
