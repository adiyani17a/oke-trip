<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\destination;
class models extends Model
{
    public function destination()
    {
    	$destination = new destination();

    	return $destination; 
    }
}
