<?php

namespace App\Http\Controllers;

use App\Models\client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use PDF;

class LayoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setting_auth(Request $request)
    {
        $status = $request->status;
        $auth_id = Auth::user()->id;
        // dd($auth_id);
        DB::beginTransaction();
        $submit_data = User::where('id',$auth_id)->update(['layout_status'=>$status]);
        // dd($submit_data);
        if($submit_data){
            DB::commit();
            $data['code'] = 200;
            $data['domain'] = '';
            $data['style_status'] = $status;

        }
        else{
            DB::rollback();
            $data['code'] = 401;
            $data['domain'] = '';
            $data['style_status'] = $status;
        }
        return json_encode($data);
    }
    public function setting_menu(Request $request)
    {
        $auth_id = Auth::user()->id;
        $data_filtered = User::where('id',$auth_id)->first();
        $data['code'] = 200;
        $data['domain'] = 'http://synergy.msell.in/public/';
        $data['style_status'] = $data_filtered->layout_status;

        return json_encode($data);
    }
   

   
}
