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

		$data  	  = $dataraw->get();
		$vehicles = VehicleMast::pluckactives();
		$sites 	  = sites::activesitespluck(); 
		$plants   = PlantMast::pluckactives(); 

		if(!empty($request->export_to_excel)){
			EntryMast::ExportManual($data);
			// $str = ",,,,,,,,Vehicle Wise Challans Generated";
			// $str .= "\n"; 
			// $str .= ",,,,,,,From Date , ";
			// $str .= $from_date.',';
			// $str .= "To Date ,";
			// $str .= $to_date;
			// if(!empty($request->vehicle)){
			// 	if(!empty($vehicles[$request->vehicle])){
			// 		$str .= ",".$vehicles[$request->vehicle];
			// 	}
			// }
			// $str .= "\n";
			// $str .= "\n";

			// $str .= 'S.no , Slip No , Weighbridge Slip No , Vehicle Number , Tare Weight , Loading Site , Unloading Site , Loading Plant , Dispatch Date ';
			// $str .= "\n";
			// if(!empty($data)){
			// 	foreach ($data as $key => $value) {
			// 		$str .= $key + 1; $str.= ",";
			// 		$str .= !empty( $value->slip_no ) ? $value->slip_no : ''; $str.= ",";
			// 		$str .= !empty( $value->kanta_slip_no ) ? $value->kanta_slip_no : ''; $str.= ",";
			// 		$str .= !empty( $vehicles[ $value->vehicle ] ) ? $vehicles[ $value->vehicle ] : ''; $str.= ",";  
			// 		$str .= !empty( $value->entry_weight ) ? $value->entry_weight : ''; $str.= ",";
			// 		$str .= !empty( $sites[ $value->site ] ) ? $sites[ $value->site ] : ''; $str.= ",";					
			// 		$str .= !empty( $sites[ $value->owner_site ] ) ? $sites[ $value->owner_site ] : ''; $str.= ",";
			// 		$str .= !empty( $plants[ $value->plant ] ) ? $plants[ $value->plant ] : ''; $str.= ",";
			// 		$str .= !empty( $value->generation_time ) ? date('d-m-Y' , strtotime( $value->generation_time )) : '';$str.= ",";
			// 		$str .= "\n";
			// 	}
			// }
			// header("Content-type: text/csv");
   //          header("Content-Disposition: attachment; filename=VehicleWiseChallans.csv");
   //          header("Pragma: no-cache");
   //          header("Expires: 0");
   //          echo $str;
   //          die();
		}

		return view('Reports.vehicle_wise_challans' , [
			'data'	    => $data,
			'vehicles'  => $vehicles,
			'sites'	    => $sites,
			'plants'    => $plants,
			'from_date' => $from_date,
			'to_date'   => $to_date
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
