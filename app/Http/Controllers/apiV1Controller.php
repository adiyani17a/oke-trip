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
		$data['destination'] = $this->model->destination()->take(6)->get();

		foreach ($data['hotDeal'] as $i => $d) {
			$data['hotDeal'][$i]->destination = explode(',', $d->destination_id);
		}
		// dd($data['hotDeal']);
		foreach ($data['destination'] as $i => $d) {
			$itinerary = explode(',', $d->destination_id);
			dd($itinerary);

			foreach ($variable as $key => $value) {
				# code...
			}
			$data['hotDeal'][$i]->itinerary_count = $d->itinerary->count();
			$data['hotDeal'][$i]->itinerary_hot_deal = $d->itinerary->where('hot_deals','Y')->count();
		}


		return Response::json($data);
	}
}
