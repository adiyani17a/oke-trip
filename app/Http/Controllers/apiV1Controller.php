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

class apiV1Controller extends Controller
{
    protected $model;

	public function __construct()
	{
		$this->model = new models();
	}

	public function getDataHome()
	{
		$data['hotDeal'] = $this->model->itinerary()->with(['itinerary_detail'])->where('hot_deals','Y')->where('active','true')->take(4)->get();

		foreach ($data['hotDeal'] as $i => $d) {
			$data['hotDeal'][$i]->itinerary_count = $d->itinerary_detail->count();
			$data['hotDeal'][$i]->itinerary_hot_deal = $d->itinerary_detail->where('hot_deals','Y')->count();
		}

		$data['destination'] = $this->model->destination()->take(6)->get();

		return Response::json($data);
	}
}
