<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\DesignationModule;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use DB;
use Auth;

class ModuleAccess extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$auth) {
        
        $permission = 0;
        $user_id = Auth::user()->id;
        $authUser = Auth::user();
        if(Auth::user()->id == '1'){
            $permission = 1;
            return $next($request);
        }

        $pathInfoDetails = $request->getPathInfo();
        $break_get_details =  explode('/',$pathInfoDetails);
        if(empty($break_get_details)){
            abort(400);
        }
        // dd($break_get_details);
        $method = $request->getMethod(); 
        if(empty($break_get_details[1])){

            $url = !empty($break_get_details[2])?$break_get_details[2]:'';
            $second_url = !empty($break_get_details[3])?$break_get_details[3]:'';

        }else{
            $url = !empty($break_get_details[1])?$break_get_details[1]:'';
            $token = !empty($break_get_details[2])?$break_get_details[2]:'';
            $second_url = !empty($break_get_details[3])?$break_get_details[3]:'';
            // dd($second_url,$token,$url);
        }

        $get_module_id_details = Module::where('route_name',$url)->orderBy('id','ASC')->first();
        
        if(empty($get_module_id_details->id)){
            //abort(400);
        }else{

            $moduleId = $get_module_id_details->id;
            if(empty($second_url)){
                $second_url = $token;
            }

            $designationModule = DesignationModule::where('designation_id', $authUser->designation_id)
                ->where('module_id', $moduleId)
                ->where('view',1)
                ->first();
                // dd($second_url);
            if($second_url == 'edit'){
                $check_details = DesignationModule::where('designation_id', $authUser->designation_id)
                        ->where('module_id', $moduleId)
                        ->where('edit',1)
                        ->first();
                if(empty($check_details->module_id)){
                    abort(400);
                }
            }
            elseif($second_url == 'create'){
                $check_details = DesignationModule::where('designation_id', $authUser->designation_id)
                        ->where('module_id', $moduleId)
                        ->where('add',1)
                        ->first();
                if(empty($check_details->module_id)){
                    abort(400);
                }
            }
            elseif($method == 'DELETE' || $method == 'delete'){
                $check_details = DesignationModule::where('designation_id', $authUser->designation_id)
                    ->where('module_id', $moduleId)
                    ->where('delete',1)
                    ->first();
                if(empty($check_details->module_id)){
                    abort(400);
                }
            }
        }
        // dd($url);
        if(!empty($url)){
            // $url = $_SERVER['REQUEST_URI'];   
            // dd($url);
            $get_record_check = DB::table('master_routes_url')
                                ->where('url',$url)
                                ->first();
            // dd($url,$get_record_check);
            if(!empty($get_record_check->id)){
                $get_another_record_check = DB::table('designation_master_routes_url')
                                ->where('url_id',$get_record_check->id)
                                ->where('user_id',$user_id)
                                ->where('persmission',1)
                                ->first();
                    // dd($get_another_record_check);
                if(!empty($get_another_record_check->id)){
                    return $next($request);
                }else{
                    abort(400);
                }
            }else{
                if(!empty($second_url) || !empty($token)){
                    if(empty($second_url)){
                        $second_url = $token;
                    }
                    $re_url = $url.'/'.$second_url;
                    // dd($re_url);
                    $get_record_check = DB::table('master_routes_url')
                                        ->where('url',$re_url)
                                        ->first();
                    // dd($url,$get_record_check);
                    if(!empty($get_record_check->id)){
                        $get_another_record_check = DB::table('designation_master_routes_url')
                                        ->where('url_id',$get_record_check->id)
                                        ->where('user_id',$user_id)
                                        ->where('persmission',1)
                                        ->first();
                            // dd($get_another_record_check);
                        if(!empty($get_another_record_check->id)){
                            return $next($request);
                        }else{
                            abort(400);
                        }
                    }else{
                        return $next($request);
                    }
                }
                return $next($request);
            }
        }
        else{
            abort(400);
        } 

        // for safety
        if($permission == 0) {
            abort(400);
        }

        return $next($request);

        // // dd($url, $_SERVER['REQUEST_URI']);
        // $server_request_uri = $_SERVER['REQUEST_URI'];

        // $server_request_uri_arr = explode('/', $server_request_uri);
        // // dd($server_request_uri_arr); 

        // $page_index = $server_request_uri_arr[3];      //index page of every module is returned from here
        //                                                 //REPORTS MEI ?MARK KRKE aayega
        // // dd($server_request_uri_arr[4]);
        // $page_sub_index = !empty($server_request_uri_arr[4])?$server_request_uri_arr[4]:null;
        // $page_sub_sub_index = !empty($server_request_uri_arr[5])?$server_request_uri_arr[5]:null;



        // $user_code = Auth::user()->role_id;
        
        // $modules_assigned = DB::table('designation_user_modules')
        //                         ->join('modules', 'modules.id', 'designation_user_modules.module_id')
        //                         ->where('designation_user_modules.desig_code',$user_code)
        //                         ->where('route_name', $page_index)
        //                         ->where('view', 1)
        //                         ->get();

        // // dd($modules_assigned);



        // if($modules_assigned->isEmpty() == true) {
        //     $permission = 1;
        // } 
        // else {
        //     foreach ($modules_assigned as $key => $value) {
        //         // code...
        //         $route_name = $value->route_name;
        //         if($route_name == $page_index) {
        //             $add_page_status = $value->add;
        //             $edit_page_status = $value->edit;
        //             $delete_page_status = $value->delete;
        //             $download_page_status = $value->download;
        //             $upload_page_status = $value->upload;


        //             if($page_sub_index == 'create' && $add_page_status == 0) {
        //                 $permission = 0;
        //                 break;
        //             }
        //             else if($page_sub_sub_index == 'edit' && $edit_page_status == 0) {
        //                 $permission = 0;
        //                 break;   
        //             }
        //             else if($add_page_status==0 && $edit_page_status==0 && $delete_page_status==0 && $download_page_status==0 && $upload_page_status==0) {
        //                 $permission = 1;
        //             }
        //             else {
        //                 $permission = 1;
        //             }
        //         }
        //     }        
        // }
        // // $permission = 1;
        // if(Auth::user()->role_id == 'Admin'){
        //     $permission = 1;
        // }
        // else {
        //     // return redirect('/permission');
        //     abort(400);
        // }
            
        
    }
}
