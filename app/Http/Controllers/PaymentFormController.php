<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorMast;
use App\Models\User;
use Auth;
use Session;
use App\Models\Payments as main;

class PaymentFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view = 'PaymentForm';
        $this->table = 'payments';
        $this->url = 'PaymentForm';
    }
    public function index(Request $request)
    {   
        $vendors  = VendorMast::pluckall();
        $users    = User::pluckall(); 
        $from_date = !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) :date('Y-m-d');
        $to_date  = !empty($request->to_date) ? date('Y-m-d' , strtotime($request->to_date)) : date('Y-m-d');
        // dd(main::all());
        $entriesraw  = main::where('status' , 1)
                        ->whereRaw("date_format(payments.date,'%Y-%m-%d')>='$from_date' AND date_format(payments.date,'%Y-%m-%d')<='$to_date'");
        if(!empty($request->vendor)){
            $entriesraw->where('vendor' , $request->vendor);
        }

        $entries = $entriesraw->paginate(10);

        return view($this->view.'.index' , [
            'data'    => $entries,
            'users'   => $users,
            'vendors' => $vendors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = VendorMast::pluckall();
        return view($this->view.'.create' , [
            'vendors' => $vendors
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
        $insert_arr = [
            'date'      => date('Y-m-d' , strtotime($request->date)),
            'vendor'    => $request->vendor,
            'amount'    => $request->amt,
            'narration' => $request->narration,
            'created_at'=> date('Y-m-d H:i:s'),
            'created_by'=> Auth::user()->id
        ];
        $insert = main::insert($insert_arr);
        if($insert_arr){
            return redirect($this->url)->with('Stored SuccessFully');
        }
        else{
            Session::put('error' , 'Could Not Store');
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
        $vendors = VendorMast::pluckall();

        $entry = main::find($now_id);
        if(empty($entry)){
            Session::put('error' , 'Not Found');
            return redirect()->back();
        }
        else{
            return view($this->view.'.edit' , [
                'data'    => $entry,
                'vendors' => $vendors
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
        $now_id = decrypt($id);
        $update = main::where('id' , $now_id)
                      ->update([
                        'updated_at' => date('Y-m-d H:i:s'),
                        'updated_by' => Auth::user()->id,
                        'date'       => date('Y-m-d' , strtotime($request->date)),
                        'vendor'     => $request->vendor,
                        'amount'     => $request->amt,
                        'narration'  => $request->narration
                      ]);
        if($update){
            return redirect($this->url)->with('success' , 'Updated SuccessFully');
        }
        else{
            Session::put('error' , 'Could Not Update');
            return redirect()->back();
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

        $delete = main::where('id' , $now_id)
                      ->update([
                        'status' => 0
                      ]);
        if($delete){
            return redirect()->back()->with('success' , 'Deleted SuccessFully');
        }
        else{
            Session::put('error' , 'Could Not Delete');
            return redirect()->back();
        }
    }
}
