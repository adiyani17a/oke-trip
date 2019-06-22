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
        $data =  $this->model->destination()->paginate($req->showing);
        
        foreach ($data as $i => $d) {


            $data[$i]->action =     '<div class="dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Dropdown button
                                      </button>
                                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                      </div>
                                    </div>';
        }  

    	return Response::json($data);
    }
}
