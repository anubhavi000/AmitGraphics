<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorMast;
use Illuminate\Support\Facades\Auth;
use DB;
use Session;
class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view_folder = 'VendorMaster';
        $this->route = 'VendorMast';
        $this->table = 'vedor_mast';
    }
    public function index()
    {
        $record = VendorMast::where('status', 1)
                            ->orderBy('id'  , 'desc')
                            ->get();

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
        $lastentry = VendorMast::orderBy('id' , 'desc')
                           ->first();
        if(!empty($lastentry)){
            $entry  = $lastentry->id + 1;
        }
        else{
            $entry = 1;
        }
        return view('VendorMaster.create' , [
            'vendor_code'  => 'ven'.$entry
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
            $check = VendorMast::checknameduplicacy($request->name);
            if($check){
                Session::put('error' , 'Vendor Name '.$request->name.' already Exists');                
                return redirect()->back();
            }
        }        
        if (!empty($request->vendor_code)) {
            $insert = VendorMast::insert([
                            'v_name'     => $request->name,
                            'gst_no'     => $request->gst,
                            'address'    => $request->addr,
                            'city'       => $request->city,
                            'state'      => $request->state,
                            'pin'        => $request->pin,
                            'phone'      => $request->phone,
                            'email'      => $request->email,
                            'descr'      => !empty($request->description) ? $request->description : null,
                            'vendor_code'=> $request->vendor_code,
                            'created_at' => date('Y-m-d h:i:s'),
                            'created_by' => Auth::user()->id,
                            'status'     => 1,
                        ]);
            if($insert){
                return redirect('VendorMast')->with('success' , 'Added SuccessFully');
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

        $edit = VendorMast::where('status', 1)->where('id',$encrypt_id)->first();
        if(empty($edit)){
            return redirect()->back();
        }
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
        $update = VendorMast::where('id', $decrypt)
                            ->update([
                                'vendor_code' => $request->vendor_code,
                                'v_name'      => $request->name,
                                'gst_no'      => $request->gst,
                                'address'     => $request->addr,
                                'city'        => $request->city,
                                'state'       => $request->state,
                                'pin'         => $request->pin,
                                'phone'       => $request->phone,
                                'email'       => $request->email,
                                'descr'       => $request->description,
                                'status'      => 1,
                                'updated_at'  => date('Y-m-d h:i:s'),
                                'updated_by'  => Auth::user()->id,
                            ]);
        if($update){
            return redirect('VendorMast')->with('success' , 'Updated SuccessFully');
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
        $delete = VendorMast::where('id' , $now_id)
                    ->update([
                        'status' => 0,
                    ]);
        if($delete){
            DB::commit();
            return redirect('VendorMast')->with('success' , 'Deleted SuccessFully');            
        }
        else{
            DB::rollback();
            return redirect()->back();
        }
    }
}
