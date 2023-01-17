<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class DynamicController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function menu_return(Request $request)
    {
        // dd($request->domain_url);
        $domain_url = $request->domain_url;
        $domain_url = 'btw.msell.in';
        $company_details = DB::table('company')
                ->where('domain_url',$domain_url)
                ->first();
        $company_id = $company_details->id;

        $web_module_data = DB::table('web_module')
            ->join('modules_bucket','modules_bucket.id','=','web_module.module_id')
            ->select('modules_bucket.id as id','modules_bucket.title as title','web_module.title as name','modules_bucket.icon')
            ->where('web_module.status',1)
            ->where('modules_bucket.status',1)
            ->where('modules_bucket.web_admin_status',0) // for public website status handle here
            ->where('web_module.company_id',$company_id)
            ->orderBy('web_module.sequence','ASC')
            ->get()->toArray();

        

        $sub_module_data = DB::table('sub_web_module')
                ->join('sub_web_module_bucket','sub_web_module_bucket.id','=','sub_web_module.sub_module_id')
                ->join('modules_bucket','modules_bucket.id','=','sub_web_module_bucket.module_id')
                ->select('sub_web_module_bucket.module_id as module_id','sub_web_module_bucket.id as id','sub_web_module_bucket.title as title','sub_web_module.title as sub_module_name')
                ->where('sub_web_module.status',1)
                ->where('modules_bucket.web_admin_status',0) // for public website status handle here
                ->where('sub_web_module.company_id',$company_id)
                ->get()->toArray();

         
            

        $sub_sub_module_data = DB::table('sub_sub_web_module')
                ->join('sub_sub_web_module_bucket','sub_sub_web_module_bucket.id','=','sub_sub_web_module.sub_sub_module_id')
                ->join('sub_web_module_bucket','sub_web_module_bucket.id','=','sub_sub_web_module_bucket.sub_web_module_id')
                ->join('modules_bucket','modules_bucket.id','=','sub_web_module_bucket.module_id')
                ->select('sub_sub_web_module_bucket.sub_web_module_id as sub_web_module_id','sub_sub_web_module_bucket.id as id','sub_sub_web_module_bucket.title as title','sub_sub_web_module.title as sub_sub_module_name')
                ->where('sub_sub_web_module.status',1)
                ->where('sub_sub_web_module.company_id',$company_id)
                ->where('modules_bucket.web_admin_status',0) // for public website status handle here
                // ->where('company_sub_sub_web_module_permission.company_id',$company_id)
                ->get()->toArray();

                                
        $image = DB::table('company')
                ->select('company_image','footer_message','footer_link')
                ->where('id',$company_id)
                ->first();

        return response()->json([ 
            'response' =>True,
            'message'=>'Success',
            'image_base_url'=>'demo.msell.in/public',
            'image'=>$image,
            'company_details'=> $company_details,
            'web_module_data'=>$web_module_data,
            'sub_module_data'=>$sub_module_data,
            'sub_sub_module_data'=>$sub_sub_module_data,
        ]);
        // return view('home');
    }
}
