<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TokenManagement;
use Auth;
use App\models;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $model;
    public function __construct()
    {
        $this->middleware('auth');
        $this->model = new models();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $token = generateToken();
        $groupMenu = $this->model->groupMenu()->get();
        dd($groupMenu[0]);
        return view('home',compact('token','groupMenu'));
    }
}
