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
use DB;

class AverageReportsController extends Controller
{
    public function __construct(){
    	$this->view = 'Reports/AverageRerports';
    }

    public function index(Request $request , $slug){
    	if($slug == 'ItemWise'){
    		return $this->itemwise($request);
    		die();
    	}
    	if($slug == 'SiteWise'){
    		return $this->sitewise($request);
    		die();
    	}
    	if($slug == 'ItemSitewise'){
    		return $this->ItemSitewise($request);
    	}
    }

    function itemwise($request){
    	$from_date = !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) : date('Y-m-d'  , strtotime('-30 days'));
    	$to_date   = !empty($request->to_date) ? date('Y-m-d' , strtotime($request->to_date)) : date('Y-m-d');
    	$data = EntryMast::whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'")
    					 ->groupBy('items_included')
    					 ->selectRaw("entry_mast.items_included  ,  SUM(net_weight) AS total_Weight")
    					 ->get();
    	$items 	= ItemMast::pluckactives(); 
 		$arr = [];
 		$total_weight = 0;
    	foreach ($data  as $key => $value) {
 			if(!empty($value->items_included)){

 				$itemid = json_decode($value->items_included);
 				$weight = !empty($value->total_Weight) ? $value->total_Weight : 0;
 				$total_weight += !empty($value->total_Weight) ? $value->total_Weight : 0;
 				$arr[$itemid[0]] =  $weight;
 			}   		
    	}
    	if(!empty($request->export_to_excel)){
    		CSV::exportavgitem($arr , $total_weight , $from_date , $to_date);
    	}
    	return view($this->view.'/item_wise' , [
    		'data'  		=> $arr,
    		'items' 		=> $items,
    		'total_weight'	=> $total_weight,
    		'from_date'     => $from_date, 
    		'to_date'       => $to_date
    	]);
    } 

    function sitewise($request){
        	$from_date = !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) : date('Y-m-d'  , strtotime('-30 days'));
    	$to_date   = !empty($request->to_date) ? date('Y-m-d' , strtotime($request->to_date)) : date('Y-m-d');
    	$data = EntryMast::whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'")
    					 ->groupBy('site')
    					 ->selectRaw("entry_mast.site  ,  SUM(net_weight) AS total_Weight")
    					 ->get();
    	$sites 	= sites::activesitespluck(); 
 		$arr = [];
 		$total_weight = 0;
    	foreach ($data  as $key => $value) {
 			if(!empty($value->site)){

 				$weight = !empty($value->total_Weight) ? $value->total_Weight : 0;
 				$total_weight += !empty($value->total_Weight) ? $value->total_Weight : 0;
 				$arr[$value->site] =  $weight;
 			
 			}   		
    	}
    	if(!empty($request->export_to_excel)){
    		CSV::exportavgsites($arr , $total_weight , $from_date , $to_date);
    	}
    	return view($this->view.'/site_wise' , [
    		'data'  		=> $arr,
    		'sites' 		=> $sites,
    		'total_weight'	=> $total_weight,
    		'from_date'     => $from_date, 
    		'to_date'       => $to_date
    	]);	
    }
    function ItemSitewise($request){
        $from_date = !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) : date('Y-m-d'  , strtotime('-30 days'));
    	$to_date   = !empty($request->to_date) ? date('Y-m-d' , strtotime($request->to_date)) : date('Y-m-d');
    	$data = EntryMast::whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'")
    					 ->groupBy('site')
    					 ->groupBy('items_included')
    					 ->selectRaw("entry_mast.site  , entry_mast.items_included ,  SUM(net_weight) AS total_Weight")
    					 ->get();
    	$sites 	= sites::activesitespluck(); 
    	$items  = ItemMast::pluckactives();
 		$arr = [];
 		$total_weight = 0;
    	foreach ($data  as $key => $value) {
 			if(!empty($value->site) && !empty($value->items_included)){

 				$itemid = json_decode($value->items_included);
 				$arr[$value->site][$itemid[0]] = !empty($value->total_Weight) ? $value->total_Weight : 0;
 				$total_weight += !empty($value->total_Weight) ? $value->total_Weight : 0;

 			}   		
    	}
    	if(!empty($request->export_to_excel)){
    		CSV::exportavgsitesitems($arr , $total_weight , $from_date , $to_date);
    	}
    	return view($this->view.'/item_site_wise' , [
    		'data'  		=> $arr,
    		'sites' 		=> $sites,
    		'items'			=> $items,
    		'total_weight'	=> $total_weight,
    		'from_date'     => $from_date, 
    		'to_date'       => $to_date
    	]);	    	
    }
}
