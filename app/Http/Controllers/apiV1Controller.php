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
use PDF;
use Illuminate\Support\Facades\Hash;
// ini_set('post_max_size', '128MB');
// ini_set('upload_max_filesize', '2048MB');
class apiV1Controller extends Controller
{
    protected $model;

	public function __construct()
	{
		$this->model = new models();
	}

	public function getData()
    {
        $data =  $this->model->booking()->with(['users','handle','payment_history'])->orderBy('created_at','ASC')->get();
        $itinerary =  $this->model->itinerary_detail()
        				   ->whereHas('payment_history')
        				   ->with(['payment_history','users'])->orderBy('created_at','ASC')->get();

        return Response::json(['data'=>$data,'itinerary'=>$itinerary]);
    }

	public function getDataHome(Request $req)
	{

		$users_id = $req->users_id;
		$now = carbon::now()->format('Y-m-d');
		$data['hotDeal'] = $this->model->itinerary()->with(['itinerary_detail'=>function($q) use ($now){
									$q->where('start','>=',$now);
								}])
								->whereHas('itinerary_detail',function($q) use ($now,$users_id){
									$q->where('start','>=',$now);
									$q->where('booked_by',null);
									if ($users_id != 'undefined') {
										$q->orWhere('booked_by',$users_id);
									}
								})
								->where('hot_deals','Y')->where('active','true')->take(4)->get();
		$data['destination'] = $this->model->destination()->with(['itinerary_destination'])->take(6)->get();
		$data['carousel'] = $this->model->carousel()->first();
        $data['blog'] = $this->model->blog()->get();


        foreach ($data['blog'] as $key => $value) {
        	$data['blog'][$key]->date = carbon::parse($value->created_at)->format('F d, Y');
        }

		foreach ($data['destination'] as $i => $d) {
			if (count($d->itinerary_destination) != 0) {
				$data['destination'][$i]->total_data = $d->itinerary_destination->count(); 
				$data['destination'][$i]->total_hot_deals = 0;
				
				foreach ($d->itinerary_destination as $i1 => $d1) {
					if ($d1->itinerary != null) {
						if ($d1->itinerary->where('hot_deals','Y') != null ) {
							$data['destination'][$i]->total_hot_deals += 1; 
						}
					}
				}
			}else{
				$data['destination'][$i]->total_data = 0;
				$data['destination'][$i]->total_hot_deals = 0;

			}
		}


		return Response::json($data);
	}

	public function getItineraryDetail(Request $req,$id)
	{

		$users_id = $req->users_id;
		$now = carbon::now()->format('Y-m-d');
		$data = $this->model->itinerary()->with(['itinerary_detail'=> function($q) use ($now,$users_id){
											$q->where('start','>=',$now);
											$q->where('booked_by',null);
											$q->where('seat_remain','>',0);
											if ($users_id != 'undefined') {
												$q->orWhere('booked_by',$users_id);
											}
										},'itinerary_destination' => function($q){
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
		DB::beginTransaction();
		$room = json_decode($req->room);
		$guest_leader = json_decode($req->guest_leader);
		$pricing = json_decode($req->pricing);
		$itinerary_detail = json_decode($req->data);

		// save booking


		$total_pax = 0;
		$total_pax = $pricing[0]->value + $pricing[1]->value + $pricing[2]->value + $pricing[3]->value;
		$remain = $this->model->itinerary_detail()->where('code',$itinerary_detail->code)->first();

		if ($remain->seat_remain < $total_pax) {
			DB::rollBack();
			return Response::json(['status'=>0,'message'=>'Sorry the pax available only '.$remain->seat_remain.', please call customer service for further information']);
		}
		$this->model->itinerary_detail()->where('code',$itinerary_detail->code)
			->update([
				'seat_remain' => DB::raw("seat_remain - '$total_pax'")
			]);

		$id = $this->model->booking()->max('id')+1;

		$day = Carbon::now()->format('dmy');
		$kode = 'BK'.$day.str_pad($id, 3, '0', STR_PAD_LEFT);

		$total_additional = 0;
		for ($i=0; $i < (count($pricing)-9); $i++) { 
			$total_additional += $pricing[$i+9]->nominal;
		}

		$data = array(
					'id'					=> $id,
					'kode'					=> $kode,
					'users_id'				=> $req->id_user,
					'telp'					=> $guest_leader->telp,
					'itinerary_code'		=> $itinerary_detail->code,
					'status'				=> 'Waiting List',
					'name'					=> $guest_leader->party_name,
					'total_adult'			=> $pricing[0]->nominal,
					'total_child_no_bed'	=> $pricing[1]->nominal,
					'total_child_with_bed'	=> $pricing[2]->nominal,
					'total_infant'			=> $pricing[3]->nominal,
					'agent_com'				=> $pricing[4]->nominal,
					'staff_com'				=> $pricing[5]->nominal,
					'tips'					=> $pricing[6]->nominal,
					'visa'					=> $pricing[7]->nominal,
					'tax'					=> $pricing[8]->nominal,
					'remark'				=> $req->remark,
					'total_additional'		=> $total_additional,
					'total_room'			=> $guest_leader->total_room,
					'total'					=> $req->total,
					'handle_by'				=> 0,
					'created_by'			=> $req->created_by,
					'updated_by'			=> $req->created_by,
					'created_at'			=> carbon::now(),
					'updated_at'			=> carbon::now(),
				);

		$this->model->booking()->insert($data);


		$image_index = 0;

		for ($i=0; $i < $guest_leader->total_room; $i++) { 
			$data = array(
						'id'			=> $id,
						'dt'			=> $i+1,
						'bed'			=> $room->bed[$i],
						'total_bed'		=> $room->total_bed[$i],
					);

			$this->model->booking_d()->insert($data);

			for ($i1=0; $i1 < count($room->name[$i]); $i1++) { 

				$file = $req->passport_image[$image_index];

                if ($file != null) {
                    $filename = 'booking_'.$req->name.$id.$i.$i1.$image_index.'.'.'jpg';
                    $path = './dist/img/booking/'.$guest_leader->party_name;
                    if (!file_exists($path)) {
                    	$oldmask = umask(0);
                        mkdir($path, 0777,true);
                        umask($oldmask);
                    }
                    $path = 'dist/img/booking/'.$guest_leader->party_name.'/'. $filename;
                    Image::make(file_get_contents($file))->save($path);  
                    $path = '/dist/img/booking/'.$guest_leader->party_name.'/'. $filename;
                }else{
					DB::rollBack();
                    return Response::json(['status'=>0,'message'=>'There is Passport Image With 0 Value']);
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
							'birth_date'		=> carbon::parse($room->date_birth[$i][$i1])->format('Y-m-d'),
							'birth_place'		=> $room->place_birth[$i][$i1],
							'remark'			=> $room->note[$i][$i1],
							'type'				=> $room->type[$i][$i1],
							'passport_image'	=> $path,
						);

				$this->model->booking_pax()->insert($data);
				$image_index++;
				$additional_counting = 1;
				for ($i2=0; $i2 < count($room->additional[$i][$i1]); $i2++) { 
					if (count($room->additional[$i][$i1][$i2]) != 0) {
						$data = array(
									'id'				=> $id,
									'id_booking_d'		=> $i+1,
									'id_booking_pax'	=> $i1+1,
									'dt'				=> $additional_counting,
									'additional_id'		=> $room->additional[$i][$i1][$i2][0],
								);


						$this->model->booking_additional()->insert($data);
						$additional_counting++;
					}
				}
			}
		}


        $d = $this->model->booking()->where('id',$id)->first();

        $id = $this->model->log_itinerary_detail()->max('id')+1;
        $data = array(
                    'id' => $id,
                    'booking_id' => $d->id,
                    'code' => $d->itinerary_detail->code,
                    'seat' => $d->itinerary_detail->seat,
                    'seat_remain' => $d->itinerary_detail->seat_remain,
                    'start' => $d->itinerary_detail->start,
                    'end' =>  $d->itinerary_detail->end,
                    'adult_price' => $d->itinerary_detail->adult_price,
                    'child_price' => $d->itinerary_detail->child_price,
                    'child_bed_price' => $d->itinerary_detail->child_bed_price,
                    'infant_price' => $d->itinerary_detail->infant_price,
                    'minimal_dp' => $d->itinerary_detail->minimal_dp,
                    'agent_com' => $d->itinerary_detail->agent_com,
                    'staff_com' => $d->itinerary_detail->staff_com,
                    'agent_tip' => $d->itinerary_detail->agent_tip,
                    'agent_visa' => $d->itinerary_detail->agent_visa,
                    'agent_tax' => $d->itinerary_detail->agent_tax,
                    'created_by' => $d->itinerary_detail->created_by,
                    'updated_by' => $d->itinerary_detail->updated_by,
                );

        $this->model->log_itinerary_detail()->create($data);

		DB::commit();
        return Response::json(['status'=>1,'message'=>'Success Saving Data','code'=>$kode,'id'=>$id]);
	}

	public function getBookingList(Request $req)
	{

		$check_token = $this->model->token_management()->where('access_token',$req->token)->first();

		if ($check_token != null) {
			$last_login = strtotime(carbon::parse($check_token->created_at)->format('Y-m-d H:i:s'))+$check_token->last_activity;
			$now = strtotime(carbon::now()->format('Y-m-d H:i:s'));
			if ($last_login < $now) {
				$this->model->token_management()->where('access_token',$req->token)->delete();
				return response::json(['status'=>403,'message'=>'Token Expired']);
			}else{
				$time_remaining = $last_login - $now;
			}
		}else{
				return response::json(['status'=>401,'message'=>'Unauthorized']);
		}

		$data = $this->model->booking()
					 ->where('users_id',$req->user_id)
					 ->with(['booking_d'=>function($q){
					 	$q->with(['booking_pax'=>function($q1){
					 		$q1->with(['booking_additional'=>function($q2){
					 			$q2->with(['additional']);
					 		}]);
					 	}]);
					 },'payment_history'=>function($q){
					 	$q->with(['payment_history_d']);
					 },'users','handle','log_itinerary_detail','itinerary_detail'=>function($q){
					 	$q->with(['payment_history']);
					 }])
					 ->get();


		$itinerary = $this->model->itinerary_detail()
					 ->where('booked_by',$req->user_id)
					 ->with(['payment_history'])
					 ->get();


		foreach ($itinerary as $i => $d) {
			$itinerary[$i]->date_start = carbon::parse($d->start)->format('d/m/Y');
			$itinerary[$i]->date_end = carbon::parse($d->end)->format('d/m/Y');
			$itinerary[$i]->expired = carbon::parse($d->booked_at)->subDay(-7)->format('Y-m-d');
		}
		
		return response::json(['status'=>200,'data'=>$data,'itinerary'=>$itinerary,'time_remaining'=>$time_remaining]);
	}

	public function getBookingListDetail(Request $req,$id)
	{

		$check_token = $this->model->token_management()->where('access_token',$req->token)->first();

		if ($check_token != null) {
			$last_login = strtotime(carbon::parse($check_token->created_at)->format('Y-m-d H:i:s'))+$check_token->last_activity;
			$now = strtotime(carbon::now()->format('Y-m-d H:i:s'));
			if ($last_login < $now) {
				$this->model->token_management()->where('access_token',$req->token)->delete();
				return response::json(['status'=>403,'message'=>'Token Expired']);
			}else{
				$time_remaining = $last_login - $now;
			}
		}else{
				return response::json(['status'=>401,'message'=>'Unauthorized']);
		}

		$data['data'] = $this->model->booking()	
					 ->where('id',$id)
					 ->where('users_id',$req->user_id)
					 ->with(['booking_d'=>function($q){
					 	$q->with(['booking_pax'=>function($q1){
					 		$q1->with(['booking_additional'=>function($q2){
					 			$q2->with(['additional']);
					 		}]);
					 	}]);
					 },'payment_history'=>function($q){
					 	$q->with(['payment_history_d']);
					 },'users','handle','itinerary_detail'=>function($q){
					 	$q->with(['itinerary','payment_history']);
					 }])
					 ->first();

		$data['invoice_list'] = [];
		$main_list = ['Adult','Child With Bed','Child No Bed','Infant','Agent Com','Staff Com','Tips','Visa','Apt Tax And Surcharge'];
		$temp = [];

		foreach ($main_list as $i => $d) {
			$temp['name'] = $main_list[$i];
			$temp['type'] = $main_list[$i];
			$temp['chargePerAmount'] = 0;
			if ($data['data']->itinerary_detail != null) {
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
			}
			$temp['nominal'] = 0;
			$temp['value'] = 0;
			array_push($data['invoice_list'], $temp);
		}

		if ($data['data']->itinerary_detail != null) {
			foreach ($data['data']->itinerary_detail->itinerary->itinerary_additional as $i => $d) {
				$temp['name'] = $d->additional->name;
				$temp['type'] = $d->additional->id;
				$temp['chargePerAmount'] = $d->additional->price;
				$temp['nominal'] = 0;
				$temp['value'] = 0;

				array_push($data['invoice_list'], $temp);
			}
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
						if ($d3->additional != null) {
							if ($data['invoice_list'][$i]['type'] == $d3->additional->id) {
								$data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
								$data['invoice_list'][$i]['value'] += 1;
							}
						}
					}
				}
			}
		}


		return response::json(['status'=>200,'data'=>$data,'time_remaining'=>$time_remaining]);
	}

	public function bookingListPdfPax($id)
	{
		$data = $this->model->booking()	
					 ->where('id',$id)
					 ->with(['booking_d'=>function($q){
					 	$q->with(['booking_pax'=>function($q1){
					 		$q1->with(['booking_additional'=>function($q2){
					 			$q2->with(['additional']);
					 		}]);
					 	}]);
					 },'payment_history'=>function($q){
					 	$q->with(['payment_history_d']);
					 },'users','handle','itinerary_detail'=>function($q){
					 	$q->with(['itinerary']);
					 }])
					 ->first();

		$pdf = PDF::loadView('customer', ['data' => $data]);
		return $pdf->stream();
	}

	public function bookingListPdfInvoice($id)
	{
		$data['data'] = $this->model->booking()	
					 ->where('id',$id)
					 ->with(['booking_d'=>function($q){
					 	$q->with(['booking_pax'=>function($q1){
					 		$q1->with(['booking_additional'=>function($q2){
					 			$q2->with(['additional']);
					 		}]);
					 	}]);
					 },'payment_history'=>function($q){
					 	$q->with(['payment_history_d']);
					 },'users','handle','itinerary_detail'=>function($q){
					 	$q->with(['itinerary']);
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

					foreach ($d2->booking_additional as $i3 => $d3) {
						if ($data['invoice_list'][$i]['type'] == $d3->additional->id) {
							$data['invoice_list'][$i]['nominal'] += $data['invoice_list'][$i]['chargePerAmount'];
							$data['invoice_list'][$i]['value'] += 1;
						}
					}
				}
			}
		}
		$pdf = PDF::loadView('invoice', ['data' => $data]);
		return $pdf->stream();
	}

	public function payment(Request $req,$id)
	{
		$check_token = $this->model->token_management()->where('access_token',$req->token)->first();

		if ($check_token != null) {
			$last_login = strtotime(carbon::parse($check_token->created_at)->format('Y-m-d H:i:s'))+$check_token->last_activity;
			$now = strtotime(carbon::now()->format('Y-m-d H:i:s'));
			if ($last_login < $now) {
				$this->model->token_management()->where('access_token',$req->token)->delete();
				return response::json(['status'=>403,'message'=>'Token Expired']);
			}else{
				$time_remaining = $last_login - $now;
			}
		}else{
				return response::json(['status'=>401,'message'=>'Unauthorized']);
		}


		$index = $this->model->payment_history()->max('id')+1;

		$day = Carbon::now()->format('dmy');
		$data['code'] = 'P'.$day.str_pad($index, 5, '0', STR_PAD_LEFT);
		$data['date'] = carbon::now()->format('d F Y');

		$data['data'] = $this->model->booking()	
					 ->where('id',$id)
					 ->where('users_id',$req->user_id)
					 ->with(['booking_d'=>function($q){
					 	$q->with(['booking_pax'=>function($q1){
					 		$q1->with(['booking_additional'=>function($q2){
					 			$q2->with(['additional']);
					 		}]);
					 	}]);
					 },'payment_history'=>function($q){
					 	$q->with(['payment_history_d']);
					 },'users','handle','itinerary_detail'=>function($q){
					 	$q->with(['itinerary','payment_history']);
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


		$data['dp'] = 0;

		foreach ($data['invoice_list'] as $i => $d) {
			foreach ($data['data']->booking_d as $i1 => $d1) {
				foreach ($d1->booking_pax as $i2 => $d2) {
					if ($d2->type == $data['invoice_list'][$i]['name']) {
						$data['dp']+= $data['data']->itinerary_detail->minimal_dp;
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


		return response::json(['status'=>200,'data'=>$data,'time_remaining'=>$time_remaining]);
	}

	public function paymentSave(Request $req)
	{
		DB::beginTransaction();

		$id = $this->model->payment_history()->max('id')+1;

		$day = Carbon::now()->format('dmy');
		$code = 'P'.$day.str_pad($id, 5, '0', STR_PAD_LEFT);

		$data = array(
					'id' => $id,
					'code' =>$code,
					'total_payment' => $req->total_payment,
					'payment_method' =>$req->payment_method,
					'status_payment' =>'Pending',
					'type' =>$req->type,
					'created_by' => $req->created_by, 
					'updated_by' => $req->created_by, 
				);

		if ($req->type == 'ITINERARY') {
			$data['itinerary_code'] = $req->booking_id;
		}else{
			$data['booking_id'] = $req->booking_id;
		}

		$this->model->payment_history()->insert($data);


		for ($i=0; $i < count($req->account_name); $i++) { 


			$file = $req->payment_proof[$i];

            if ($file != null) {
                $filename = 'payment_'.$id.$i.$req->account_number[$i].'.'.'jpg';
                $path = './dist/img/payment/';
                if (!file_exists($path)) {
                	$oldmask = umask(0);
                    mkdir($path, 0777,true);
                    umask($oldmask);
                }
                $path = 'dist/img/payment/'. $filename;
                Image::make(file_get_contents($file))->save($path);  
                $path = '/dist/img/payment/'. $filename;
            }else{
				DB::rollBack();
                return Response::json(['status'=>0,'message'=>'There is Payment Proof Image With 0 Value']);
            }

			$data = array(
					'id' => $id,
					'dt' => $i+1,
					'bank' => $req->bank_name[$i],
					'nominal'=> $req->nominal[$i],
					'account_name' => $req->account_name[$i],
					'account_number' =>$req->account_number[$i],
					'image' => $path,
					'created_at' => carbon::now(),
					'date' => carbon::parse($req->date[$i])->format('Y-m-d')
				);

			$this->model->payment_history_d()->insert($data);
		}

		DB::commit();

        return Response::json(['status'=>1,'message'=>'Success Saving Data','code'=>$code]);
	}

	public function getDataItinerary(Request $req)
	{

		if ($req->price != 'All Range Value') {
			$price = explode('-', $req->price);
		}else{
			$price = '';
		}
		if (!isset($req->date)) {
			$date['startDate'] = null;
			$date['endDate'] = null;
		}else{
			$date['startDate'] = carbon::parse($req->date[0])->format('Y-m-d');
			$date['endDate'] = carbon::parse($req->date[1])->format('Y-m-d');
		}

		$country = $req->country;
		$users_id = $req->users_id;
		$data = $this->model->itinerary()
				->with(['itinerary_detail'])
				->whereHas('itinerary_destination',function($q) use ($country){
					if (count($country) != 0) {
						foreach ($country as $i => $d) {
							if ($i == 0) {
								$q->where('destination_id',$country[$i]);
							}else{
								$q->orWhere('destination_id',$country[$i]);
							}
						}
					}
				})
				->whereHas('itinerary_detail',function($q) use ($price,$date,$users_id){
					if ($price != '') {
						$q->where('adult_price','>=',filter_var($price[0],FILTER_SANITIZE_NUMBER_INT));
						$q->where('adult_price','<=',filter_var($price[1],FILTER_SANITIZE_NUMBER_INT));
					}

					if ($date['startDate'] != null) {
						$q->where('start','>=',$date['startDate']);
						$q->where('end','<=',$date['endDate']);
					}
					$q->where('seat_remain','>',0);
					$q->where(function($q1) use ($users_id){
						$q1->Where('booked_by',null);
						$q1->orWhere('booked_by',$users_id);
					});
				})
				->get();
		

		$country = $this->model->destination()->where('active','true')->get();


		return response::json(['status'=>200,'data'=>$data,'country'=>$country]);
	}

	public function getPartner(Request $req)
	{
		if ($req->city == 'null' or $req->city == null or $req->city == '') {
			$data = $this->model->company()->where('active','true')->get();
		}else{
			$data = $this->model->company()->where('city_id',$req->city)->where('active','true')->get();
		}

		$city = $this->model->city()->get();

		return response::json(['status'=>200,'data'=>$data,'city'=>$city]);
	}

	public function getBlog(Request $req)
	{
		$data = $this->model->blog()->get();

		return response::json(['status'=>200,'data'=>$data]);
	}

	public function getBlogData(Request $req,$id)
	{
		$data = $this->model->blog()->where('id',$id)->first();

		$data->date = carbon::parse($data->created_at)->format('F d, Y');

		return response::json(['status'=>200,'data'=>$data]);
	}

	public function paymentItinerary(Request $req)
	{
		$check_token = $this->model->token_management()->where('access_token',$req->token)->first();

		if ($check_token != null) {
			$last_login = strtotime(carbon::parse($check_token->created_at)->format('Y-m-d H:i:s'))+$check_token->last_activity;
			$now = strtotime(carbon::now()->format('Y-m-d H:i:s'));
			if ($last_login < $now) {
				$this->model->token_management()->where('access_token',$req->token)->delete();
				return response::json(['status'=>403,'message'=>'Token Expired']);
			}else{
				$time_remaining = $last_login - $now;
			}
		}else{
				return response::json(['status'=>401,'message'=>'Unauthorized']);
		}


		$index = $this->model->payment_history()->max('id')+1;

		$day = Carbon::now()->format('dmy');
		$data['code'] = 'P'.$day.str_pad($index, 5, '0', STR_PAD_LEFT);
		$data['date'] = carbon::now()->format('d F Y');

		$data['data'] = $this->model->itinerary_detail()
					 ->where('booked_by',$req->user_id)
					 ->where('code',$req->code)
					 ->with(['payment_history'])
					 ->first();


		return response::json(['status'=>200,'data'=>$data,'time_remaining'=>$time_remaining]);
	}

	public function getAbout()
	{
		$data = $this->model->about()->first();

		return response::json(['status'=>200,'data'=>$data]);
	}

	public function getTermCondition()
	{
		$data = $this->model->term_condition()->first();

		return response::json(['status'=>200,'data'=>$data]);
	}
}
