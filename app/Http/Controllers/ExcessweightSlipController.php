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

class ExcessweightSlipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view = 'EntriesForm/ExcessWeightedSlips';
        $this->url = 'ExcessWeightedSlips';
    }
    public function index(Request $request)
    {
        $auth = Auth::user();
        $entriesraw = EntryMast::where('owner_site' , $auth->site)
                            ->where('excess_weight' ,'>' , 0)
                            ->where('is_generated' , 1)
                            ->where('delete_status' , 0);
        $from_date = !empty($request->from_date) ? $request->from_date : 'today';

        if(!empty($request->slip_no)){
            $entriesraw->where('slip_no' , $request->slip_no);
        }
        if(!empty($request->kanta_slip_no)){
            $entriesraw->where('kanta_slip_no' , $request->kanta_slip_no);
        }
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
        $sites = Sites::activesitespluck();
        $plants = PlantMast::where('status' , 1)
                           ->pluck('name' , 'id')
                           ->toArray();

        $vehicle_mast = VehicleMast::where('status' , 1)
                             ->pluck('vehicle_no' , 'id')
                             ->toArray();                            
        $entries = $entriesraw->orderBy('slip_no' , 'DESC')
                ->get();
        return view($this->view.'.index' , [
            'entries' => $entries,
            'sites'   => $sites,
            'plants'  => $plants,
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
        //
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
