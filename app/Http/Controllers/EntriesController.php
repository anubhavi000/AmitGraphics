<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryMast;
use App\Models\TransporterMast;

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
        // dd($request);
        if(empty($request->name)){
            return view($this->module_folder.'/index');                       
        }   
        else{
            $slip_no = $request->name;
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
        if(!empty($request->name)){
            ItemMast::insert([
                'name'          =>  $request->name,
                'status'        =>  1,
                'description'   => !empty($request->description) ? $request->description : null,
                'created_at'    => date('Y-m-d h:i:s'),
                'created_by'    => Auth::user()->id 
            ]);               
        }
    }

    public function action(Request $request  , $id){
        $now_id = decrypt($id);
        $entry =  EntryMast::where('slip_no' , $now_id)
                           ->first();
        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->module_folder.'.action' , [
                'entry' => $entry
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
        dd($request);
    }
}
