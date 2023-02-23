<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorRate;
use App\Models\VendorMast;
use App\Models\sites;
use Session;
use Auth;

class vendorRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->view = 'VendorRate';
        $this->url  = 'VendorRateMaster';
    }
    public function index(Request $request)
    {
        $vendors = VendorMast::pluckactives();
        $sites = sites::dealersitespluck();
        $createform = 0;
        if(!isset($request->vendor) || !isset($request->site) ){
          return view($this->view.'.index' , [
            'sites'      => $sites,
            'vendors'    => $vendors,
            'createform' => 0
          ]);
        }
        if(isset($request->vendor) && isset($request->site)){
            $dataraw = VendorRate::where('site' , $request->site)
                              ->where('vendor' , $request->vendor);
        }
        if(!empty($request->from_date) && !empty($request->to_date)){
               
            $from_date = date('Y-m-d' , strtotime($request->from_date));
            $to_date   =  date('Y-m-d' , strtotime($request->to_date));
            $dataraw->whereRaw("date_format(vendor_rate_master.from_date,'%Y-%m-%d')>='$from_date' AND date_format(vendor_rate_master.to_date,'%Y-%m-%d')<='$to_date'");
        }
        $data = $dataraw->get();

        if(!empty($from_date) && !empty($to_date) && isset($request->vendor) && isset($request->site)){
            if(($from_date < $to_date)  || ($from_date == $to_date)){
                $check = VendorRate::where('vendor' , $request->vendor)
                                   ->where('site'  , $request->site)
                                   ->whereRaw("(date_format(vendor_rate_master.to_date,'%Y-%m-%d') >='$to_date' OR date_format(vendor_rate_master.to_date , '%Y-%m-%d') >='$from_date')")
                                   ->get();
                $check = count($check);
                if($check > 0){
                    $createform = 0;   
                }
                else{
                    $createform = 1;
                }
            }
            else{
                $createform = 0;
            }
        }
        else{
            $createform = 0;
        }
          return view($this->view.'.index' , [
            'data'       => $data,
            'sites'      => $sites,
            'vendors'    => $vendors,
            'createform' => $createform
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vendors = VendorMast::pluckactives();
        $sites = sites::dealersitespluck();
        return view($this->view.'.create' , [
            'vendors' => $vendors,
            'sites'   => $sites
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
        if(empty($request->vendor) && empty($request->site) && empty($request->from_date) && empty($request->to_date) && empty($request->rate_ton) && empty($request->create)){
            Session::put('error' , 'Every Feild Must Be Filled');
            return redirect()->back();
        }
       $insert = VendorRate::insert([
                'vendor'        => $request->vendor,
                'site'          => $request->site,
                'from_date'     => date('Y-m-d' , strtotime($request->from_date)),
                'to_date'       => date('Y-m-d' , strtotime($request->to_date)),
                'rate_ton'      => $request->rate_ton,
                'created_at'    => date('Y-m-d'),
                'created_by'    => Auth::user()->id
       ]);
       return redirect('VendorRateMaster')->with('success' , 'Saved SuccessFully'); 
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

        $vendors = VendorMast::pluckactives();
        $sites = sites::dealersitespluck();
        $entry = VendorRate::where('id' , $now_id)
                           ->first();

        return view($this->view.'.edit' , [
            'data'   => $entry,
            'sites'   => $sites,
            'vendors' => $vendors
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
        $now_id = decrypt($id);

        $update = VendorRate::where('id' , $now_id)
                          ->update([
                            'from_date'  => !empty($request->from_date) ? date('Y-m-d' , strtotime($request->from_date)) : NULL,
                            'to_date'    => !empty($request->to_date) ? date('Y-m-d' ,  strtotime($request->to_date)) :NULL,
                            'vendor'     => !empty($request->vendor) ? $request->vendor : NULL,
                            'rate_ton'   => !empty($request->rate_ton)  ? $request->rate_ton : NULL,
                            'updated_at' => date('Y-m-d h:i:s'),
                            'updated_by' => Auth::user()->id,
                            'site'       => !empty($request->site) ? $request->site : NULL
                          ]);

        if($update) {
            return redirect('VendorRateMaster')->with('success' , 'Updated SuccessFully');
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
        $delete = VendorRate::where('id' , $id)
                            ->delete();

        if($delete){
            return redirect('VendorRateMaster')->with('success' , 'Deleted SuccessFully');
        }
        else{
            Session::put('error' , 'Could Not Delete');
            return redirect()->back();
        }
    }
}
