<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryMast;
use App\Models\VendorMast;
use App\Models\PlantMast;
use App\Models\SupervisorMast;
use App\Models\VehicleMast;
use App\Models\ItemMast;
use App\Models\sites;
use App\Models\ExportData as CSV;
use Session;
use PDF;
use Auth;

class ReportController extends Controller
{
	public function __construct(){
		$this->view = 'Reports';
	}
   public function retunrnhnadler(Request $request , $name){
   		if($name == 'VehicleWiseChallans'){
   			return $this->VehicleWiseChallans($request);
   			die();
   		}
   		if($name == 'UnloadingPlaceWiseSummary'){
   			return $this->unloadingWiseChallans($request);
   			die();
   		}   		
   }
	
	static function VehicleWiseChallans($request){

		$dataraw = EntryMast::where('delete_status' , 0);
		$from_date = !empty($request->from_date) ? $request->from_date : date('Y-m-d' ,strtotime('-7 days'));
		$to_date = !empty($request->to_date) ? $request->to_date : date('Y-m-d');

		$dataraw->whereRaw("date_format(entry_mast.datetime,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.datetime,'%Y-%m-%d')<='$to_date'");

		if(isset($request->slip_no)){
			$dataraw->where('slip_no' , $request->slip_no);
		}
		if(!empty($request->kanta_slip_no)){
			$dataraw->where('kanta_slip_no' , $request->kanta_slip_no);			
		}
		if(!empty($request->vehicle)){
			$dataraw->where('vehicle' , $request->vehicle);
		}
		if(!empty($request->vendor)){
			$dataraw->where('vendor_id', $request->vendor);
		}
		if(!empty($request->export_to_excel)){
			EntryMast::ExportManual($dataraw->get());
		}
		$data  	  = $dataraw->paginate(10);
		$vehicles = VehicleMast::pluckactives();
		$sites 	  = sites::activesitespluck(); 
		$plants   = PlantMast::pluckactives(); 
		$supervisors = SupervisorMast::pluckactives();
		$vendors  = VendorMast::pluckactives();

		return view('Reports.vehicle_wise_challans' , [
			'data'	      => $data,
			'vehicles'    => $vehicles,
			'sites'	      => $sites,
			'supervisors' => $supervisors,
			'plants'      => $plants,
			'vendors'     => $vendors,
			'from_date'   => $from_date,
			'to_date'     => $to_date
		]);
	}
	static function unloadingWiseChallans($request){
		$dataraw = EntryMast::where('delete_status' , 0);
		$from_date = !empty($request->from_date) ? $request->from_date : date('Y-m-d' ,strtotime('-7 days'));
		$to_date = !empty($request->to_date) ? $request->to_date : date('Y-m-d');

		$dataraw->whereRaw("date_format(entry_mast.datetime,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.datetime,'%Y-%m-%d')<='$to_date'");

		$data = $dataraw->get();

		return view( $this->view.'.UnloadingPlaceWise' , [
			'from_date' => $from_date,
			'to_date'   => $to_date,
			'data'      => $data
		]);			
	}
}
