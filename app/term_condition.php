<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class term_condition extends Model
{
    protected $table = 'term_condition';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id', 'content', 'created_by','updated_by'
    					];
}
