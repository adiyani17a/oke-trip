<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\destination;
use App\groupMenu;
use App\menuList;
use App\privilege;
use App\role;
use App\User;
class models extends Model
{
    public function destination()
    {
    	$destination = new destination();

    	return $destination; 
    }

    public function groupMenu()
    {
    	$groupMenu = new groupMenu();

    	return $groupMenu; 
    }

    public function menuList()
    {
    	$menuList = new menuList();

    	return $menuList; 
    }

    public function privilege()
    {
    	$privilege = new privilege();

    	return $privilege; 
    }

    public function role()
    {
        $role = new role();

        return $role; 
    }

    public function user()
    {
        $user = new User();

        return $user; 
    }
}
