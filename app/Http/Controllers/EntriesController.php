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
use Session;
use PDF;
use Auth;
class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->route = 'EntryForm';
        $this->module_folder  = 'EntriesForm';
        $this->db_table = 'entry_mast';
    }
    public function index(Request $request)
    {
        $request->from_date = !empty($request->from_date) ? $request->from_date : 'today';
        $auth = Auth::user();
        if(empty($request->slip_no) && empty($request->kanta_slip_no) && empty($request->from_date)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = !empty($request->slip_no) ? $request->slip_no : NULL;
            $kanta_slip_no = !empty($request->kanta_slip_no) ? $request->kanta_slip_no : NULL;
            $from_date = !empty($request->from_date) ? $request->from_date : NULL;
            
            $entriesraw = EntryMast::whereNotNull('slip_no')
                                   ->where('owner_site' , $auth->site)
                                   ->where('is_generated' , 0)
                                   ->where('delete_status' , 0);

            $sites = Sites::activesitespluck();
            $plants = PlantMast::where('status' , 1)
                               ->pluck('name' , 'id')
                               ->toArray();

            $vendors = VendorMast::where('status' , 1)
                                 ->pluck('v_name' , 'id')
                                 ->toArray();
            if($from_date){
                $current_date = date('Y-m-d');
                if($from_date == 'today'){
                    $filter = $current_date;  
                }
                elseif($from_date == 'last_seven_days'){
                    $filter = date('Y-m-d' , strtotime('-7 days'));
                }
                elseif($from_date ==  'last_fifteen_days'){
                    $filter = date('Y-m-d' , strtotime('-15 days'));
                } 
                elseif($from_date ==  'last_thirty_days'){
                    $filter = date('Y-m-d' , strtotime('-30 days'));
                }
                if(!empty($filter)){
                    $entriesraw->whereRaw("DATE_FORMAT(`entry_mast`.datetime,'%Y-%m-%d')>='$filter'");
                }
            }
            if(!empty($kanta_slip_no)){
                $entriesraw   = $entriesraw->where('kanta_slip_no' , 'LIKE' , $kanta_slip_no.'%');
            }
            if(!empty($slip_no)){
                $entriesraw->where('slip_no' , 'LIKE' , $slip_no.'%');
            }
            if(isset($request->vendor)){
                $entriesraw->where('vendor_id' , $request->vendor);
            }
            if(isset($request->status)){
                if($request->status == 1){
                    $entriesraw->where('is_generated' , 1);
                }
                if($request->status == 0){
                    $entriesraw->where('is_generated' , 0);
                }
            }
            $entries = $entriesraw->orderBy('slip_no' , 'DESC')
                                  ->get();

            // if(!empty($entries)){
            //     if(count($entries)  == 1){
            //         $encrypted_id = enCrypt($entries[0]->slip_no);
            //         return redirect('EntryForm_action/'.$encrypted_id);
            //     }
            // }

            return view($this->module_folder.'.index' , [
                'entries' => $entries,
                'sites'   => $sites,
                'plants'  => $plants,
                'vendors' => $vendors
            ]);            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transporters    =   VendorMast::where('status' , 1)
                                       ->pluck('v_name' , 'id')
                                       ->toArray();
        $vehicles        =  VehicleMast::where('status' , 1)
                                       ->pluck('vehicle_no' , 'id')
                                       ->toArray();
        $sites           =  Sites::where('status' , 1)
                                 ->where('is_owner' , 0)
                                 ->pluck('name' , 'id')
                                 ->toArray();
        $supervisors     = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();
        $items           = ItemMast::where('status' , 1)
                                   ->pluck('name' , 'id')
                                   ->toArray();
        $plants          =  PlantMast::where('status' , 1)
                                     ->pluck('name' , 'id')
                                     ->toArray();

        return view($this->module_folder.'/create' , [
            'transporters' => $transporters ,
            'vehicles'     => $vehicles,
            'sites'        => $sites,
            'supervisors'  => $supervisors,
            'items'        => $items,
            'plant'        => $plants
        ]);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->name)){
            $check = VendorMast::checknameduplicacy($request->name);
            if($check){
                Session::put('error' , 'Vendor Name '.$request->name.' already Exists');                
                return redirect()->back();
            }
        }        
        $store = EntryMast::store_slip($request->except('_token'));

        if($store['res']){
            Session::put('SlipStored' , 'Slip Generated SuccessFully With Slip No '.$store['slip_no']);
            $newUrl = url('PrintEntrySlip/'.$store['slip_no']);
            Session::put('newtab' , $newUrl);
            return redirect('EntryForm');
        }
        else{
            return redirect()->back()->with( 'success' , 'Could Not Create');
        }
    }
    public function action(Request $request  , $id){
        $now_id = decrypt($id);
        $entry =  EntryMast::where('slip_no' , $now_id)
                           ->first();
        if(!empty($entry->vehicle)){
             $selected_vehicle = VehicleMast::where('id' , $entry->vehicle)->first();
             $vehicle_pass_weight = !empty($selected_vehicle->pass_wt) ? $selected_vehicle->pass_wt : 0;
        }   
                                
        $chosenvehicle = 

        $vehicles        =  VehicleMast::where('status' , 1)
                               ->pluck('vehicle_no' , 'id')
                               ->toArray();

        $plants  = PlantMast::where('status' , 1)
                            ->pluck('name' , 'id')
                            ->toArray();

        $items = ItemMast::where('status' , 1)
                         ->pluck('name' , 'id')
                         ->toArray();

        $transporters =     VendorMast::where('status' , 1)
                                       ->pluck('v_name' , 'id')
                                       ->toArray();

        $sites           =  Sites::where('status' , 1)
                                 ->where('is_owner' , 0)
                                 ->pluck('name' , 'id')
                                 ->toArray();

        $supervisors     = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();

        if(!empty($entry->vendor_id)){
            $selected_vendor = VendorMast::where('id' , $entry->vendor_id)->first();
        }
        else{
            $selected_vendor = [];
        }
        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->module_folder.'.action' , [
                'entry'               => $entry,
                'plants'              => $plants,
                'items'               => $items,
                'sites'               => $sites,
                'vehicle_pass_weight' => $vehicle_pass_weight,
                'supervisors'         => $supervisors,
                'transporters'        => $transporters,
                'vehicles'            => $vehicles,
                'selected_vendor'     => $selected_vendor
            ]);
        }        
    }
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    // edit function is to edit the slip before generation
    public function edit($id)
    {
        $now_id = decrypt($id);
        $entry =  EntryMast::where('slip_no' , $now_id)
                           ->first();
        $transporters    =   VendorMast::where('status' , 1)
                                       ->pluck('v_name' , 'id')
                                       ->toArray();
        $vehicles        =  VehicleMast::where('status' , 1)
                                       ->pluck('vehicle_no' , 'id')
                                       ->toArray();
        $sites           =  Sites::where('status' , 1)
                                 ->where('is_owner' , 0)
                                 ->pluck('name' , 'id')
                                 ->toArray();
        $supervisors     = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();
        $items           = ItemMast::where('status' , 1)
                                   ->pluck('name' , 'id')
                                   ->toArray();
        $plants          =  PlantMast::where('status' , 1)
                                     ->pluck('name' , 'id')
                                     ->toArray();

        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->module_folder.'.edit' , [
                'entry'        => $entry,
                'transporters' => $transporters,
                'vehicles'     => $vehicles,
                'sites'        => $sites,
                'supervisors'  => $supervisors,
                'items'        => $items,
                'plant'        => $plants
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = EntryMast::editslip($request->except('_token' , '_method') , decrypt($id));
        if($update){
            return redirect($this->route)->with('success' , 'Updated SuccessFully');
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $now_id = decrypt($id);

        $delete = EntryMast::where('slip_no' , $now_id)
                           ->update([
                                'delete_status' => 1
                           ]);
        if($delete){
            return redirect()->back()->with('status' , 'Deleted SuccessFully');
        }

    }
    public function return_tranporter(Request $request){
        if(empty($request->transporter)){
            return false;
        }
        $transporter =  VendorMast::where('id' , (int)$request->transporter)
                                  ->first();
        if(empty($transporter)){
            return false;
        }
        else{
            return response()->json($transporter);
        }
    }
    public function check_if_duplicate(Request $request){
        if(empty($request->slip_no)){
            return reponse()->json(false);
        }
        else{
            $entry = EntryMast::where('kanta_slip_no' , $request->slip_no)
                              ->first();

            if(empty($entry)){
                return response()->json(true);
            }
            else{
                return response()->json(false);
            }
        }
    }
    public function SlipGeneration(Request $request , $id){
        $response = EntryMast::generateslip($request->except('_token' , '_method') , $id);
        if($response['res']){
            if($response['print'] == 1){
                $plant = $response['plant'];
                $slip_no = decrypt($id);
                $newUrl = url('print_invoice/'.$plant.'/'.$slip_no);
                Session::put('newtab' , $newUrl);
                return redirect('ChalanGeneration')->with('success'  , 'Challan Generated SuccessFully');
            }
            else{
                $slip_no = decrypt($id);
                Session::put('error' , 'Slip Generated With Excess Weight And Slip No : '.$slip_no);
                return redirect($this->route);
            }
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Generate');
        }
    }
    public function ShowGeneratedSlips(Request $request){
        $auth = Auth::user();
        $recordsraw   = EntryMast::where('is_generated' , 1)
                                  ->where('delete_status' , 0)
                                  ->where('owner_site' , $auth->site);
        $sites = Sites::activesitespluck();
        $plants = PlantMast::pluckactives();
        $vehicles = VehicleMast::where('status' , 1)->pluck('vehicle_no' , 'id');
        if(!empty($request->slip_no)){
            $recordsraw->where('slip_no' , $request->slip_no);
        }
        if(!empty($request->from_date) && !empty($request->to_date)){
        
        $from_date = date('Y-m-d' , strtotime($request->from_date));
        $to_date   = date('Y-m-d' , strtotime($request->to_date));

            $recordsraw->whereRaw("date_format(entry_mast.datetime,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.datetime,'%Y-%m-%d')<='$to_date'");
        }
            $records = $recordsraw->get();
        return view($this->module_folder.'.show' , [
            'data'      => $records,
            'sites'     => $sites,
            'vehicles'  => $vehicles,
            'plants'    => $plants
        ]);
    }
    public function PrintInvoice(Request $request , $plant , $slip_no){
        if( !empty($slip_no)){
            $data = EntryMast::join('plant_mast' , 'plant_mast.id' , '=' ,'entry_mast.plant')
                             ->where('plant_mast.id' , $plant )
                             ->where('slip_no' , $slip_no)
                             ->select('entry_mast.*' , 'plant_mast.name as plantname')
                             ->first();
            if(empty($data)){
                Session::put('error' , 'Slip Not Found Either Not Generated');            
                return redirect()->back();
            }
            else{
            $items = ItemMast::where('status' , 1)
                             ->pluck('name' , 'id')
                             ->toArray();

            $vehicles = VehicleMast::where('status' , 1)
                                   ->pluck('id' , 'vehicle_no')
                                   ->toArray();

            $supervisors = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();

            $sites  = Sites::where('status' , 1)
                           ->pluck('name' , 'id')
                           ->toArray();
            $siteaddresses = Sites::where('status' , 1)
                                  ->pluck('address' , 'id')
                                  ->toArray();
            $vehicles = VehicleMast::where('status' , 1)
                                   ->pluck('vehicle_no' , 'id')
                                   ->toArray();                                  

            // $filepath  = asset('images/logo-light.png');

            // $filetype = pathinfo($filepath, PATHINFO_EXTENSION);

            // if ($filetype==='svg'){
            //     $filetype .= '+xml';
            // }
            // $arrContextOptions=array(
            //     "ssl"=>array(
            //         "verify_peer"=>false,
            //         "verify_peer_name"=>false,
            //     ),
            // );  

            // $get_img = file_get_contents($filepath, false, stream_context_create($arrContextOptions));
            // $image = 'data:image/' . $filetype . ';base64,' . base64_encode($get_img );                                
            $custumpaper = 'A5';
            $pdf = PDF::loadView($this->module_folder.'.invoice_pdf', array(
                'data'          => $data,
                'items'         => $items,
                'vehicles'      => $vehicles,
                'supervisors'   => $supervisors,
                // 'logo'          => $image,
                'vehicles'      => $vehicles,
                'sites'         => $sites,
                'siteaddresses' => $siteaddresses          
            ))->setPaper($custumpaper , 'landscape');                                
            return $pdf->stream($this->module_folder.'.pdf');
            }
        }
    }
    public function PrintSlip(Request $request  , $slip_no){
        if(!empty($slip_no)){
            $data = EntryMast::where('slip_no' , $slip_no)
                             ->first();
            if(empty($data)){
                return redirect()->back()->with('error' , 'Slip Not Found');
            }
            if(!empty($data->pant)){
                    $plant =  PlantMast::where('id' , $data->plant)->first();
                    $data->plantname = !empty($plant->name) ? $plant->name : '';
            }            
            else{
                $data->plantname = '';
            }
            $filepath  = asset('images/logo-light.png');

                $filetype = pathinfo($filepath, PATHINFO_EXTENSION);

                if ($filetype==='svg'){
                    $filetype .= '+xml';
                }
                $arrContextOptions=array(
                    "ssl"=>array(
                        "verify_peer"=>false,
                        "verify_peer_name"=>false,
                    ),
                );  

                $get_img = file_get_contents($filepath, false, stream_context_create($arrContextOptions));
                $image = 'data:image/' . $filetype . ';base64,' . base64_encode($get_img ); 

            $items = ItemMast::where('status' , 1)
                             ->pluck('name' , 'id')
                             ->toArray();

            $vehicles = VehicleMast::where('status' , 1)
                                   ->pluck('vehicle_no' , 'id')
                                   ->toArray();

            $supervisors = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();

            $sites  = Sites::where('status' , 1)
                           ->pluck('name' , 'id')
                           ->toArray();
            $siteaddresses = Sites::where('status' , 1)
                                  ->pluck('address' , 'id')
                                  ->toArray();
            if(isset($data->vendor_id)){
            $vendor = VendorMast::where('id' , $data->vendor_id)
                                ->first();
            }
            else{
                 $vendor ='';
            }
            $custumpaper = 'A5';
            $pdf = PDF::loadView($this->module_folder.'.pdf', array(
                'data'          => $data,
                'items'         => $items,
                'vendor'         => $vendor,
                'vehicles'      => $vehicles,
                'supervisors'   => $supervisors,
                'sites'         => $sites,
                'logo'          => $image,
                'siteaddresses' => $siteaddresses          
            ))->setPaper($custumpaper , 'landscape');                                
            return $pdf->stream($this->module_folder.'.pdf');
        }
    }   





    // function  For Challan Generation Starts here

    public function chalanindex(Request  $request){
        $auth = Auth::user();
            $request->from_date = !empty($request->from_date) ? $request->from_date : 'today';
            $vendors = VendorMast::where('status' , 1)
                                 ->pluck('v_name' , 'id')
                                 ->toArray();            
        if(empty($request->slip_no) && empty($request->kanta_slip_no) && empty($request->from_date) && empty($request->vendor)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = !empty($request->slip_no) ? $request->slip_no : NULL;
            $kanta_slip_no = !empty($request->kanta_slip_no) ? $request->kanta_slip_no : NULL;
            $from_date = !empty($request->from_date) ? $request->from_date : 'today';

            
            $entriesraw = EntryMast::whereNotNull('slip_no')
                                   ->where('owner_site' , $auth->site)
                                   ->where('delete_status' , 0);

            $sites = Sites::activesitespluck();
            $plants = PlantMast::where('status' , 1)
                               ->pluck('name' , 'id')
                               ->toArray();
            if($from_date){
                $current_date = date('Y-m-d');
                if($from_date == 'today'){
                    $filter = $current_date;  
                }
                elseif($from_date == 'last_seven_days'){
                    $filter = date('Y-m-d' , strtotime('-7 days'));
                }
                elseif($from_date ==  'last_fifteen_days'){
                    $filter = date('Y-m-d' , strtotime('-15 days'));
                } 
                elseif($from_date ==  'last_thirty_days'){
                    $filter = date('Y-m-d' , strtotime('-30 days'));
                }
                if(!empty($filter)){
                    $entriesraw->whereRaw("DATE_FORMAT(`entry_mast`.datetime,'%Y-%m-%d')>='$filter'");
                }
            }
            if(!empty($kanta_slip_no)){
                $entriesraw   = $entriesraw->where('kanta_slip_no' , 'LIKE' , $kanta_slip_no.'%');
            }
            if(!empty($slip_no)){
                $entriesraw->where('slip_no' , 'LIKE' , $slip_no.'%');
            }
            if(isset($request->vendor)){
                $entriesraw->where('vendor_id' , $request->vendor);
            }            
            if(isset($request->status)){
                if($request->status == 1){
                    $entriesraw->where('is_generated' , 1);
                }
                if($request->status == 0){
                    $entriesraw->where('is_generated' , 0);
                }
            }
            $entries = $entriesraw->orderBy('id' , 'DESC')
                                  ->get();

            if(!empty($entries)){
                if(count($entries)  == 1){
                    $encrypted_id = enCrypt($entries[0]->slip_no);
                    return redirect('EntryForm_action/'.$encrypted_id);
                }
            }
            return view($this->module_folder.'.Challan.index' , [
                'entries' => $entries,
                'sites'   => $sites,
                'plants'  => $plants,
                'vendors' => $vendors
            ]);            
        }
    }
     public function ManualChallan(Request $request){
      
      $request->from_date = !empty($request->from_date) ? $request->from_date : 'today';
        $auth = Auth::user();

        if(!empty($request->slip_no)){
            $check = EntryMast::where('slip_no' , $request->slip_no)
                              ->first();
            if(empty($check)){
                $transporters    =   VendorMast::where('status' , 1)
                                               ->pluck('v_name' , 'id')
                                               ->toArray();
                $vehicles        =  VehicleMast::where('status' , 1)
                                               ->pluck('vehicle_no' , 'id')
                                               ->toArray();
                $sites           =  Sites::where('status' , 1)
                                         ->where('is_owner' , 0)
                                         ->pluck('name' , 'id')
                                         ->toArray();
                $supervisors     = SupervisorMast::where('status' , 1)
                                                 ->pluck('name' , 'id')
                                                 ->toArray();
                $items           = ItemMast::where('status' , 1)
                                           ->pluck('name' , 'id')
                                           ->toArray();
                $plants          =  PlantMast::where('status' , 1)
                                             ->pluck('name' , 'id')
                                             ->toArray();

            return view($this->module_folder.'.ManualChallan.create' , [
            'data' => $request->all(),
            'transporters' => $transporters ,
            'vehicles'     => $vehicles,
            'sites'        => $sites,
            'supervisors'  => $supervisors,
            'items'        => $items,
            'plant'        => $plants                
            ]);
            }
            else{
                return redirect('ManualChallan/edit/'.$check->id);
            }
        }
        if(empty($request->slip_no) && empty($request->kanta_slip_no) && empty($request->from_date) && empty($request->vendor)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = !empty($request->slip_no) ? $request->slip_no : NULL;
            $kanta_slip_no = !empty($request->kanta_slip_no) ? $request->kanta_slip_no : NULL;
            $from_date = !empty($request->from_date) ? $request->from_date : NULL;

            $entriesraw = EntryMast::whereNotNull('slip_no')
                                   ->where('owner_site' , $auth->site)
                                   ->where('is_generated' , 1)
                                   ->where('manual' , 1)
                                   ->where('delete_status' , 0);

            $sites = Sites::activesitespluck();
            $plants = PlantMast::where('status' , 1)
                               ->pluck('name' , 'id')
                               ->toArray();

            $vendors = VendorMast::where('status' , 1)
                                 ->pluck('v_name' , 'id')
                                 ->toArray();
            if($from_date){
                $current_date = date('Y-m-d');
                if($from_date == 'today'){
                    $filter = $current_date;  
                }
                elseif($from_date == 'last_seven_days'){
                    $filter = date('Y-m-d' , strtotime('-7 days'));
                }
                elseif($from_date ==  'last_fifteen_days'){
                    $filter = date('Y-m-d' , strtotime('-15 days'));
                } 
                elseif($from_date ==  'last_thirty_days'){
                    $filter = date('Y-m-d' , strtotime('-30 days'));
                }
                if(!empty($filter)){
                    $entriesraw->whereRaw("DATE_FORMAT(`entry_mast`.datetime,'%Y-%m-%d')>='$filter'");
                }
            }
            if(!empty($kanta_slip_no)){
                $entriesraw   = $entriesraw->where('kanta_slip_no' , 'LIKE' , $kanta_slip_no.'%');
            }
            if(!empty($slip_no)){
                $entriesraw->where('slip_no' , 'LIKE' , $slip_no.'%');
            }            
            if(isset($request->vendor)){
                $entriesraw->where('vendor_id' , $request->vendor);
            }
            if(isset($request->status)){
                if($request->status == 1){
                    $entriesraw->where('is_generated' , 1);
                }
                if($request->status == 0){
                    $entriesraw->where('is_generated' , 0);
                }
            }
            $entries = $entriesraw->orderBy('slip_no' , 'DESC')
                                  ->get();
                                  // dd($entries);
            return view($this->module_folder.'.ManualChallan.index' , [
                'entries' => $entries,
                'sites'   => $sites,
                'plants'  => $plants,
                'vendors' => $vendors
            ]);            
        }        
    }
    public function ManualChallanCreation(Request $request){
        $transporters    =   VendorMast::where('status' , 1)
                                       ->pluck('v_name' , 'id')
                                       ->toArray();
        $vehicles        =  VehicleMast::where('status' , 1)
                                       ->pluck('vehicle_no' , 'id')
                                       ->toArray();
        $sites           =  Sites::where('status' , 1)
                                 ->where('is_owner' , 0)
                                 ->pluck('name' , 'id')
                                 ->toArray();
        $supervisors     = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();
        $items           = ItemMast::where('status' , 1)
                                   ->pluck('name' , 'id')
                                   ->toArray();
        $plants          =  PlantMast::where('status' , 1)
                                     ->pluck('name' , 'id')
                                     ->toArray();

        return view($this->module_folder.'.ManualChallan.create' , [
            'transporters' => $transporters ,
            'vehicles'     => $vehicles,
            'sites'        => $sites,
            'supervisors'  => $supervisors,
            'items'        => $items,
            'plant'        => $plants
        ]);  
    }
    public function ManualChallanStore(Request $request){
        if(empty($request->items_included)){
            Session::put('error' , 'Atleast One Item Must Be Selected');
            return redirect()->back();
        }
        $store = EntryMast::storeManualChallan($request->except('_token'));
        if(!empty($store)){
            return redirect('ManualChallan')->with('success' , 'Generated SuccessFully');
        }
        else{
            Session::put('error' , 'Could not Generate');
            return redirect()->back();
        }
    }
    public function check_duplicacy_orignal_slip(Request $request){
        if(empty($request->kanta_slip_no) && empty($request->slip_no)){
            return reponse()->json(false);
        }
        else{
            $kanta_slip_no = $request->kanta_slip_no;
            $slip_no       = $request->slip_no;

            $kantaduplicates = EntryMast::where('kanta_slip_no' , $kanta_slip_no)
                                        ->where('delete_status' , 0)
                                        ->count();
            $slipduplicates  = EntryMast::where('slip_no' , $slip_no)
                                        ->where('delete_status' , 0)
                                        ->count();

            if($kantaduplicates > 0 && $slipduplicates > 0){
                return response()->json([
                    'res'   => 400,
                    'kanta' => false,
                    'slip'  => false
                ]);
            }
            if($kantaduplicates == 0 && $slipduplicates == 0){
                return response()->json([
                    'res'   => 200,
                    'kanta' => true,
                    'slip'  => true
                ]); 
            } 
            if($kantaduplicates == 0 && $slipduplicates > 0){
                return response()->json([
                    'res'  => 400,
                    'kanta'=> true,
                    'slip' => false
                ]);
            }
            if($kantaduplicates > 0 && $slipduplicates == 0){
                return response()->json([
                    'res'  => 400,
                    'kanta'=> false,
                    'slip' => true
                ]);                
            }
        }        
    }
    public function ManualChallanEdition(Request $request , $id){
        $entry =  EntryMast::where('id' , $id)->first();
        if(!empty($entry)){
        $transporters    =   VendorMast::where('status' , 1)
                                       ->pluck('v_name' , 'id')
                                       ->toArray();
        $vehicles        =  VehicleMast::where('status' , 1)
                                       ->pluck('vehicle_no' , 'id')
                                       ->toArray();
        $sites           =  Sites::where('status' , 1)
                                 ->where('is_owner' , 0)
                                 ->pluck('name' , 'id')
                                 ->toArray();
        $supervisors     = SupervisorMast::where('status' , 1)
                                         ->pluck('name' , 'id')
                                         ->toArray();
        $items           = ItemMast::where('status' , 1)
                                   ->pluck('name' , 'id')
                                   ->toArray();
        $plants          =  PlantMast::where('status' , 1)
                                     ->pluck('name' , 'id')
                                     ->toArray();            
            return view($this->module_folder.'.ManualChallan.edit' , [
                'entry' => $entry,
            'transporters' => $transporters ,
            'vehicles'     => $vehicles,
            'sites'        => $sites,
            'supervisors'  => $supervisors,
            'items'        => $items,
            'plant'        => $plants                
            ]);
        }
    }
    public function manualupdate(Request $request , $id){
        if(empty($request->items_included)){
            Session::put('error' , 'Atleast One Item Must Be Selected');
            return redirect()->back();
        }
        $update = EntryMast::updateManualChallan($request->except('_token' , '_method') , $id);

        if(($update)){
            return redirect('ManualChallan')->with('success' , 'Generated SuccessFully');
        }
        else{
            Session::put('error' , 'Could not update');
            return redirect()->back();
        }        
    }
}
