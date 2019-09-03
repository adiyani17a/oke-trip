<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models;
use Response;
use Auth;
use DB;
use carbon\carbon;
use Storage;
use Image;
use Illuminate\Support\Facades\Hash;

class apiController extends Controller
{
	protected $model;

	public function __construct()
	{
		$this->model = new models();
	}

    public function convertImageBase64(Request $req)
    {

        if ($req->feature == 'administrator-user') {
            $image = '.'.$this->model->user()->where('id',$req->id)->first()->image;
            $imgfile = file_get_contents($image);

            $base64 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);
        }elseif ($req->feature == 'agent-user') {
            $image = '.'.$this->model->user()->where('id',$req->id)->first()->image;
            $imgfile = file_get_contents($image);

            $base64 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);
        }elseif ($req->feature == 'tour-leader') {
            $image = '.'.$this->model->tour_leader()->where('id',$req->id)->first()->image;
            $imgfile = file_get_contents($image);

            $base64 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);
        }elseif ($req->feature == 'company') {
            $image = '.'.$this->model->company()->where('id',$req->id)->first()->image;
            $imgfile = file_get_contents($image);

            $base64 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);
        }

        return Response::json($base64);
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
                if(Auth::user()->role_id != 1){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Update This Data']);
                } 
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
            if(Auth::user()->role_id != 1){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            } 
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
                $id = $this->model->menuList()->max('id')+1;
                $input = $req->all();
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['name'] = ucwords($input['name']);
                $input['slug'] = strtolower(str_replace(' ','-',$input['slug']));
                $input['url'] = strtolower(str_replace(' ','-',$input['url']));
                $this->model->menuList()->create($input);

                $role = $this->model->role()->get();

                foreach ($role as $key => $value) {
                    $idPrivilege = $this->model->privilege()->max('id')+1;
                    $menu['id'] = $idPrivilege;
                    $menu['role_id'] = $value->id;
                    $menu['role_name'] = $value->name;
                    $menu['menu_list_id'] = $id;
                    $menu['menu_list_name'] = ucwords($input['name']);

                    if ($value->id == 1) {
                        $menu['view'] = 'true';
                        $menu['create'] = 'true';
                        $menu['edit'] = 'true';
                        $menu['delete'] = 'true';
                        $menu['validation'] = 'true';    
                    }else{
                        $menu['view'] = 'false';
                        $menu['create'] = 'false';
                        $menu['edit'] = 'false';
                        $menu['delete'] = 'false';
                        $menu['validation'] = 'false';
                    }

                    $menu['created_by'] = Auth::user()->name;
                    $menu['updated_by'] = Auth::user()->name;
                    $menu['created_at'] = carbon::now();
                    $menu['updated_at'] = carbon::now();
                    $this->model->privilege()->create($menu);
                }

                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(Auth::user()->role_id != 1){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Update This Data']);
                } 
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
            if(Auth::user()->role_id != 1){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            } 

            foreach ($req->data as $i => $d) {
                $this->model->menuList()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // PRIVILEGE
    public function datatablePrivilege(Request $req)
    {
        $data =  $this->model->privilege()
                     ->paginate($req->showing);
        
        return Response::json($data);
    }

    public function chageStatusPrivilege(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if ($req->data == true) {
                $input[$req->param] = 'true';
            }else{
                $input[$req->param] = 'false';
            }
            $input['updated_by'] = Auth::user()->name;
            $input['updated_at'] = carbon::now();
            $this->model->privilege()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
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

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_by'] = Auth::user()->name;
            $input['updated_at'] = carbon::now();
            $this->model->role()->where('id',$req->id)->update($input);
            if ($req->data == null) {
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

                if(!Auth::user()->hasAccess('Role','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                } 

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

                    if ($req->name == 'Developer') {
                        $menu['view'] = 'true';
                        $menu['create'] = 'true';
                        $menu['edit'] = 'true';
                        $menu['delete'] = 'true';
                        $menu['validation'] = 'true';    
                    }else{
                        $menu['view'] = 'false';
                        $menu['create'] = 'false';
                        $menu['edit'] = 'false';
                        $menu['delete'] = 'false';
                        $menu['validation'] = 'false';
                    }

                    $menu['created_by'] = Auth::user()->name;
                    $menu['updated_by'] = Auth::user()->name;
                    $menu['created_at'] = carbon::now();
                    $menu['updated_at'] = carbon::now();

                    $this->model->privilege()->create($menu);
                }
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{

                if(!Auth::user()->hasAccess('Role','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Update This Data']);
                } 

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $this->model->role()->where('id',$req->id)->update($input);

                $menu['role_id'] = $req->id;
                $menu['role_name'] = $req->name;
                $menu['updated_by'] = Auth::user()->name;
                $menu['updated_at'] = carbon::now();

                $this->model->privilege()->where('role_id',$req->id)->update($menu);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteRole(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Role','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            } 

            foreach ($req->data as $i => $d) {
                $this->model->role()->where('id',$req->data[$i]['id'])->delete();
                $this->model->privilege()->where('role_id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // ADMINISTRATOR USER
    public function datatableAdministratorUser(Request $req)
    {
        $data =  $this->model->user()->where('type_user','ADMIN')->paginate($req->showing);
            
        foreach ($data as $i => $d) {
            $data[$i]->action = '';
            $data[$i]->role_name = $d->role->name;
            if ($data[$i]->image != null) {
                $data[$i]->image = $data[$i]->image.'?'.time(); 
            }
        }

        $role = $this->model->role()->where('active','true')->get();

        return Response::json(['data'=>$data,'role'=>$role]);
    }

    public function chageStatusAdministratorUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Administrator User','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_at'] = carbon::now();
            $this->model->user()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveAdministratorUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Administrator User','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $check = $this->model->user()->where('email',$req->email)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Email Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    $filename = 'admin_'.$req->name.'.'.'jpg';
                    $path = './dist/img/user';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/user/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                $input['password'] =  Hash::make($req->password);
                $input['type_user'] = 'ADMIN';
                $input['active'] = 'true';
                $input['image'] = $path;
                $this->model->user()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Administrator User','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }
                $input = $req->all();
                $file = $req->gambar;
                if ($file != null) {
                    $filename = 'admin_'.$req->name.'.'.'jpg';
                    $path = './dist/img/user';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/user/' . $filename;
                    $input['image'] = $path;
                }else{
                    $filename = null;
                }

                $input['updated_at'] = carbon::now();
                unset($input['password']);
                unset($input['gambar']);
                if ($req->password != null) {
                    $input['password'] =  Hash::make($req->password);
                }
                $input['type_user'] = 'ADMIN';
                $input['active'] = 'true';

                $this->model->user()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteAdministratorUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Administrator User','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->user()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

    // AGENT USER
    public function datatableAgentUser(Request $req)
    {
        $data =  $this->model->user()->where('type_user','AGENT')->paginate($req->showing);
            
        foreach ($data as $i => $d) {
            $data[$i]->action = '';
            $data[$i]->role_name = $d->role->name;
            $data[$i]->image = $data[$i]->image.'?'.time(); 
            if ( $d->company != null) {
                $data[$i]->company_name = $d->company->name; 
            }else{
                $data[$i]->company_name = '-';
            }

        }

 

        $role = $this->model->role()->where('active','true')->get();
        $company = $this->model->company()->select('id as value','name')->get();

        return Response::json(['data'=>$data,'role'=>$role,'company'=>$company]);
    }

    public function chageStatusAgentUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Agent User','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_at'] = carbon::now();
            $this->model->user()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveAgentUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Agent User','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $check = $this->model->user()->where('email',$req->email)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Email Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    $filename = 'admin_'.$req->name.'.'.'jpg';
                    $path = './dist/img/user';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/user/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                $input['password'] =  Hash::make($req->password);
                $input['type_user'] = 'AGENT';
                $input['active'] = 'true';
                $input['image'] = $path;
                $this->model->user()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Agent User','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    $filename = 'admin_'.$req->name.'.'.'jpg';
                    $path = './dist/img/user';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/user/' . $filename;
                    $input['image'] = $path;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_at'] = carbon::now();
                unset($input['password']);
                unset($input['gambar']);
                if ($req->password != null) {
                    $input['password'] =  Hash::make($req->password);
                }
                $input['type_user'] = 'AGENT';
                $input['active'] = 'true';
                $this->model->user()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteAgentUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Agent User','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->user()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // Additional
    public function datatableAdditional(Request $req)
    {
        $data =  $this->model->additional()->paginate($req->showing);
        
        foreach ($data as $i => $d) {
            $data[$i]->image = $data[$i]->image.'?'.time(); 
        }

        return Response::json(['data'=>$data]);
    }

    public function chageStatusAdditional(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Additional','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_by'] = Auth::user()->name;
            $input['updated_at'] = carbon::now();
            $this->model->additional()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveAdditional(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Additional','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $check = $this->model->additional()->where('name',$req->name)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Name Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    
                    $filename = 'additional_'.$req->name.'.'.'jpg';
                    $path = './dist/img/additional';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/additional/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/additional/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['created_at'] = carbon::now();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                $input['active'] = 'true';
                $input['image'] = $path;
                $this->model->additional()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Additional','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $check = $this->model->additional()->where('name',$req->name)->where('id','!=',$req->id)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Name Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    $old_path = $this->model->additional()->where('id','=',$req->id)->first();
                    unlink('.'.$old_path->image);
                    $filename = 'additional_'.$req->name.'.'.'jpg';
                    $path = './dist/img/additional';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/additional/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/additional/' . $filename;
                    $input['image'] = $path;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                unset($input['gambar']);
                $input['active'] = 'true';
                $this->model->additional()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteAdditional(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Additional','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->additional()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // Itinerary
    public function datatableItinerary(Request $req)
    {
        $data =  $this->model->itinerary()->paginate($req->showing);
        $destination = $this->model->destination()->get();
        $additional = $this->model->additional()->get();
        foreach ($data as $i => $d) {
            $destination = explode(',', $d->destination_id);
            $destination = $this->model->destination()->whereIn('id',$destination)->get();

            foreach ($destination as $i1 => $d1) {
                if (count($destination)-1 == $i1) {
                    $data[$i]->destination .= $d1->name;
                }else{
                    $data[$i]->destination .= $d1->name.', ';
                }
            }
        }

        return Response::json(['data'=>$data]);
    }

    public function codeGenerator($index = 1)
    {
        $min = carbon::now()->startOfMonth()->format('Y-m-d');
        $max = carbon::now()->endOfMonth()->format('Y-m-d');

        $code = $this->model->itinerary()->where('created_at','>=',$min)->where('created_at','<=',$max)->count()+$index;
        $date = carbon::now()->format('ymd');
        return $code = 'TR'.$date.str_pad($code, 5, '0', STR_PAD_LEFT);
    }

    public function createItinerary()
    {
        $destination = $this->model->destination()->get();
        $additional = $this->model->additional()->where('active','true')->get();
        
        $index = 1;
        $code = $this->codeGenerator($index);

        $check = $this->model->itinerary()->where('code',$code)->first();

        if ($check != null) {
            $validate = false;
        }else{
            $validate = true;
        }

        while ($validate == false) {
            $index++;
            $code = $this->codeGenerator($index);

            $check = $this->model->itinerary()->where('code',$code)->first();

            if ($check != null) {
                $validate = false;
            }else{
                $validate = true;
            }
        }

        return Response::json(['destination'=>$destination,'additional'=>$additional,'code'=>$code]);
    }

    public function chageStatusItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Itinerary','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_by'] = Auth::user()->id;
            $input['updated_at'] = carbon::now();
            $this->model->itinerary()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                // carousel
                $form = json_decode($req->form);
                $formDetail = json_decode($req->formDetail);
                $id = $this->model->itinerary()->max('id')+1;
                $file = $req->carousel1;
                if ($file != null) {
                    $carousel_1 = 'carousel_1_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $carousel_1 = 'dist/img/itinerary/' . $carousel_1;
                    Image::make(file_get_contents($file))->save($carousel_1);  
                }else{
                    $carousel_1 = null;
                }

                $file = $req->carousel2;
                if ($file != null) {
                    $carousel_2 = 'carousel_2_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $carousel_2 = 'dist/img/itinerary/' . $carousel_2;
                    Image::make(file_get_contents($file))->save($carousel_2);  
                }else{
                    $carousel_2 = null;
                }

                $file = $req->carousel3;
                if ($file != null) {
                    $carousel_3 = 'carousel_3_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';

                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $carousel_3 = 'dist/img/itinerary/' . $carousel_3;
                    Image::make(file_get_contents($file))->save($carousel_3);  
                }else{
                    $carousel_3 = null;
                }

                $file = $req->pdf;
                if ($file != null) {
                    $pdf = 'pdf_'.$id.'.'.'pdf';
                    $path = 'dist/pdf/itinerary';

                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $file->move($path,$pdf);
                    $pdf = $path.'/'.$pdf;
                }else{
                    $pdf = null;
                }
                $file = $req->flyer;
                if ($file != null) {
                    $flyer = 'flyer_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $flyer = 'dist/img/itinerary/' . $flyer;
                    Image::make(file_get_contents($file))->save($flyer);  
                }else{
                    $flyer = null;
                }


                $data = array(
                    'id' => $id,
                    'name' => $form->name,
                    'destination_id' => implode(',', $form->destination),
                    'additional_id' => implode(',', $form->additional),
                    'flight_by' => $form->flightBy,
                    'code' => $form->code,
                    'term_condition' => $form->term,
                    'highlight' => $form->highlight,
                    'carousel_1' => $carousel_1,
                    'carousel_2' => $carousel_2,
                    'carousel_3' => $carousel_3,
                    'note_1' => $form->note[0],
                    'note_2' => $form->note[1],
                    'note_3' => $form->note[2],
                    'pdf' => $pdf,
                    'flayer_image' => $flyer,
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                );

                $this->model->itinerary()->create($data);
                for ($i=0; $i < count($formDetail->itineraryItems); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'code' => $form->code.'/'.str_pad($i+1,3,'0',STR_PAD_LEFT),
                        'seat' => $formDetail->itineraryItems[$i]->seat,
                        'seat_remain' => $formDetail->itineraryItems[$i]->seat,
                        'start' => $formDetail->itineraryItems[$i]->dateStart,
                        'end' => $formDetail->itineraryItems[$i]->dateEnd,
                        'adult_price' => filter_var($formDetail->itineraryItems[$i]->adultPrice,FILTER_SANITIZE_NUMBER_INT),
                        'child_price' => filter_var($formDetail->itineraryItems[$i]->CnBPrice,FILTER_SANITIZE_NUMBER_INT),
                        'child_bed_price' => filter_var($formDetail->itineraryItems[$i]->CwBPrice,FILTER_SANITIZE_NUMBER_INT),
                        'infant_price' => filter_var($formDetail->itineraryItems[$i]->infantPrice,FILTER_SANITIZE_NUMBER_INT),
                        'minimal_dp' => filter_var($formDetail->itineraryItems[$i]->minimalDP,FILTER_SANITIZE_NUMBER_INT),
                        'agent_com' => filter_var($formDetail->itineraryItems[$i]->agentPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_tip' => filter_var($formDetail->itineraryItems[$i]->tipsPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_visa' => filter_var($formDetail->itineraryItems[$i]->visaPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_tax' => filter_var($formDetail->itineraryItems[$i]->aptPrice,FILTER_SANITIZE_NUMBER_INT),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    );
                    $this->model->itinerary_detail()->create($data);
                }

                for ($i=0; $i < count($form->title); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'caption' => $form->caption[$i],
                        'title' => $form->title[$i],
                        'eat_service' => $form->bld[$i],
                    );
                    $this->model->itinerary_schedule()->create($data);
                }
                for ($i=0; $i < count($form->flight); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'flight_number' => $form->flight[$i],
                        'departure_airport_code' => $form->departureAirportCode[$i],
                        'arrival_airport_code' => $form->arrivalAirportCode[$i],
                        'departure' => $form->departure[$i],
                        'arrival' => $form->arrival[$i],
                    );

                    $this->model->itinerary_flight()->create($data);
                }

                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                // carousel
                $form = json_decode($req->form);
                $formDetail = json_decode($req->formDetail);
                $id = $req->id;

                $data = array(
                    'name' => $form->name,
                    'destination_id' => implode(',', $form->destination),
                    'additional_id' => implode(',', $form->additional),
                    'flight_by' => $form->flightBy,
                    'code' => $form->code,
                    'term_condition' => $form->term,
                    'highlight' => $form->highlight,
                    'note_1' => $form->note[0],
                    'note_2' => $form->note[1],
                    'note_3' => $form->note[2],
                    'updated_by' => Auth::user()->id,
                );

                $file = $req->carousel1;

                if ($file != 'undefined') {
                    $carousel_1 = 'carousel_1_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $carousel_1 = 'dist/img/itinerary/' . $carousel_1;
                    Image::make(file_get_contents($file))->save($carousel_1);  
                    $data['carousel_1'] = $carousel_1;
                }

                $file = $req->carousel2;
                if ($file != 'undefined') {
                    $carousel_2 = 'carousel_2_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $carousel_2 = 'dist/img/itinerary/' . $carousel_2;
                    Image::make(file_get_contents($file))->save($carousel_2);  
                    $data['carousel_2'] = $carousel_2;
                }

                $file = $req->carousel3;
                if ($file != 'undefined') {
                    $carousel_3 = 'carousel_3_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';

                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $carousel_3 = 'dist/img/itinerary/' . $carousel_3;
                    Image::make(file_get_contents($file))->save($carousel_3);  
                    $data['carousel_3'] = $carousel_3;
                }

                $file = $req->pdf;

                if ($file != null) {
                    $pdf = 'pdf_'.$id.'.'.'pdf';
                    $path = 'dist/pdf/itinerary';

                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $file->move($path,$pdf);
                    $pdf = $path.'/'.$pdf;
                    $data['pdf'] = $pdf;
                }

                $file = $req->flyer;
                if ($file != null) {
                    $flyer = 'flyer_'.$id.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }

                    $flyer = 'dist/img/itinerary/' . $flyer;
                    Image::make(file_get_contents($file))->save($flyer);  
                    $data['flayer_image'] = $flyer;
                }

                

                $this->model->itinerary()->where('id',$req->id)->update($data);

                $this->model->itinerary_detail()->where('id',$req->id)->delete();

                $this->model->itinerary_flight()->where('id',$req->id)->delete();

                $this->model->itinerary_schedule()->where('id',$req->id)->delete();

                for ($i=0; $i < count($formDetail->itineraryItems); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'code' => $form->code.'/'.str_pad($i+1,3,'0',STR_PAD_LEFT),
                        'seat' => $formDetail->itineraryItems[$i]->seat,
                        'seat_remain' => $formDetail->itineraryItems[$i]->seat,
                        'start' => $formDetail->itineraryItems[$i]->dateStart,
                        'end' => $formDetail->itineraryItems[$i]->dateEnd,
                        'adult_price' => filter_var($formDetail->itineraryItems[$i]->adultPrice,FILTER_SANITIZE_NUMBER_INT),
                        'child_price' => filter_var($formDetail->itineraryItems[$i]->CnBPrice,FILTER_SANITIZE_NUMBER_INT),
                        'child_bed_price' => filter_var($formDetail->itineraryItems[$i]->CwBPrice,FILTER_SANITIZE_NUMBER_INT),
                        'infant_price' => filter_var($formDetail->itineraryItems[$i]->infantPrice,FILTER_SANITIZE_NUMBER_INT),
                        'minimal_dp' => filter_var($formDetail->itineraryItems[$i]->minimalDP,FILTER_SANITIZE_NUMBER_INT),
                        'agent_com' => filter_var($formDetail->itineraryItems[$i]->agentPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_tip' => filter_var($formDetail->itineraryItems[$i]->tipsPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_visa' => filter_var($formDetail->itineraryItems[$i]->visaPrice,FILTER_SANITIZE_NUMBER_INT),
                        'agent_tax' => filter_var($formDetail->itineraryItems[$i]->aptPrice,FILTER_SANITIZE_NUMBER_INT),
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    );
                    $this->model->itinerary_detail()->create($data);
                }

                for ($i=0; $i < count($form->title); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'caption' => $form->caption[$i],
                        'title' => $form->title[$i],
                        'eat_service' => $form->bld[$i],
                    );
                    $this->model->itinerary_schedule()->create($data);
                }
                for ($i=0; $i < count($form->flight); $i++) { 
                    $data = array(
                        'id' => $id,
                        'dt' => $i+1,
                        'flight_number' => $form->flight[$i],
                        'departure_airport_code' => $form->departureAirportCode[$i],
                        'arrival_airport_code' => $form->arrivalAirportCode[$i],
                        'departure' => $form->departure[$i],
                        'arrival' => $form->arrival[$i],
                    );

                    $this->model->itinerary_flight()->create($data);
                }

                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function editItinerary($id)
    {   

        $destination = $this->model->destination()->get();
        $additional = $this->model->additional()->where('active','true')->get();
        
        $data = $this->model->itinerary()->with(['itinerary_detail','itinerary_flight','itinerary_schedule'])->where('id',$id)->first();

        $data->destination = array_map('intval', explode(',', $data->destination_id)); 
        $data->additional = array_map('intval', explode(',', $data->additional_id));

        $image = './'.$data->carousel_1;
        $imgfile = file_get_contents($image);
        $data->carousel1 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);

        $image = './'.$data->carousel_2;
        $imgfile = file_get_contents($image);
        $data->carousel2 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);

        $image = './'.$data->carousel_3;
        $imgfile = file_get_contents($image);
        $data->carousel3 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);

        $image = './'.$data->pdf;
        $imgfile = file_get_contents($image);
        $data->pdfs = 'data:file/pdf' . ';base64,' . base64_encode($imgfile);

        $image = './'.$data->flayer_image;
        $imgfile = file_get_contents($image);
        $data->flayer_images = 'data:file/pdf' . ';base64,' . base64_encode($imgfile);


        return Response::json(['data'=>$data,'additional'=>$additional,'destination'=>$destination]);
    }

    public function deleteItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Itinerary','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->itinerary()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

    public function menuListItinerary(Request $req)
    {
        $data = $this->model->itinerary()
                    ->with(['itinerary_detail','itinerary_schedule','itinerary_flight'])
                    ->where('id',$req->id)
                    ->first();
        return Response::json($data);
    }

    public function detailItinerary(Request $req)
    {

        $data = $this->model->itinerary_detail()
                    ->where('id',$req->id)
                    ->where('dt',$req->dt)
                    ->first();
        $tourLeader = $this->model->tour_leader()->get();
        
        $agen = $this->model->user()->where('type_user','AGENT')->get();

        return Response::json(['data'=>$data,'tourLeader'=>$tourLeader,'agen'=>$agen]);
    }

    public function saveDetailItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            $input = [];

            $file = $req->finalConfirmation;

            if (is_object($file)) {
                $pdf = 'final_confirmation_'.$req->id.'_'.$req->dt.'.'.'pdf';
                $path = 'dist/pdf/itinerary_detail';

                if (!file_exists($path)) {
                    mkdir($path, 777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                $input['final_pdf'] = $pdf;
            }

            $file = $req->tataTertib;

            if (is_object($file)) {
                $pdf = 'tata_tertib_'.$req->id.'_'.$req->dt.'.'.'pdf';
                $path = 'dist/pdf/itinerary_detail';

                if (!file_exists($path)) {
                    mkdir($path, 777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                $input['term_pdf'] = $pdf;
            }

            $file = $req->flayer;
            if (is_object($file)) {

                $pdf = 'flayer_'.$req->id.'_'.$req->dt.'.'.'jpg';
                $path = 'dist/pdf/itinerary_detail';

                if (!file_exists($path)) {
                    mkdir($path, 777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                $input['flayer_jpg'] = $pdf;
            }

            $input['tour_leader_id'] = $req->tour_leader_id;
            $input['booked_by'] = $req->booked_by;
            $input['tour_leader_tips'] = filter_var($req->tour_leader_tips,FILTER_SANITIZE_NUMBER_INT);
            $input['updated_by'] = Auth::user()->id;
            $input['updated_at'] = carbon::now();
            $this->model->itinerary_detail()->where('id',$req->id)->where('dt',$req->dt)->update($input);
            return Response::json(['status'=>1,'message'=>'Success update data']);
        });
    }

    // TOUR LEADER
    public function datatableTourLeader(Request $req)
    {
        $data =  $this->model->tour_leader()->paginate($req->showing);
            
        foreach ($data as $i => $d) {
            $data[$i]->action = '';
            $data[$i]->image = $data[$i]->image.'?'.time(); 
        }
 


        return Response::json(['data'=>$data]);
    }

    public function chageStatusTourLeader(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Agent User','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_at'] = carbon::now();
            $this->model->user()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function saveTourLeader(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Tour Leader','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $input = $req->all();
                $id = $this->model->tour_leader()->max('id')+1;

                $file = $req->image;
                if ($file != null) {
                    $filename = 'leader_'.$req->name.'_'.$id.'.'.'jpg';
                    $path = './dist/img/tourLeader';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/tourLeader/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $filename = '/dist/img/tourLeader/' . $filename;

                }else{
                    $filename = null;
                }

                $input['image'] = $filename;
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->tour_leader()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Tour Leader','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $input = $req->all();
                unset($input['image']);

                $file = $req->image;
                if ($file != null) {
                    $filename = 'leader_'.$req->name.'_'.$id.'.'.'jpg';
                    $path = './dist/img/tourLeader';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $filename = '/dist/img/tourLeader/' . $filename;
                    Image::make(file_get_contents($file))->save($filename);  
                    $input['image'] = $filename;

                }else{
                    $filename = null;
                }

                $input['updated_by'] = Auth::user()->name;
                $this->model->tour_leader()->where('id',$req->id)->update($input);

                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteTourLeader(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Tour Leader','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->user()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

    public function datatableCompany(Request $req)
    {
        $data =  $this->model->company()->paginate($req->showing);
            
        foreach ($data as $i => $d) {
            $data[$i]->action = '';
            $data[$i]->image = $data[$i]->image.'?'.time(); 
            $data[$i]->city_name = $d->city->name; 
        }
    

        $city = $this->model->city()->select('id as value','name')->get();


        return Response::json(['data'=>$data,'city'=>$city]);
    }

    public function saveCompany(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Company','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $input = $req->all();
                $id = $this->model->company()->max('id')+1;

                $file = $req->image;
                if ($file != null) {
                    $filename = 'leader_'.$req->name.'_'.$id.'.'.'jpg';
                    $path = './dist/img/company';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/company/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $filename = '/dist/img/company/' . $filename;

                }else{
                    $filename = null;
                }

                $input['image'] = $filename;
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->company()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Company','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $input = $req->all();
                unset($input['image']);

                $file = $req->image;
                if ($file != null) {
                    $filename = 'leader_'.$req->name.'_'.$id.'.'.'jpg';
                    $path = './dist/img/company';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $filename = '/dist/img/company/' . $filename;
                    Image::make(file_get_contents($file))->save($filename);  
                    $input['image'] = $filename;

                }else{
                    $filename = null;
                }

                $input['updated_by'] = Auth::user()->name;
                $this->model->company()->where('id',$req->id)->update($input);

                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function chageStatusCompany(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_by'] = Auth::user()->name;
            $input['updated_at'] = carbon::now();
            $this->model->company()->where('id',$req->id)->update($input);
            if ($req->data == null) {
                return Response::json(['status'=>1,'message'=>'Success deactivate data']);
            }else{
                return Response::json(['status'=>1,'message'=>'Success activate data']);
            }
        });
    }

    public function deleteCompany(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Company','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->company()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
}
