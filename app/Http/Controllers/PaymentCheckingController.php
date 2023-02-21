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
use App\Models\PaymentChecking;
use App\Models\ExportData as CSV;
use Session;
use PDF;
use Auth;

class PaymentCheckingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view = 'payment';
        $this->table = 'payment_checking';
    }
    public function index(Request $request)
    {
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
        if(isset($request->vehicle)){
            $recordsraw->where('vehicle' , $request->vehicle);
        }
        if(isset($request->vendor)){
            $recordsraw->where('vendor_id' , $request->vendor);
        }
        if(isset($request->item)){
            $arr = [$request->item];
            $json = json_encode($arr);
            $recordsraw->where('items_included' , $json);
        }
        if(isset($request->site)){
            $recordsraw->where('site' , $request->site);
        }
        if(isset($request->plant)){
            $recordsraw->where('plant' , $request->plant);
        }
        if(isset($request->item)){
            $arr = [$request->item];
            $json = json_encode($arr);
            $recordsraw->where('item' , $json);
        }
        if(isset($request->site)){
            $recordsraw->where('site' , $request->site);
        }
        if(isset($request->plant)){
            $recordsraw->where('plant' , $request->plant);
        }
        $from_date = !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) : date('Y-m-d');
        $to_date   = !empty($request->to_date) ? date('Y-m-d' , strtotime($request->to_date)) : date('Y-m-d');

            $recordsraw->whereRaw("date_format(entry_mast.generation_time,'%Y-%m-%d')>='$from_date' AND date_format(entry_mast.generation_time,'%Y-%m-%d')<='$to_date'");

            $records = $recordsraw->get();
        if(!empty($request->export_to_excel)){
            $res  =  EntryMast::ExportManual($records);
        }
        $vendors = VendorMast::pluckactives();
        $items = ItemMast::pluckactives();
        $supervisors = SupervisorMast::pluckactives();
        return view($this->view.'.index' , [
            'data'      => $records,
            'sites'     => $sites,
            'vehicles'  => $vehicles,
            'items'     => $items,
            'vendors'   => $vendors,
            'plants'    => $plants,
            'supervisors' => $supervisors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->id) || count($request->id) == 0){
            Session::put('error' , 'Please Select Atleast One Challan');
            return redirect()->back();
        }
        $res = PaymentChecking::CreateEntries($request->id);
        if($res){
            return redirect()->back()->with('success' , 'Updated SucceesFully');
        }
        else{
            Session::put('error' , 'Something Went Wrong');
            return  redirect()->back();
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        //
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
}
