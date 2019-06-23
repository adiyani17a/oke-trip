<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
use App\User;
use App\TokenManagement;
class ApiTokenController extends Controller
{
    public function generateToken(Request $request){
    	//expect request : email + password.
    	//if fail will return json response
    	$validate = Validator::make($request->all(), [
    		'email' => 'required|email',
    		'password' => 'required|string'
    	]);

    	if($validate->fails()){
    		//kalau ada salah input, tampilkan error dalam format json
    		return [
    			'error' => $validate->errors(),
    			'data' => false
    		];
    	}

    	//cek email
    	$cekUser = User::where('email', $request->email)->first();

    	if(empty($cekUser)){
    		return [
    			'error' => 'Email not found',
    			'data' => false
    		];
    	}

    	//cek password
    	if(!password_verify($request->password, $cekUser->password)){
    		return [
    			'error' => 'Invalid password provided',
    			'data' => false
    		];
    	}

    	//setelah melewati semua filter diatas, artinya email dan password sudah benar. 
    	$tokenInstance = $this->registerToken($cekUser);
    	return [
    		'error' => false,
    		'data' => $tokenInstance
    	];
    }

    protected function registerToken(User $user){
    	//generate custom hash sebagai auth token
    	$generated_token = base64_encode(sha1(rand(1, 10000) . uniqid() . time()));
    	//manage token ini akan expired dalam jangka waktu berapa lama
    	$expired = date('Y-m-d H:i:s', strtotime('+1 day'));

    	//proses simpan token ke database
    	$tokenInstance = new TokenManagement;
    	$tokenInstance->user_id = $user->id;
    	$tokenInstance->access_token = $generated_token;
    	$tokenInstance->expired_at = $expired;
    	$tokenInstance->is_active = 1;
    	$tokenInstance->save();

    	//setelah token direcord ke database, kembalikan nilai token ke response
    	return $tokenInstance;
    }
}
