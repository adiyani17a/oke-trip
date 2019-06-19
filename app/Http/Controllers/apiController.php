<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models;
use Response;
class apiController extends Controller
{
	protected $model;

	public function __construct()
	{
		$this->model = new models();
	}

    public function datatableDestination(Request $req)
    {	
    	$data =  $this->model->destination()->paginate(10);
    	
    	foreach ($data as $i => $d) {
    		$data[$i]->checkbox = '<input type="checkbox">';
    	}
    	return Response::json($data);
    }
}
