<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class blog extends Model
{
    protected $table = 'blog';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'content','image', 'head_line', 'created_by','updated_by'
    					];
}
