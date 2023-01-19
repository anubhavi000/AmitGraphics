<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleMast;
use Illuminate\Support\Facades\Auth;
use App\Models\TransporterMast;
use DB;
class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = VehicleMast::leftjoin('transporter_mast' , 'transporter_mast.id' , '=' , 'vehicle_mast.transporter')
                             ->select('vehicle_mast.*' , 'transporter_mast.name as transporter')
                             ->orderBy('vehicle_mast.id' , 'desc')
                             ->where('vehicle_mast.status', 1)
                             ->get();
        return view('VehicleMaster.index', [
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
        $transporter=TransporterMast::where('status', 1)->pluck('name', 'id')-> toArray();

        return view('VehicleMaster.create', [
            'trans' => $transporter,
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
        if (!empty($request->number)) {
            $insert = VehicleMast::insert([
                                'vehicle_no' => $request->number,
                                'descr'      => !empty($request->description) ? $request->description : null,
                                'type'       => $request->type,
                                'v_code'     => $request->code,
                                'pass_wt'    => $request->wt,
                                'created_at' => date('Y-m-d h:i:s'),
                                'created_by' => Auth::user()->id,
                                'status'     => 1,
                                'transporter'=> $request->transporter
                            ]);
            if($insert){
                return redirect('VehicleMast')->with('success' , 'Added SuccessFully');
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
        public function edit(Request $request, $id)
    {
        $encrypt_id = deCrypt($id);

        $edit = VehicleMast::where('status', 1)
                            ->where('id',$encrypt_id)
                            ->first();
        if(empty($edit)){
            return redirect()->back();
        }
        $transporter=TransporterMast::where('status', 1)
                                    ->pluck('name', 'id')
                                    -> toArray();

        return view('VehicleMaster.edit', [
            'trans' => $transporter,
            'edit' => $edit,
        ]);
        
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
        $update = VehicleMast::where('id', $decrypt)
                            ->update([
                                'vehicle_no' => $request->number,
                                'descr'      => !empty($request->email) ? $request->description : null,
                                'type'       => $request->type,
                                'v_code'     => $request->code,
                                'pass_wt'    => $request->wt,
                                'descr'      => $request->description,
                                'status'     => 1,
                                'transporter'=>$request->transporter,
                                'updated_at' => date('Y-m-d h:i:s'),
                                'updated_by' => Auth::user()->id,
                            ]);
        if($update){
            return redirect('VehicleMast')->with('success' , 'Updated SuccessFully');
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
    public function delete(Request $request , $id)
    {
        $now_id = deCrypt($id);
        DB::begintransaction();

        $delete = VehicleMast::where('id' , $now_id)
                             ->delete();
        if($delete){
            DB::commit();
            return redirect()->back()->with('success' , 'Deleted SuccessFully');
        }
        else{
            DB::rollback();
            return redirect()->back();
        }
    }
}
