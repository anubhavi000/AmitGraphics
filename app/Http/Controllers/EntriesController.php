<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryMast;
use App\Models\TransporterMast;
use App\Models\PlantMast;
use App\Models\ItemMast;

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
        if(empty($request->slip_no)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = $request->slip_no;
            $entries   = EntryMast::where('slip_no' , 'LIKE' , $slip_no.'%')
                                ->orderBy('slip_no' , 'desc')
                                ->get();
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
        $transporters = TransporterMast::where('status' , 1)
                                       ->pluck('name' , 'id')
                                       ->toArray();
        return view($this->module_folder.'/create' , [
            'transporters' => $transporters
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
        if(!empty($request->slip_no)){
            $store = EntryMast::store_slip($request->except('_token'));

            if($store){
                return redirect('EntryForm')->with('success' , 'Slip Created SuccessFully');
            }
            else{
                return redirect()->back()->with( 'success' , 'Could Not Create');
            }
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Created');
        }
    }
    public function action(Request $request  , $id){
        $now_id = decrypt($id);
        $entry =  EntryMast::where('slip_no' , $now_id)
                           ->first();
        $plants  = PlantMast::where('status' , 1)
                            ->pluck('name' , 'id')
                            ->toArray();
        $items = ItemMast::where('status' , 1)
                         ->pluck('name' , 'id')
                         ->toArray();

        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->module_folder.'.action' , [
                'entry' => $entry,
                'plants'=> $plants,
                'items' => $items
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
        $transporter = TransporterMast::where('id' , (int)$request->transporter)
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
