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

                if(!Auth::user()->hasAkses('Role','create')){
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

                if(!Auth::user()->hasAkses('Role','edit')){
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

            if(!Auth::user()->hasAkses('Role','delete')){
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

            if(!Auth::user()->hasAkses('Administrator User','validation')){
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
                if(!Auth::user()->hasAkses('Administrator User','create')){
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
                if(!Auth::user()->hasAkses('Administrator User','edit')){
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

            if(!Auth::user()->hasAkses('Administrator User','delete')){
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
        }

 

        $role = $this->model->role()->where('active','true')->get();

        return Response::json(['data'=>$data,'role'=>$role]);
    }

    public function chageStatusAgentUser(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAkses('Agent User','validation')){
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
                if(!Auth::user()->hasAkses('Agent User','create')){
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
                if(!Auth::user()->hasAkses('Agent User','edit')){
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

            if(!Auth::user()->hasAkses('Agent User','delete')){
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

            if(!Auth::user()->hasAkses('Additional','validation')){
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
                if(!Auth::user()->hasAkses('Additional','create')){
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
                if(!Auth::user()->hasAkses('Additional','edit')){
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

            if(!Auth::user()->hasAkses('Additional','delete')){
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
            $data[$i]->image = $data[$i]->image.'?'.time(); 
        }

        return Response::json(['data'=>$data]);
    }

    public function createItinerary()
    {
        $destination = $this->model->destination()->get();
        $additional = $this->model->additional()->where('active','true')->get();
        return Response::json(['destination'=>$destination,'additional'=>$additional]);
    }

    public function chageStatusItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAkses('Itinerary','validation')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Validate This Data']);
            } 

            if ($req->data == true) {
                $input['active'] = 'true';
            }else{
                $input['active'] = 'false';
            }
            $input['updated_by'] = Auth::user()->name;
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
                if(!Auth::user()->hasAkses('Itinerary','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $check = $this->model->itinerary()->where('name',$req->name)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Name Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    
                    $filename = 'itinerary_'.$req->name.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/itinerary/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/itinerary/' . $filename;
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
                $this->model->itinerary()->create($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAkses('Itinerary','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $check = $this->model->itinerary()->where('name',$req->name)->where('id','!=',$req->id)->first();
                
                if($check != null){
                    return Response::json(['status'=>0,'message'=>'Name Has Been Taken']);
                }

                $file = $req->gambar;
                if ($file != null) {
                    $old_path = $this->model->itinerary()->where('id','=',$req->id)->first();
                    unlink('.'.$old_path->image);
                    $filename = 'itinerary_'.$req->name.'.'.'jpg';
                    $path = './dist/img/itinerary';
                    if (!file_exists($path)) {
                        mkdir($path, 777, true);
                    }
                    $path = 'dist/img/itinerary/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/itinerary/' . $filename;
                    $input['image'] = $path;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                unset($input['gambar']);
                $input['active'] = 'true';
                $this->model->itinerary()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteItinerary(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAkses('Itinerary','delete')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
            }

            foreach ($req->data as $i => $d) {
                $this->model->itinerary()->where('id',$req->data[$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
}
