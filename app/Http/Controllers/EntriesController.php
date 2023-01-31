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
        if(empty($request->slip_no) && empty($request->kanta_slip_no)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = !empty($request->slip_no) ? $request->slip_no : NULL;
            $kanta_slip_no = !empty($request->kanta_slip_no) ? $request->kanta_slip_no : NULL;

            if(!empty($slip_no)){ 
            $entriesraw   = EntryMast::where('slip_no' , 'LIKE' , $slip_no.'%')
                                ->orderBy('slip_no' , 'desc');
            }
            if(!empty($kanta_slip_no)){
            $entriesraw   = EntryMast::where('kanta_slip_no' , 'LIKE' , $kanta_slip_no.'%')
                                ->orderBy('slip_no' , 'desc');
            }
            $entries = $entriesraw->get();
            if(!empty($entries)){
                if(count($entries)  == 1){
                    $encrypted_id = enCrypt($entries[0]->slip_no);
                    return redirect('EntryForm_action/'.$encrypted_id);
                }
            }
            return view($this->module_folder.'.index' , [
                'entries' => $entries
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
            $store = EntryMast::store_slip($request->except('_token'));

        if($store){
            return redirect('EntryForm')->with('success' , 'Slip Created SuccessFully');
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
    public function edit($id)
    {
        $now_id = decrypt($id);
        $entry =  EntryMast::where('slip_no' , $now_id)
                           ->first();
        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->module_folder.'.edit' , [
                'entry' => $entry
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
            $entry = EntryMast::where('slip_no' , $request->slip_no)
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
        if($response){
            return redirect('EntryForm')->with('success' , 'Generated SuccessFully');
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Generate');
        }
    }
    public function ShowGeneratedSlips(Request $request){
        
        $recordsraw   = EntryMast::whereNotNull('items_included');

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
            'data' => $records
        ]);
    }
}
