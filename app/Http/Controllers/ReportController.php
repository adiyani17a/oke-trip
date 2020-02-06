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
use Illuminate\Support\Facades\Mail;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\Hash;
ini_set('post_max_size', '2048MB');
ini_set('upload_max_filesize', '2048MB');
class ReportController extends Controller
{
    protected $model;

	public function __construct()
	{
		$this->model = new models();
	}

	public function incomeReport(Request $req)
	{

		return view('report.income_report.income_report');
	}

	public function datatableAgen(Request $req)
	{

		$data = $this->model->company()
				     ->orderBy('id','ASC')
				     ->get();

		foreach ($data as $i => $d) {
			$data[$i]->total = 0;
			$data[$i]->pax = 0;
			foreach ($d->agen as $i1 => $d1) {
				$booking = $d1->booking->where('created_at','>=',carbon::parse($req->awal)->format('Y-m-d H:i:s'))->where('created_at','<=',carbon::parse($req->akhir)->format('Y-m-d H:i:s'));
				foreach ($booking as $i2 => $d2) {
					if ($d2->payment_history_done() != 0) {
						$data[$i]->total += $d2->total;
						$data[$i]->pax += $d2->booking_pax->count();
					}
				}
			}
		}

		return Datatables::of($data)
	            ->make(true);
	}

	public function getDataDestination(Request $req)
	{
		$data = $this->model->destination()
						->get();
		$dataSets = [];
        foreach ($data as $i => $d) {
        	$dataSets[$i]['labels'] = $d->name;
        	$dataSets[$i]['data'] = 0;
        	if (count($d->itinerary_destination) != 0) {
        		foreach ($d->itinerary_destination as $i1 => $d1) {
        			foreach ($d1->itinerary->itinerary_detail as $i2 => $d2) {
        				if (count($d2->booking) != 0) {
	        				foreach ($d2->booking as $i3 => $d3) {
	        					if (carbon::parse($d3->created_at)->format('Y-m-d') >= carbon::parse($req->start)->format('Y-m-d') and carbon::parse($d3->created_at)->format('Y-m-d') <= carbon::parse($req->end)->format('Y-m-d')) {
	        						if ($d3->payment_history_done() != 0) {
		        						$dataSets[$i]['data']+=$d3->total;
		        					}
	        					}
		        			}
        				}
        			}
        		}
        	}
        }

        return Response::json(['data'=>$dataSets]);
	}
}
