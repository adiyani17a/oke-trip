<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasAkses($fitur,$aksi){
      // select * from  join  on = where ubah =true
        
         $cek = DB::table('users')
                ->join('privilege', 'privilege.role_id', '=', 'users.role_id')
                ->where('menu_list_id', '=', $fitur)
                ->where($aksi, '=', 'true') 
                ->where('id', '=', Auth::user()->id)             
                ->first();   

        if ($cek != null) {
            return true;
        }else{
            return false;
        }
    }
}
