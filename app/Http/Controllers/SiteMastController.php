<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sites;
use Auth;

class SiteMastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view  = 'SiteMaster';
        $this->table = 'site_mast';
        $this->url   = 'SiteMaster';
    }

    public function index()
    {
        $data  = sites::where('status' , 1)
                      ->get();
        return view($this->view.'.index' , [
            'data'  => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->view.'.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!empty($request->name) && !empty($request->address)){
            $arr  = [
                'name'      => !empty( $request->name ) ? $request->name : NULL,
                'address'   => !empty( $request->address ) ? $request->address : NULL,  
                'latitude'  => !empty( $request->latitude ) ? $request->latitude : NULL, 
                'longitude' => !empty( $request->longitude ) ? $request->longitude : NULL,
                'created_at'=> date('Y-m-d h:i:s'),
                'created_by'=> Auth::user()->id,
                'status'   => 1
            ];

            $insert = sites::create($arr);

            if($insert){
                return redirect($this->url)->with('success' , 'Added SuccessFully');
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
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
        $now_id = decrypt($id);
        $entry = Sites::where('id' , $now_id)
                      ->first();
        if(empty($entry)){
            return redirect()->back();
        }
        else{
            return view($this->view.'.edit' , [
                'data'  => $entry
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
        if(!empty($request->name) && !empty($request->address)){
            $arr  = [
                'name'      => !empty( $request->name ) ? $request->name : NULL,
                'address'   => !empty( $request->address ) ? $request->address : NULL,  
                'latitude'  => !empty( $request->latitude ) ? $request->latitude : NULL, 
                'longitude' => !empty( $request->longitude ) ? $request->longitude : NULL,
                'created_at'=> date('Y-m-d h:i:s'),
                'created_by'=> Auth::user()->id,
                'status'   => 1
            ];

            $update = sites::where('id' , $now_id)
                            ->update($arr);

            if($update){
                return redirect($this->url)->with('success' , 'Upadated SuccessFully');
            }
            else{
                return redirect()->back();
            }
        }
        else{
            return redirect()->back();
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $delete = Sites::where('id' , $id)
                        ->update([
                            'status' => 0
                        ]);
        if($delete){
            return redirect($this->url)->with('success' , 'Deleted SuccessFully');
        }
        else{
            return redirect()->back();
        }
    }
}
