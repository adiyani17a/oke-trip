<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models;
use Response;
use Auth;
use DB;
use carbon\carbon;
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
            $data[$i]->action = '';
        }
    	return Response::json($data);
    }

    public function saveDestination(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->destination()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $this->model->destination()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteDestination(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data as $i => $d) {
                $this->model->destination()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
}
