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
		$data['destination'] = $this->model->destination()->with(['itinerary_destination'])->take(6)->get();
		$data['carousel'] = $this->model->carousel()->first();

		foreach ($data['destination'] as $i => $d) {
			if (count($d->itinerary_destination) != 0) {
				$data['destination'][$i]->total_data = $d->itinerary_destination->count(); 
				$data['destination'][$i]->total_hot_deals = 0;
				foreach ($d->itinerary_destination as $i1 => $d1) {
					if ($d1->itinerary->where('hot_deals','Y') != null ) {
						$data['destination'][$i]->total_hot_deals += 1; 
					}
				}
			}else{
				$data['destination'][$i]->total_data = 0;
				$data['destination'][$i]->total_hot_deals = 0;

			}
		}


		return Response::json($data);
	}

	public function getItineraryDetail($id)
	{
		$data = $this->model->itinerary()->with(['itinerary_detail','itinerary_destination' => function($q){
											$q->with(['destination']);
										},'itinerary_flight','itinerary_schedule','itinerary_additional'=> function($q){
											$q->with(['additional']);
										}])->where('id',$id)
										->first();
		return Response::json($data);
	}

	public function getBooking($id,$dt)
	{
		$data = $this->model->itinerary_detail()->with(['itinerary'=>function($q){
												$q->with(['itinerary_destination'=>function($q1){
													$q1->with(['destination']);
												},'itinerary_additional'=>function($q1){
													$q1->with(['additional']);
												}]);
											   }])->where('id',$id)->where('dt',$dt)->first();


		return Response::json($data);
	}

	public function saveBooking(Request $req)
	{

    	return DB::transaction(function() use ($req) {  
			$room = json_decode($req->room);
			$guest_leader = json_decode($req->guest_leader);
			$pricing = json_decode($req->pricing);
			$data = json_decode($req->data);

			// save booking

			$id = $this->model->booking()->max('id')+1;

			$day = Carbon::now()->format('dmy');
			$kode = 'BK'.$day.str_pad($id, 3, '0', STR_PAD_LEFT);

			$total_additional = 0;
			for ($i=0; $i < (count($pricing)-4); $i++) { 
				$total_additional += $pricing[$i+4]->nominal;
			}

			$data = array(
						'id'					=> $id,
						'kode'					=> $kode,
						'users_id'				=> 1,
						'telp'					=> $guest_leader->telp,
						'itinerary_id'			=> $data->code,
						'status'				=> 'Waiting List',
						'name'					=> $guest_leader->party_name,
						'total_adult'			=> $pricing[0]->nominal,
						'total_child_no_bed'	=> $pricing[1]->nominal,
						'total_child_with_bed'	=> $pricing[2]->nominal,
						'total_infant'			=> $pricing[3]->nominal,
						'remark'				=> $req->remark,
						'total_additional'		=> $total_additional,
						'total_room'			=> $guest_leader->total_room,
						'tax'					=> 0,
						'visa'					=> 0,
						'agent_com'				=> 0,
						'tips'					=> 0,
						'total'					=> $req->total,
						'handle_by'				=> 0,
						'created_by'			=> '-',
						'updated_by'			=> '-',
						'created_at'			=> carbon::now(),
						'updated_at'			=> carbon::now(),
					);

			$this->model->booking()->create($data);
			$image_counting = 0;

			dd($req->passport_image);
			for ($i=0; $i < $guest_leader->total_room; $i++) { 
				$data = array(
							'id'			=> $id,
							'dt'			=> $i+1,
							'bed'			=> $room->bed[$i],
							'total_bed'		=> $room->total_bed[$i],
						);

				$this->model->booking_d()->create($data);

				for ($i1=0; $i1 < $room->name[$i]; $i1++) { 

					$file = $req->image;
	                if ($file != null) {
	                    $filename = 'destination_'.$req->name.'.'.'jpg';
	                    $path = './dist/img/destination';
	                    if (!file_exists($path)) {
	                        mkdir($path, 777, true);
	                    }
	                    $path = 'dist/img/destination/' . $filename;
	                    Image::make(file_get_contents($file))->save($path);  
	                    $path = '/dist/img/destination/' . $filename;
	                }else{
	                    $filename = null;
	                }

					$data = array(
								'id'				=> $id,
								'dt'				=> $i1+1,
								'id_booking_d'		=> $i+1,
								'name'				=> $room->name[$i][$i1],
								'passport'			=> $room->passport[$i][$i1],
								'exp_date'			=> carbon::parse($room->expired_at[$i][$i1])->format('Y-m-d'),
								'issuing'			=> $room->issuing[$i][$i1],
								'gender'			=> $room->gender[$i][$i1],
								'birth_date'		=> $room->birth_date[$i][$i1],
								'birth_place'		=> $room->birth_place[$i][$i1],
								'remark'			=> $room->remark[$i][$i1],
								'type'				=> $room->type[$i][$i1],
							);
				}
			}
		});
	}
}
