<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class carousel extends Model
{
    protected $table = 'carousel';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
	protected $fillable = ['id', 'carousel_1', 'carousel_2', 'carousel_3', 'note_1', 'note_2', 'note_3', 'created_by', 'updated_by', 'created_at', 'updated_at'];

}
