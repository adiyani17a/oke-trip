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
	        					if ($d3->payment_history_done() != 0) {
	        						$dataSets[$i]['data']+=$d3->total;
	        					}
		        			}
        				}
        			}
        		}
        	}
        }
		return view('report.income_report.income_report',compact('dataSets'));
	}
}
