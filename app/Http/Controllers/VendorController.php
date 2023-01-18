<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorMast;
use Illuminate\Support\Facades\Auth;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = VendorMast::where('status', 1)->get();
        // dd($record);
        return view('VendorMaster.index', [
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
        return view('VendorMaster.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!empty($request->code)) {
            VendorMast::insert([
                'v_code' => $request->code,
                'v_name' => $request->name,
                'gst_no' => $request->gst,
                'address' => $request->addr,
                'city' => $request->city,
                'state' => $request->state,
                'pin' => $request->pin,
                'phone' => $request->phone,
                'email' => $request->email,
                'descr' => !empty($request->description) ? $request->description : null,
                'created_at' => date('Y-m-d h:i:s'),
                'created_by' => Auth::user()->id,
                'status' => 1,
            ]);
        }
        return redirect('VendorMast');
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
        $edit = VendorMast::where('status', 1)->where('id',$encrypt_id)->first();
        return view('VendorMaster.edit',['encrypt_id' => $id,'edit'=>$edit]);
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
        VendorMast::where('id', $decrypt)
            ->update([
                'v_code' => $request->code,
                'v_name' => $request->name,
                'gst_no' => $request->gst,
                'address' => $request->addr,
                'city' => $request->city,
                'state' => $request->state,
                'pin' => $request->pin,
                'phone' => $request->phone,
                'email' => $request->email,
                'descr' => $request->description,
                'status' => 1,
                'updated_at' => date('Y-m-d h:i:s'),
                'updated_by' => Auth::user()->id,
            ]);

        return redirect('VendorMast');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // $del = VendorMast::find($ecrypt);
        // $del->delete([
        //     'del' => $del,
        // ]);
        // return redirect('VendorMast');
        // dd(1);
    }
}
