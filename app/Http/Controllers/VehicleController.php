<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VehicleMast;
use Illuminate\Support\Facades\Auth;
class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = VehicleMast::where('status', 1)->get();
        // dd($record);
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
        return view('VehicleMaster.create');
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
            VehicleMast::insert([
                'vehicle_no' => $request->number,
                'descr' => !empty($request->description) ? $request->description : null,
                'type' => $request->type,
                'v_code' => $request->code,
                'pass_wt' => $request->wt,
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
                'status' => 1,
            ]);
        }
        return redirect('VehicleMast');
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
        // dd($request, $id, $encrypt_id);
        $edit = VehicleMast::where('status', 1)->where('id',$encrypt_id)->first();
        return view('VehicleMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        VehicleMast::where('id', $decrypt)
            ->update([
                'vehicle_no' => $request->number,
                'descr' => !empty($request->email) ? $request->description : null,
                'type' => $request->type,
                'v_code' => $request->code,
                'pass_wt' => $request->wt,
                'descr' => $request->description,
                'status' => 1,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->id,
            ]);

        return redirect('VehicleMast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $del = VehicleMast::find($ecrypt);
        // $del->delete([
        //     'del' => $del,
        // ]);
        // return redirect('VehicleMast');
        // dd(1);
    }
}
