<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleMast;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorMast;
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
        $record = VehicleMast::leftjoin('vendor_mast' , 'vendor_mast.id' , '=' , 'vehicle_mast.vendor')
                             ->select('vehicle_mast.*' , 'vendor_mast.v_name as transporter')
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
        $vendors=VendorMast::where('status', 1)->pluck('v_name', 'id')-> toArray(); //vendors are to be used as transporters

        return view('VehicleMaster.create', [
            'vendors' => $vendors,
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
                                'vehicle_no'          => $request->number,
                                'descr'               => !empty($request->description) ? $request->description : null,
                                'type'                => $request->type,
                                'pass_wt'             => $request->wt,
                                'created_at'          => date('Y-m-d h:i:s'),
                                'created_by'          => Auth::user()->id,
                                'status'              => 1,
                                'vendor'              => $request->vendor,
                                'excess_wt_allowance' => !empty($request->excess_wt_allowance) ? $request->excess_wt_allowance : NULL
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
        $vendors=VendorMast::where('status', 1)
                                    ->pluck('v_name', 'id')
                                    -> toArray();

        return view('VehicleMaster.edit', [
            'vendors' => $vendors,
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
                                'vehicle_no'         => $request->number,
                                'descr'              => !empty($request->email) ? $request->description : null,
                                'type'               => $request->type,
                                'pass_wt'            => $request->wt,
                                'descr'              => $request->description,
                                'status'             => 1,
                                'vendor'             =>$request->vendor,
                                'updated_at'         => date('Y-m-d h:i:s'),
                                'updated_by'         => Auth::user()->id,
                                'excess_wt_allowance'=> !empty($request->excess_wt_allowance) ? $request->excess_wt_allowance : NULL 
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
                ->update([
                    'status' => 0,
                    ]);
        if($delete){
            DB::commit();
            return redirect()->back()->with('success' , 'Deleted SuccessFully');
        }
        else{
            DB::rollback();
            return redirect()->back();
        }
    }
    function return_vendor(Request $request){
        if(!empty($request->vendor)){
            $res = VendorMast::ReturnVendorById($request->vendor);
            if(!empty($res)){
                $data = [
                            'name' => $res->v_name,
                            'code' => $res->vendor_code
                        ];
                return $data;
            }
        }
    }
    function get_vehicle_pass_wt(Request $request){
        if(!empty($request->vehicle)){
            $res = VehicleMast::where('id' , $request->vehicle)
                              ->first();
            if(!empty($res->pass_wt)){
                $data = [
                    'res' => 200,
                    'pass_wt' => $res->pass_wt
                ];
            }
            else{
                $data = [
                    'res'     => 400,
                    'pass_wt' => ''
                ];
            }
            return response()->json($data);
        }
    }    
}
