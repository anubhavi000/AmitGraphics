<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantMast;
use DB;
use Illuminate\Support\Facades\Auth;
use Session;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->url = 'PlantMast';
        $this->view_folder = 'PlantMaster';
        $this->url = 'PlantMast';
    }

    public function index()
    {
        $record = PlantMast::where('status', 1)
                           ->orderBy('id'  , 'desc')
                           ->get();

        return view('PlantMaster.index', [
            'data' => $record,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('PlantMaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {           
        if (!empty($request->name)) {
            $insert = PlantMast::insert([
                                'name' => $request->name,
                                'status' => 1,
                                'descr' => !empty($request->description) ? $request->description : null,
                                'created_at' => date('Y-m-d h:i:s'),
                                'created_by' => Auth::user()->id,
                            ]);
            if($insert){
                return redirect('PlantMast')->with('success' , 'Inserted SuccessFully');
            }
            else{
                Session::put('error' , 'Could Not Create');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $encrypt_id = deCrypt($id);

        $edit = PlantMast::where('status', 1)->where('id',$encrypt_id)->first();
        if(empty($edit)){
            return redirect()->back();  
        }
        return view('PlantMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        $decrypt = decrypt($id);
        $update = PlantMast::where('id', $decrypt)
                            ->update([
                                'name' => $request->name,
                                'status' => 1,
                                'descr' => !empty($request->description) ? $request->description : null,
                                'updated_at' => date('Y-m-d h:i:s'),
                                'updated_by' => Auth::user()->id,
                            ]);
        if($update){
        return redirect('PlantMast')->with('success' ,  'Updated SuccessFully');            
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
        $now_id = deCrypt($id);
        DB::begintransaction();
        $delete = PlantMast::where('id' , $now_id)        
                ->update([
                    'status' => 0,
                ]);
        if($delete){
            DB::commit();
            return redirect()->back()->with('success' , 'Deleted SuccessFully');
        }
        else{
            Db::rollback();
            return redirect()->back();
        }
    }
}
