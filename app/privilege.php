<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class privilege extends Model
{
    protected $table = 'privilege';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id',
							'role_id',
							'role_name',
							'menu_list_id',
							'menu_list_name',
							'create',
							'edit',
							'delete' ,
							'validation',
							'created_by',
							'updated_by',
							'created_at',
							'updated_at'
    					];
}
