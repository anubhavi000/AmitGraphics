<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Designation;
use Auth;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view  = 'Designation';
        $this->url   = 'Designation';
        $this->table = 'designation'; 
    }
    public function index()
    {
        $data = Designation::where('status' , 1)
                           ->get();
        return view($this->view.'.index' , [
            'data' => $data
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
        if(!empty($request->name)){
            
            $additional_parameters = [
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
                'status'     => 1
            ];
            $request->merge($additional_parameters);
            $insert_arr = $request->except('_token' , '_method');
            
            $insert = Designation::insert($insert_arr);

            if($insert){
                return redirect($this->url)->with('success' , 'Added SuccessFully');
            }
            else{
                return redirect()->back()->with('success' , 'Could Not Add');
            }
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
        $data = Designation::find($now_id);

        if(!empty($data)){
            return view($this->view.'.edit' , [
                'data' => $data
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
        if(!empty($request->name)){
            $now_id = decrypt($id);

            $additional_parameters = [
                'updated_at'        => date('Y-m-d h:i:s'),
                'updated_by'        => Auth::user()->id,
                'status'            => 1,
            ];

            $request->merge($additional_parameters);
            $update_arr  = $request->except('_token' , '_method');

            $update = Designation::where('id' , $now_id)
                                 ->update($update_arr);

            if($update){
                return redirect($this->url)->with('success' , 'Updated SuccessFully');
            }
            else{
                return redirect()->back()->with('success' , 'Could Not Update');
            }
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
        $delete = Designation::where('id' , $now_id)
                             ->update([
                                  'status' => 0
                            ]);
        if($delete){
        return redirect($this->url)->with('success','Deleted Successfully');
        }
        else{
            return redirect()->back()->with('success' , 'Could Not Delete');
        }
    }
}
