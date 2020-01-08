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
ini_set('post_max_size', '2048MB');
ini_set('upload_max_filesize', '2048MB');
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
        }elseif ($req->feature == 'destination') {
            $image = '.'.$this->model->destination()->where('id',$req->id)->first()->image;
            $imgfile = file_get_contents($image);

            $base64 = 'data:image/jpg' . ';base64,' . base64_encode($imgfile);
        }elseif ($req->feature == 'blog') {
            $image = '.'.$this->model->blog()->where('id',$req->id)->first()->image;
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

                $file = $req->image;
                if ($file != null) {
                    $filename = 'destination_'.$req->name.'.'.'jpg';
                    $path = './dist/img/destination';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/destination/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $path = '/dist/img/destination/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $input['image'] = $path;
                $this->model->destination()->insert($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{

                if(!Auth::user()->hasAccess('Additional','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $file = $req->image;
                if ($file != null) {
                    $old_path = $this->model->destination()->where('id','=',$req->id)->first();
                    if ($old_path->image != null) {
                        unlink('.'.$old_path->image);
                    }
                    $filename = 'destination_'.$req->name.'.'.'jpg';
                    $path = './dist/img/destination';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/destination/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $path = '/dist/img/destination/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                unset($input['image']);
                $input['image'] = $path;
                $input['active'] = 'true';
                $this->model->destination()->where('id',$req->id)->update($input);
                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteDestination(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data['data'] as $i => $d) {
                $this->model->destination()->where('id',$req->data['data'][$i]['id'])->delete();
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
                $this->model->groupMenu()->insert($input);
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
            foreach ($req->data['data'] as $i => $d) {
                $this->model->groupMenu()->where('id',$req->data['data'][$i]['id'])->delete();
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
                $this->model->menuList()->insert($input);

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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->menuList()->where('id',$req->data['data'][$i]['id'])->delete();
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

    public function changeStatusPrivilege(Request $req)
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

    public function changeStatusRole(Request $req)
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
                $this->model->role()->insert($input);


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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->role()->where('id',$req->data['data'][$i]['id'])->delete();
                $this->model->privilege()->where('role_id',$req->data['data'][$i]['id'])->delete();
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

    public function changeStatusAdministratorUser(Request $req)
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $path = '/dist/img/user/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                unset($input['gambar']);
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                $input['password'] =  Hash::make($req->password);
                $input['type_user'] = 'ADMIN';
                $input['active'] = 'true';
                $input['image'] = $path;
                $this->model->user()->insert($input);
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->user()->where('id',$req->data['data'][$i]['id'])->delete();
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

    public function changeStatusAgentUser(Request $req)
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $path = '/dist/img/user/' . $filename;
                }else{
                    $filename = null;
                }

                $input = $req->all();
                unset($input['password']);
                unset($input['gambar']);
                $input['updated_by'] = Auth::user()->name;
                $input['updated_at'] = carbon::now();
                $input['password'] =  Hash::make($req->password);
                $input['type_user'] = 'AGENT';
                $input['active'] = 'true';
                $input['image'] = $path;
                $this->model->user()->insert($input);
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/user/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->user()->where('id',$req->data['data'][$i]['id'])->delete();
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

    public function changeStatusAdditional(Request $req)
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/additional/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
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
                $this->model->additional()->insert($input);
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
                    $filename = 'additional_'.$req->name.'.'.'jpg';
                    $path = './dist/img/additional';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/additional/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
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

            foreach ($req->data['data'] as $i => $d) {
                $data = $this->model->additional()->where('id',$req->data['data'][$i]['id'])->first();
                    unlink('.'.$data->image);
                $this->model->additional()->where('id',$req->data['data'][$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }
    // Itinerary
    public function datatableItinerary(Request $req)
    {
        $data =  $this->model->itinerary()->paginate($req->showing);
        foreach ($data as $i => $d) {
            if (count($d->itinerary_destination) != 0) {
                foreach ($d->itinerary_destination as $i1 => $d1) {
                    if (count($d->itinerary_destination)-1 == $i1) {
                        $data[$i]->destination .= $d1->destination->name;
                    }else{
                        $data[$i]->destination .= $d1->destination->name.', ';
                    }
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

    public function changeStatusItinerary(Request $req)
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

    public function changeStatusHotDeal(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Itinerary','edit')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
            } 

            $input['hot_deals'] = $req->param;
            $input['updated_by'] = Auth::user()->id;
            $input['updated_at'] = carbon::now();
            $this->model->itinerary()->where('id',$req->id)->update($input);
            return Response::json(['status'=>1,'message'=>'Success Change data']);
        });
    }

    public function saveItinerary(Request $req)
    {
        DB::beginTransaction();
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
                    mkdir($path, 0777, true);
                }
                $carousel_1 = 'dist/img/itinerary/' . $carousel_1;
                Image::make(file_get_contents($file))->save($carousel_1);  
                chmod($carousel_1, 0755);
            }else{
                $carousel_1 = null;
            }

            $file = $req->carousel2;
            if ($file != null) {
                $carousel_2 = 'carousel_2_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_2 = 'dist/img/itinerary/' . $carousel_2;
                Image::make(file_get_contents($file))->save($carousel_2);  
                chmod($carousel_2, 0755);
            }else{
                $carousel_2 = null;
            }

            $file = $req->carousel3;
            if ($file != null) {
                $carousel_3 = 'carousel_3_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $carousel_3 = 'dist/img/itinerary/' . $carousel_3;
                Image::make(file_get_contents($file))->save($carousel_3);  
                chmod($carousel_3, 0755);
            }else{
                $carousel_3 = null;
            }

            $file = $req->pdf;
            if ($file != null) {
                $pdf = 'pdf_'.$id.'.'.'pdf';
                $path = 'dist/pdf/itinerary';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                chmod($pdf, 0755);
            }else{
                $pdf = null;
            }
            $file = $req->flyer;

            if ($file != null) {
                $flyer = 'flyer_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $flyer = 'dist/img/itinerary/' . $flyer;
                Image::make(file_get_contents($file))->save($flyer);  
                chmod($flyer, 0755);
            }else{
                $flyer = null;
            }


            $data = array(
                'id' => $id,
                'name' => $form->name,
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
                'summary' => $form->summary,
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
                    'start' => carbon::parse($formDetail->itineraryItems[$i]->dateStart)->format('Y-m-d'),
                    'end' =>  carbon::parse($formDetail->itineraryItems[$i]->dateEnd)->format('Y-m-d'),
                    'adult_price' => filter_var($formDetail->itineraryItems[$i]->adultPrice,FILTER_SANITIZE_NUMBER_INT),
                    'child_price' => filter_var($formDetail->itineraryItems[$i]->CnBPrice,FILTER_SANITIZE_NUMBER_INT),
                    'child_bed_price' => filter_var($formDetail->itineraryItems[$i]->CwBPrice,FILTER_SANITIZE_NUMBER_INT),
                    'infant_price' => filter_var($formDetail->itineraryItems[$i]->infantPrice,FILTER_SANITIZE_NUMBER_INT),
                    'minimal_dp' => filter_var($formDetail->itineraryItems[$i]->minimalDP,FILTER_SANITIZE_NUMBER_INT),
                    'agent_com' => filter_var($formDetail->itineraryItems[$i]->agentPrice,FILTER_SANITIZE_NUMBER_INT),
                    'staff_com' => filter_var($formDetail->itineraryItems[$i]->staffPrice,FILTER_SANITIZE_NUMBER_INT),
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

            for ($i=0; $i < count($form->destination); $i++) { 
                $data = array(
                    'id' => $id,
                    'dt' => $i+1,
                    'destination_id' => $form->destination[$i],
                );

                $this->model->itinerary_destination()->create($data);
            }

            for ($i=0; $i < count($form->additional); $i++) { 
                $data = array(
                    'id' => $id,
                    'dt' => $i+1,
                    'additional_id' => $form->additional[$i],
                );

                $this->model->itinerary_additional()->create($data);
            }

            DB::commit();
            return Response::json(['status'=>1,'message'=>'Success saving data']);
        }else{
            // carousel
            $form = json_decode($req->form);
            $formDetail = json_decode($req->formDetail);
            $id = $req->id;

            $data = array(
                'name' => $form->name,
                'flight_by' => $form->flightBy,
                'code' => $form->code,
                'term_condition' => $form->term,
                'highlight' => $form->highlight,
                'note_1' => $form->note[0],
                'summary' => $form->summary,
                'note_2' => $form->note[1],
                'note_3' => $form->note[2],
                'updated_by' => Auth::user()->id,
            );

            $file = $req->carousel1;

            if ($file != 'undefined') {
                $carousel_1 = 'carousel_1_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_1 = 'dist/img/itinerary/' . $carousel_1;
                Image::make(file_get_contents($file))->save($carousel_1);  
                chmod($carousel_1, 0755);
                $data['carousel_1'] = $carousel_1;
            }

            $file = $req->carousel2;
            if ($file != 'undefined') {
                $carousel_2 = 'carousel_2_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_2 = 'dist/img/itinerary/' . $carousel_2;
                Image::make(file_get_contents($file))->save($carousel_2);  
                chmod($carousel_2, 0755);
                $data['carousel_2'] = $carousel_2;
            }

            $file = $req->carousel3;
            if ($file != 'undefined') {
                $carousel_3 = 'carousel_3_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $carousel_3 = 'dist/img/itinerary/' . $carousel_3;
                Image::make(file_get_contents($file))->save($carousel_3);  
                chmod($carousel_3, 0755);
                $data['carousel_3'] = $carousel_3;
            }

            $file = $req->pdf;

            if ($file != null) {
                $pdf = 'pdf_'.$id.'.'.'pdf';
                $path = 'dist/pdf/itinerary';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                chmod($pdf, 0755);
                $data['pdf'] = $pdf;
            }

            $file = $req->flyer;
            if ($file != null) {
                $flyer = 'flyer_'.$id.'.'.'jpg';
                $path = './dist/img/itinerary';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $flyer = 'dist/img/itinerary/' . $flyer;
                Image::make(file_get_contents($file))->save($flyer);  
                chmod($flyer, 0755);
                $data['flayer_image'] = $flyer;
            }

            

            $this->model->itinerary()->where('id',$req->id)->update($data);

            $this->model->itinerary_flight()->where('id',$req->id)->delete();

            $this->model->itinerary_schedule()->where('id',$req->id)->delete();

            $this->model->itinerary_additional()->where('id',$req->id)->delete();

            $this->model->itinerary_destination()->where('id',$req->id)->delete();


            $old_detail = $this->model->itinerary_detail()->where('id',$req->id)->get();

            $notDelete = [];

            foreach ($old_detail as $x => $y) {
            	for ($i=0; $i < count($formDetail->itineraryItems); $i++) { 
	                if (!isset($formDetail->itineraryItems[$i]->dt)) {
                        $data = array(
                            'id' => $id,
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
                            'staff_com' => filter_var($formDetail->itineraryItems[$i]->staffPrice,FILTER_SANITIZE_NUMBER_INT),
                            'agent_tip' => filter_var($formDetail->itineraryItems[$i]->tipsPrice,FILTER_SANITIZE_NUMBER_INT),
                            'agent_visa' => filter_var($formDetail->itineraryItems[$i]->visaPrice,FILTER_SANITIZE_NUMBER_INT),
                            'agent_tax' => filter_var($formDetail->itineraryItems[$i]->aptPrice,FILTER_SANITIZE_NUMBER_INT),
                            'updated_by' => Auth::user()->id,
                        );

	                    $dt = $this->model->itinerary_detail()->where('id',$id)->max('dt')+1;
	                    $data['dt'] = $dt;
            			array_push($notDelete, $dt);
	                    $data['code'] = $form->code.'/'.str_pad($dt,3,'0',STR_PAD_LEFT);
	                    $data['created_by'] = Auth::user()->id;
	                    $this->model->itinerary_detail()->create($data);
	                }else{
                        $dataBooking = $this->model->itinerary_detail()->where('id',$id)->where('dt',$formDetail->itineraryItems[$i]->dt)->first();
                        if (!empty($dataBooking)) {
                            if (count($dataBooking->booking) == 0) {
                                $data = array(
                                    'id' => $id,
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
                                    'staff_com' => filter_var($formDetail->itineraryItems[$i]->staffPrice,FILTER_SANITIZE_NUMBER_INT),
                                    'agent_tip' => filter_var($formDetail->itineraryItems[$i]->tipsPrice,FILTER_SANITIZE_NUMBER_INT),
                                    'agent_visa' => filter_var($formDetail->itineraryItems[$i]->visaPrice,FILTER_SANITIZE_NUMBER_INT),
                                    'agent_tax' => filter_var($formDetail->itineraryItems[$i]->aptPrice,FILTER_SANITIZE_NUMBER_INT),
                                    'updated_by' => Auth::user()->id,
                                );
                            }else{
                                $data = array(
                                    'id' => $id,
                                    'seat' => $formDetail->itineraryItems[$i]->seat,
                                    'seat_remain' => $formDetail->itineraryItems[$i]->seat,
                                    'updated_by' => Auth::user()->id,
                                );
                            }
                        }else{
                            $data = array(
                                'id' => $id,
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
                                'staff_com' => filter_var($formDetail->itineraryItems[$i]->staffPrice,FILTER_SANITIZE_NUMBER_INT),
                                'agent_tip' => filter_var($formDetail->itineraryItems[$i]->tipsPrice,FILTER_SANITIZE_NUMBER_INT),
                                'agent_visa' => filter_var($formDetail->itineraryItems[$i]->visaPrice,FILTER_SANITIZE_NUMBER_INT),
                                'agent_tax' => filter_var($formDetail->itineraryItems[$i]->aptPrice,FILTER_SANITIZE_NUMBER_INT),
                                'updated_by' => Auth::user()->id,
                            );
                        }

	                    $data['dt'] = $formDetail->itineraryItems[$i]->dt;
            			array_push($notDelete, $formDetail->itineraryItems[$i]->dt);
	                    $this->model->itinerary_detail()->where('id',$id)->where('dt',$formDetail->itineraryItems[$i]->dt)->update($data);
	                }
	            }
            }

            $checking = $this->model->itinerary_detail()->where('id',$req->id)->whereNotIn('dt',$notDelete)->get();

            $forbidenDelete = [];

            foreach ($checking as $i => $d) {
            	if (count($d->booking) == 0) {
            		$this->model->itinerary_detail()->where('id',$req->id)->where('dt',$d->dt)->delete();
            	}else{
            		array_push($forbidenDelete, $d->code);
            	}
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

            for ($i=0; $i < count($form->destination); $i++) { 
                $data = array(
                    'id' => $id,
                    'dt' => $i+1,
                    'destination_id' => $form->destination[$i],
                );

                $this->model->itinerary_destination()->create($data);
            }

            for ($i=0; $i < count($form->additional); $i++) { 
                $data = array(
                    'id' => $id,
                    'dt' => $i+1,
                    'additional_id' => $form->additional[$i],
                );

                $this->model->itinerary_additional()->create($data);
            }

            if (count($forbidenDelete) != 0) {
            	$implode = implode(',', $forbidenDelete);
            	$message = 'Success Updating but itinerary detail with code '.$implode.' cannot be delete, because have booking already.';
            }else{
            	$message = 'Success updating data';
            }

            DB::commit();
            return Response::json(['status'=>1,'message'=>$message]);
        }
        
    }

    public function editItinerary($id)
    {   

        $destination = $this->model->destination()->get();
        $additional = $this->model->additional()->where('active','true')->get();
        
        $data = $this->model->itinerary()->with(['itinerary_detail','itinerary_flight','itinerary_schedule','itinerary_destination','itinerary_additional'])->where('id',$id)->first();

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
		DB::beginTransaction();
        if(!Auth::user()->hasAccess('Itinerary','delete')){
        	DB::rollBack();
            return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Delete This Data']);
        }
        foreach ($req->data['data'] as $i => $d) {
            $checking = $this->model->itinerary()->where('id',$req->data['data'][$i]['id'])->first();
            $validate = 0;
            foreach ($checking->itinerary_detail as $i1 => $d1) {
            	if (count($checking->booking) != 0) {
            		$validate += 1;
	            }
            }
	        
	        if ($validate == 0) {
	           	$this->model->itinerary()->where('id',$req->data['data'][$i]['id'])->delete();
	        }else{
	        	DB::rollBack();
            	return Response::json(['status'=>0,'message'=>'Failed deleting data, some itinerary has booking data already. If you want force delete, call developer']);
	        }
        }
        DB::commit();
        return Response::json(['status'=>1,'message'=>'Success deleting data']);
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
                    ->with(['payment_history'=>function($q){
                        $q->with(['payment_history_d']);
                    }])
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
                    mkdir($path, 0777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                chmod($pdf, 0755);
                $input['final_pdf'] = $pdf;
            }

            $file = $req->tataTertib;

            if (is_object($file)) {
                $pdf = 'tata_tertib_'.$req->id.'_'.$req->dt.'.'.'pdf';
                $path = 'dist/pdf/itinerary_detail';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                chmod($pdf, 0755);
                $input['term_pdf'] = $pdf;
            }

            $file = $req->flayer;
            if (is_object($file)) {

                $pdf = 'flayer_'.$req->id.'_'.$req->dt.'.'.'jpg';
                $path = 'dist/pdf/itinerary_detail';

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                $file->move($path,$pdf);
                $pdf = $path.'/'.$pdf;
                chmod($pdf, 0755);
                $input['flayer_jpg'] = $pdf;
            }

            $check = $this->model->itinerary_detail()->where('id',$req->id)->first();

            if ($req->booked_by == 'null' or $req->booked_by == 'undefined') {
                $input['booked_at'] = null;
                $input['booked_by'] = null;
            }else{
                $input['booked_by'] = $req->booked_by;
                if ($check->booked_by == null) {
                    $input['booked_at'] = carbon::now();
                }
            }
            $input['tour_leader_id'] = $req->tour_leader_id;
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

    public function changeStatusTourLeader(Request $req)
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
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/tourLeader/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $filename = '/dist/img/tourLeader/' . $filename;
                }else{
                    $filename = null;
                }

                $input['image'] = $filename;
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->tour_leader()->insert($input);
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
                        mkdir($path, 0777, true);
                    }
                    $filename = '/dist/img/tourLeader/' . $filename;
                    Image::make(file_get_contents($file))->save($filename);  
                    chmod($filename, 0755);
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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->user()->where('id',$req->data['data'][$i]['id'])->delete();
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
                    $filename = 'company_'.$id.'.'.'jpg';
                    $path = './dist/img/company';
                    if (!file_exists($path)) {
                        $oldmask = umask(0);
                        mkdir($path, 0777,true);
                        umask($oldmask);
                    }
                    $path = 'dist/img/company/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $filename = '/dist/img/company/' . $filename;

                }else{
                    $filename = null;
                }

                $input['image'] = $filename;
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->company()->insert($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Company','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $input = $req->all();
                unset($input['image']);
                $file = $req->image;
                if ($file != null) {
                    $filename = 'company_'.$req->id.'.'.'jpg';
                    $path = './dist/img/company';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/company/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $filename = '/dist/img/company/' . $filename;
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

    public function changeStatusCompany(Request $req)
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

            foreach ($req->data['data'] as $i => $d) {
                $this->model->company()->where('id',$req->data['data'][$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

    public function carousel()
    {
        $data = $this->model->carousel()->first();

        return Response::json(['data'=>$data,'message'=>'Success Fetching data']);
    }

    public function saveCarousel(Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Carousel','create')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Save This Data']);
            }

            $data = $this->model->carousel()->first();

            if ($data == null) {
                $id = $this->model->carousel()->max('id')+1;
                $this->model->carousel()->create([
                    'id' => $id,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                    'note_1' => $req->note_1,
                    'note_2' => $req->note_2,
                    'note_3' => $req->note_3,
                ]);
            }

            $file = $req->carousel_1;
            if ($file != null) {
                $filename = 'carousel_1.'.'jpg';
                $path = 'dist/img/carousel';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_1 = '/dist/img/carousel/' . $filename;
                $file->move($path,$filename);
                chmod($carousel_1, 0755);
                $input['carousel_1'] = $carousel_1;
            }

            $file = $req->carousel_2;
            if ($file != null) {
                $filename = 'carousel_2.'.'jpg';
                $path = 'dist/img/carousel';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_2 = '/dist/img/carousel/' . $filename;
                $file->move($path,$filename);
                chmod($carousel_2, 0755);
                $input['carousel_2'] = $carousel_2;
            }

            $file = $req->carousel_3;
            if ($file != null) {
                $filename = 'carousel_3.'.'jpg';
                $path = 'dist/img/carousel';
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                $carousel_3 = '/dist/img/carousel/' . $filename;
                $file->move($path,$filename);
                chmod($carousel_3, 0755);
                $input['carousel_3'] = $carousel_3;
            }


            $input['note_1'] = $req->note_1;
            $input['note_2'] = $req->note_2;
            $input['note_3'] = $req->note_3;
            $input['updated_by'] = Auth::user()->name;

            $this->model->carousel()->where('id',1)->update($input);
                

            return Response::json(['status'=>1,'message'=>'Success Updating data']);
        });
    }

    public function datatableBookingList(Request $req)
    {
        $data =  $this->model->booking()
        ->with(['users','handle','payment_history'=>function($q){
            $q->where('status_payment','Pending');
        },'itinerary_detail'=>function($q){
            $q->with(['itinerary']);
        }])->paginate($req->showing);
        return Response::json(['data'=>$data]);
    }

    public function editBookingList(Request $req)
    {
        $data['data'] = $this->model->booking() 
                     ->where('id',$req->id)
                     ->with(['booking_d'=>function($q){
                        $q->with(['booking_pax'=>function($q1){
                            $q1->with(['booking_additional'=>function($q2){
                                $q2->with(['additional']);
                            }]);
                        }]);
                     },'payment_history'=>function($q){
                        $q->with(['payment_history_d']);
                     },'users','handle','itinerary_detail'=>function($q){
                        $q->with(['itinerary'=>function($q1){
                            $q1->with(['itinerary_additional'=>function($q2){
                                $q2->with(['additional']);
                            }]);
                        }]);
                     }])
                     ->first();



        $data['invoice_list'] = [];
        $main_list = ['Adult','Child With Bed','Child No Bed','Infant','Agent Com','Staff Com','Tips','Visa','Apt Tax And Surcharge'];
        $temp = [];
        foreach ($main_list as $i => $d) {
            $temp['name'] = $main_list[$i];
            $temp['type'] = $main_list[$i];
            if ($main_list[$i] == 'Adult') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->adult_price;
            }else if ($main_list[$i] == 'Child With Bed') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->child_bed_price;
            }else if ($main_list[$i] == 'Child No Bed') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->child_price;
            }else if ($main_list[$i] == 'Infant') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->infant_price;
            }else if ($main_list[$i] == 'Agent Com') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->agent_com;
            }else if ($main_list[$i] == 'Staff Com') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->staff_com;
            }else if ($main_list[$i] == 'Tips') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->agent_tip;
            }else if ($main_list[$i] == 'Visa') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->agent_visa;
            }else if ($main_list[$i] == 'Apt Tax And Surcharge') {
                $temp['chargePerAmount'] = $data['data']->itinerary_detail->agent_tax;
            }
            $temp['nominal'] = 0;
            $temp['value'] = 0;
            array_push($data['invoice_list'], $temp);
        }


        foreach ($data['data']->itinerary_detail->itinerary->itinerary_additional as $i => $d) {
            $temp['name'] = $d->additional->name;
            $temp['type'] = $d->additional->id;
            $temp['chargePerAmount'] = $d->additional->price;
            $temp['nominal'] = 0;
            $temp['value'] = 0;

            array_push($data['invoice_list'], $temp);
        }

        foreach ($data['invoice_list'] as $i => $d) {
            foreach ($data['data']->booking_d as $i1 => $d1) {
                foreach ($d1->booking_pax as $i2 => $d2) {
                    if ($d2->type == $data['invoice_list'][$i]['name']) {
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }elseif($data['invoice_list'][$i]['name'] == 'Agent Com'){
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }elseif($data['invoice_list'][$i]['name'] == 'Staff Com'){
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }elseif($data['invoice_list'][$i]['name'] == 'Tips'){
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }elseif($data['invoice_list'][$i]['name'] == 'Visa'){
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }elseif($data['invoice_list'][$i]['name'] == 'Apt Tax And Surcharge'){
                        $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                        $data['invoice_list'][$i]['value'] += 1;
                    }

                    foreach ($d2->booking_additional as $i3 => $d3 ) {
                        if ($data['invoice_list'][$i]['type'] == $d3->additional->id) {
                            $data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
                            $data['invoice_list'][$i]['value'] += 1;
                        }
                    }
                }
            }
        }

        $data['user'] = $this->model->user()->get();

        return response::json(['status'=>1,'data'=>$data]);
    }

    public function updateBookingList(Request $req)
    {
        DB::beginTransaction();
        $data = $this->model->booking()->where('id',$req->id)->first();
        $room = json_decode($req->room);
        $guest_leader = json_decode($req->guest_leader);
        $pricing = json_decode($req->pricing);

        // save booking

        $itinerary_detail = $data->itinerary_detail;

        $total_old  = 0;

        foreach ($data->booking_d as $i => $d) {
            foreach ($d->booking_pax as $i1 => $d1) {
                $total_old +=1;
            }
        }

        $total_pax = 0;
        $total_pax = $pricing[0]->value + $pricing[1]->value + $pricing[2]->value + $pricing[3]->value;

        if ($data->status != 'Rejected') {
            $this->model->itinerary_detail()->where('code',$itinerary_detail->code)->update(['seat_remain'=> DB::raw("seat_remain + '$total_old'")]);
        }

        $remain = $this->model->itinerary_detail()->where('code',$itinerary_detail->code)->first();

        if ($remain->seat_remain < $total_pax) {
            DB::rollBack();
            return Response::json(['status'=>0,'message','Sorry the pax available only '.$remain->seat_remain.', please call customer service for further information']);
        }

        if ($req->status != 'Rejected') {
            $this->model->itinerary_detail()->where('code',$itinerary_detail->code)
                ->update([
                    'seat_remain' => DB::raw("seat_remain - '$total_pax'")
                ]);
        }
            

        $id = $req->id;

        $day = Carbon::now()->format('dmy');

        $total_additional = 0;
        for ($i=0; $i < (count($pricing)-9); $i++) { 
            $total_additional += $pricing[$i+9]->nominal;
        }

        $data = array(
                    'users_id'              => $req->id_user,
                    'telp'                  => $guest_leader->telp,
                    'itinerary_code'        => $itinerary_detail->code,
                    'status'                => $req->status,
                    'name'                  => $guest_leader->party_name,
                    'total_adult'           => $pricing[0]->nominal,
                    'total_child_no_bed'    => $pricing[1]->nominal,
                    'total_child_with_bed'  => $pricing[2]->nominal,
                    'total_infant'          => $pricing[3]->nominal,
                    'agent_com'             => $pricing[4]->nominal,
                    'staff_com'             => $pricing[5]->nominal,
                    'tips'                  => $pricing[6]->nominal,
                    'visa'                  => $pricing[7]->nominal,
                    'tax'                   => $pricing[8]->nominal,
                    'remark'                => $req->remark,
                    'total_additional'      => $total_additional,
                    'total_room'            => count($room->bed),
                    'total'                 => $req->total,
                    'handle_by'             => Auth::user()->id,
                    'updated_by'            => Auth::user()->name,
                    'updated_at'            => carbon::now(),
                );

        $this->model->booking()->where('id',$id)->update($data);

        $this->model->booking_d()->where('id',$id)->delete();
        $this->model->booking_pax()->where('id',$id)->delete();
        $this->model->booking_additional()->where('id',$id)->delete();

        for ($i=0; $i < count($room->bed); $i++) { 

            

            $data = array(
                        'id'            => $id,
                        'dt'            => $i+1,
                        'bed'           => $room->bed[$i],
                        'total_bed'     => count($room->name[$i]),
                    );


            $this->model->booking_d()->create($data);
            for ($i1=0; $i1 < count($room->name[$i]); $i1++) { 

                $file = $req->passport_image[$i][$i1];

                if ($file != null) {
                    if (!is_string($file)) {
                        $filename = 'booking_'.$req->name.$id.$i.$i1.'.'.'jpg';
                        $path = './dist/img/booking/'.$guest_leader->party_name;
                        if (!file_exists($path)) {
                            $oldmask = umask(0);
                            mkdir($path, 0777,true);
                            umask($oldmask);
                        }
                        $path = 'dist/img/booking/'.$guest_leader->party_name.'/'. $filename;
                        Image::make(file_get_contents($file))->save($path);  
                        chmod($path, 0755);
                        $path = '/dist/img/booking/'.$guest_leader->party_name.'/'. $filename;
                    }else{
                        $path = $file;
                    }
                }else{
                    DB::rollBack();
                    return Response::json(['status'=>0,'message'=>'There is Passport Image With 0 Value']);
                }
                $data = array(
                            'id'                => $id,
                            'dt'                => $i1+1,
                            'id_booking_d'      => $i+1,
                            'name'              => $room->name[$i][$i1],
                            'passport'          => $room->passport[$i][$i1],
                            'exp_date'          => carbon::parse($room->expired_at[$i][$i1])->format('Y-m-d'),
                            'issuing'           => $room->issuing[$i][$i1],
                            'gender'            => $room->gender[$i][$i1],
                            'birth_date'        => carbon::parse($room->birth_date[$i][$i1])->format('Y-m-d'),
                            'birth_place'       => $room->birth_place[$i][$i1],
                            'remark'            => $room->note[$i][$i1],
                            'type'              => $room->type[$i][$i1],
                            'passport_image'    => $path,
                        );

                $this->model->booking_pax()->create($data);
                $additional_counting = 1;
                for ($i2=0; $i2 < count($room->additional[$i][$i1]); $i2++) { 
                    if ($room->additional[$i][$i1][$i2] != 0) {
                        $data = array(
                                    'id'                => $id,
                                    'id_booking_d'      => $i+1,
                                    'id_booking_pax'    => $i1+1,
                                    'dt'                => $additional_counting,
                                    'additional_id'     => $room->additional[$i][$i1][$i2],
                                );

                        $this->model->booking_additional()->create($data);
                        $additional_counting++;
                    }
                }
            }
        }
        DB::commit();
        return Response::json(['status'=>1,'message'=>'Success Updating Data']);
    }

    public function paymentListDatatable(Request $req,$id)
    {
        $booking = $this->model->booking()->where('kode',$id)->first();

        $data = $this->model->payment_history()->with(['payment_history_d'])->where('booking_id',$booking->id)->paginate($req->showing);


        return response::json(['data'=>$data]);
    }

    public function updatePaymentList(Request $req)
    {
        DB::beginTransaction();

        $this->model->payment_history()->where('id',$req->id)->update(['status_payment'=>$req->status_payment,'updated_by'=>Auth::user()->name]);
        DB::commit();
        return Response::json(['status'=>1,'message'=>'Success Updating Data']);
    }

    public function blogDatatable(Request $req)
    {
        $data = $this->model->blog()->paginate($req->show);
        return Response::json(['data'=>$data]);
    }

    public function saveBlog(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if (!isset($req->id) or $req->id == '' or $req->id == null) {
                if(!Auth::user()->hasAccess('Company','create')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Create This Data']);
                }

                $input = $req->all();
                $id = $this->model->blog()->max('id')+1;

                $file = $req->image;
                if ($file != null) {
                    $filename = 'blog'.'_'.$id.'.'.'jpg';
                    $path = './dist/img/blog';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = 'dist/img/blog/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $filename = '/dist/img/blog/' . $filename;
                }else{
                    $filename = null;
                }

                $input['image'] = $filename;
                $input['id'] = $id;
                $input['created_by'] = Auth::user()->name;
                $input['updated_by'] = Auth::user()->name;
                $this->model->blog()->insert($input);
                return Response::json(['status'=>1,'message'=>'Success saving data']);
            }else{
                if(!Auth::user()->hasAccess('Company','edit')){
                    return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Edit This Data']);
                }

                $input = $req->all();
                unset($input['image']);
                $id = $req->id;
                $file = $req->image;
                if ($file != null) {
                    $filename = 'blog'.'_'.$id.'.'.'jpg';
                    $path = './dist/img/blog/';
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $path = './dist/img/blog/' . $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    chmod($path, 0755);
                    $filename = '/dist/img/blog/' . $filename;
                    $input['image'] = $filename;

                }else{
                    $filename = null;
                }
                $input['updated_by'] = Auth::user()->name;
                $this->model->blog()->where('id',$req->id)->update($input);

                return Response::json(['status'=>1,'message'=>'Success updating data']);
            }
        });
    }

    public function deleteBlog(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            foreach ($req->data['data'] as $i => $d) {
                $this->model->blog()->where('id',$req->data['data'][$i]['id'])->delete();
            }

            return Response::json(['status'=>1,'message'=>'Success deleting data']);
        });
    }

    public function termCondition(Request $req)
    {
        $data = $this->model->term_condition()->first();
        return response::json(['status'=>1,'data'=>$data]);
    }

    public function saveTermCondition (Request $req)
    {
        return DB::transaction(function() use ($req) {  

            if(!Auth::user()->hasAccess('Term And Condition','create')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Save This Data']);
            }

            $data = $this->model->term_condition()->first();

            if ($data == null) {
                $id = $this->model->term_condition()->max('id')+1;
                $this->model->term_condition()->create([
                    'id' => $id,
                    'content' => $req->content,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);
            }

            $input['content'] = $req->content;
            $input['updated_by'] = Auth::user()->name;

            $this->model->term_condition()->where('id',1)->update($input);

            return Response::json(['status'=>1,'message'=>'Success Updating data']);
        });
    }

    public function about(Request $req)
    {
        $data = $this->model->term_condition()->first();
        return response::json(['status'=>1,'data'=>$data]);
    }

    public function saveAbout(Request $req)
    {
        return DB::transaction(function() use ($req) {  
            if(!Auth::user()->hasAccess('About','create')){
                return Response::json(['status'=>0,'message'=>'You Dont Have Authority To Save This Data']);
            }

            $data = $this->model->about()->first();

            if ($data == null) {
                $id = $this->model->about()->max('id')+1;
                $this->model->about()->create([
                    'id' => $id,
                    'content' => $req->content,
                    'created_by' => Auth::user()->name,
                    'updated_by' => Auth::user()->name,
                ]);
            }

            $input['content'] = $req->content;
            $input['updated_by'] = Auth::user()->name;

            $this->model->about()->where('id',1)->update($input);

            return Response::json(['status'=>1,'message'=>'Success Updating data']);
        });
    }

    public function tes()
    {
        $booking = $this->model->booking()
                        ->whereHas('payment_history' => function($q){
                            $q->where(DB::raw("sum(total_payment) !="))
                        })
                        ->get();

        dd($booking);
    }
}
