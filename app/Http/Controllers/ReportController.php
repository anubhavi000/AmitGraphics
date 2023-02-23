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
use App\Models\User;
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
   		if($name == 'VendorWiseSummary'){
   			return $this->VendorWiseSummary($request);
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
		if(isset($request->item)){
			$arr = [$request->item];
			$json = json_encode($arr);
			$dataraw->where('items_included' , $json);
		}
		if(isset($request->site)){
			$dataraw->where('site'  , $request->site);
		}
		if(isset($request->plant)){
			$dataraw->where('plant' , $request->plant);
		}
		if(!empty($request->export_to_excel)){
			EntryMast::ExportManual($dataraw->get());
		}
		$data  	  = $dataraw->paginate(10);
		$vehicles = VehicleMast::pluckactives();
		$sites 	  = sites::activesitespluck(); 
		$items    = ItemMast::pluckactives();
		$plants   = PlantMast::pluckactives(); 
		$supervisors = SupervisorMast::pluckactives();
		$dealerssites = sites::dealersitespluck();
		$vendors  = VendorMast::pluckactives();
        $users = User::pluckall();

		return view('Reports.vehicle_wise_challans' , [
			'data'	      => $data,
			'vehicles'    => $vehicles,
			'sites'	      => $sites,
			'users'		  => $users,
			'items'		  => $items,
			'supervisors' => $supervisors,
			'dealer_sites'=> $dealerssites,
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
		if(isset($request->slip_no)){
			$dataraw->where('slip_no' , $request->slip_no);
		}
		if(isset($request->kanta_slip_no)){
			$dataraw->where('kanta_slip_no' , $request->kanta_slip_no);
		}
		if(isset($request->vehicle)){
			$dataraw->where('vehicle' , $request->vehicle);
		}
		if(isset($request->item)){
			$arr = [$request->item];
			$json = json_encode($arr);
			$dataraw->where('items_included' , $json);
		}
		if(isset($request->site)){
			$dataraw->where('site' , $request->site);
		}
		if(isset($request->plant)){
			$dataraw->where('plant' , $request->plant);
		}
		$dataraw->whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'");
		if(!empty($request->export_to_excel)){
			EntryMast::ExportManual($dataraw->get());
		}
		$data = $dataraw->paginate(10);
		$vehicles = VehicleMast::pluckactives();
		$sites = sites::activesitespluck();
		$dealer_sites = sites::dealersitespluck();
		$plants = PlantMast::pluckactives();
 		$items = ItemMast::pluckactives();
 		$vendors = VendorMast::pluckactives();
 		$supervisors = SupervisorMast::pluckactives();
        $users = User::pluckall();

		return view('Reports.UnloadingPlaceWise' , [
			'from_date' 	=> $from_date,
			'to_date'   	=> $to_date,
			'data'      	=> $data,
			'items'			=> $items,
			'vehicles'  	=> $vehicles,
			'sites'     	=> $sites,
			'dealer_sites'  => $dealer_sites,
			'supervisors'	=> $supervisors,
			'plants'        => $plants,
			'vendors'		=> $vendors,
			'users'			=> $users
		]);			
	}
	function VendorWiseSummary($request){

		$dataraw = EntryMast::where('delete_status' , 0);
		$from_date = !empty($request->from_date) ? $request->from_date : date('Y-m-d' ,strtotime('-7 days'));
		$to_date = !empty($request->to_date) ? $request->to_date : date('Y-m-d');
		if(isset($request->slip_no)){
			$dataraw->where('slip_no' , $request->slip_no);
		}
		if(isset($request->kanta_slip_no)){
			$dataraw->where('kanta_slip_no' , $request->kanta_slip_no);
		}
		if(isset($request->vehicle)){
			$dataraw->where('vehicle' , $request->vehicle);
		}
		if(isset($request->item)){
			$arr = [$request->item];
			$json = json_encode($arr);
			$dataraw->where('items_included' , $json);
		}
		if(isset($request->site)){
			$dataraw->where('site' , $request->site);
		}
		if(isset($request->plant)){
			$dataraw->where('plant' , $request->plant);
		}
		if(isset($request->vendor)){
			$dataraw->where('vendor_id' , $request->vendor);
		}
		$dataraw->whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'");
		if(!empty($request->export_to_excel)){
			EntryMast::ExportManual($dataraw->get());
		}
		$data = $dataraw->paginate(10);
		$vehicles = VehicleMast::pluckactives();
		$sites = sites::activesitespluck();
		$dealer_sites = sites::dealersitespluck();
		$plants = PlantMast::pluckactives();
 		$items = ItemMast::pluckactives();
 		$vendors = VendorMast::pluckactives();
 		$supervisors = SupervisorMast::pluckactives();
        $users = User::pluckall();

		return view('Reports.vendorwise' , [
			'from_date' 	=> $from_date,
			'to_date'   	=> $to_date,
			'data'      	=> $data,
			'items'			=> $items,
			'vehicles'  	=> $vehicles,
			'sites'     	=> $sites,
			'dealer_sites'  => $dealer_sites,
			'supervisors'	=> $supervisors,
			'plants'        => $plants,
			'vendors'		=> $vendors,
			'users'			=> $users
		]);			
	}
}
