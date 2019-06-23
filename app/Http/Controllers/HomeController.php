<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TokenManagement;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $token = TokenManagement::where('user_id',$user->id)->first()->access_token;
        return view('home',compact('token'));
    }
}
