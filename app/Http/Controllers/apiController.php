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
    // GROUP MENU
    public function datatableGroupMenu(Request $req)
    {
        $data =  $this->model->groupMenu()->paginate($req->showing);
        

        foreach ($data as $i => $d) {
            $data[$i]->action = '';
        }
        return Response::json($data);
    }

    public function saveGroupMenu(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['name'] = ucwords($input['name']);
                $this->model->groupMenu()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $this->model->groupMenu()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteGroupMenu(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data as $i => $d) {
                $this->model->groupMenu()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // MENU LIST
    public function datatableMenuList(Request $req)
    {
        $data =  $this->model->menuList()
                     ->paginate($req->showing);
        
        foreach ($data as $i => $d) {
            $data[$i]->action = '';
            $data[$i]->group_menu_name = $d->groupMenu->name;
        }

        $groupMenu = $this->model->groupMenu()->get();
        return Response::json(['data'=>$data,'groupMenuList'=>$groupMenu]);
    }

    public function saveMenuList(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['name'] = ucwords($input['name']);
                $input['slug'] = strtolower(str_replace(' ','-',$input['slug']));
                $input['url'] = strtolower(str_replace(' ','-',$input['url']));
                $this->model->menuList()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                $input = $req->all();
                $input['slug'] = strtolower(str_replace(' ','-',$input['slug']));
                $input['url'] = strtolower(str_replace(' ','-',$input['url']));
                $input['updated_by'] = Auth::user()->name;
                $this->model->menuList()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteMenuList(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data as $i => $d) {
                $this->model->menuList()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // PRIVILEGE
    public function getDataPrivilege()
    {
        
    }

    public function savePrivilege(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['name'] = ucwords($input['name']);
                $input['slug'] = strtolower(str_replace(' ','-',$input['slug']));
                $input['url'] = strtolower(str_replace(' ','-',$input['url']));
                $this->model->menuList()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                $input = $req->all();
                $input['slug'] = strtolower(str_replace(' ','-',$input['slug']));
                $input['url'] = strtolower(str_replace(' ','-',$input['url']));
                $input['updated_by'] = Auth::user()->name;
                $this->model->menuList()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }
    // ROLE
    public function datatableRole(Request $req)
    {
        $data =  $this->model->role()->paginate($req->showing);
        

        foreach ($data as $i => $d) {
            $data[$i]->action = '';
        }
        return Response::json($data);
    }

    public function chageStatusRole(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            $input['active'] = $req->data['value'];
            $input['updated_by'] = Auth::user()->name;
            $this->model->role()->where('id',$req->data['id'])->update($input);
            if ($req->data['value'] == false) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveRole(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                $id = $this->model->role()->max('id')+1;
                $input = $req->all();
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['name'] = ucwords($input['name']);
                $this->model->role()->create($input);


                $menuList = $this->model->menuList()->get();
                foreach ($menuList as $key => $value) {
                    $idMenu = $this->model->privilege()->max('id')+1;
                        
                    $menu['id'] = $idMenu;
                    $menu['role_id'] = $id;
                    $menu['role_name'] = $req->name;
                    $menu['menu_list_id'] = $value->id;
                    $menu['menu_list_name'] = $value->name;
                    $menu['create'] = 0;
                    $menu['create'] = 0;

                    $this->model->privilege()->create($menu);
                }
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $this->model->role()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteRole(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data as $i => $d) {
                $this->model->role()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

}
