<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class groupMenu extends Model
{
	protected $table = 'group_menu';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id',
							'name',
							'slug',
							'icon',
							'url',
							'created_by',
							'updated_by',
							'created_at',
							'updated_at'
    					];

    public function menuList()
    {
      return $this->hasMany('App\menuList', 'group_menu_id', 'id');
    }
}
