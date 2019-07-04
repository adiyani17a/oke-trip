<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class menuList extends Model
{
    protected $table = 'menu_list';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $remember_token = false;
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';
    protected $fillable = [
							'id',
							'name',
							'slug',
							'group_menu_id',
							'url',
							'created_by',
							'updated_by',
							'created_at',
							'updated_at'
    					];

   	public function groupMenu()
    {
      return $this->belongsTo('App\groupMenu', 'group_menu_id', 'id');
    }
}
