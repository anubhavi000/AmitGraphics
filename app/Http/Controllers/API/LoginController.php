<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Client;
use App\Models\District;
use App\Company;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Session;
use Validator;
use DB;
use Image;

class LoginController extends Controller
{
    public $successStatus = 200;
    public $response_true = True;
    public $response_false = False;

    # return the company id and url's on the behalf of user name
    # this is first step for login  starts here  
    # below function is for all company please check before modificatons!!!!!!!!....!!!
    public function check_user_company(Request $request)
    {
    //    dd($request);
        $validator = Validator::make($request->all(), [
            'uname' => 'required',
            'v_name' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => False, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 200);
        }
        $uname = $request->uname;
        if (strpos($uname, '@') !== false || strpos($uname, '@') == false) {
            // $replace_company = explode('@',$uname);
            $company_name = 'synergy';
            if (!empty($company_name)) {
                $company_id_query = Company::join('interface_url', 'interface_url.company_id', '=', 'company.id')
                    ->select('sync_post_url', 'company.id as company_id', 'company.base_url as base_url', 'interface_url.signin_url as login_url', 'interface_url.test_url as test_url', 'title', 'company.image_url as image_url', 'interface_url.image_url as sync_image_url', 'company.company_image', 'company.address as address', 'company.email as email', 'company.website', 'footer_message', 'footer_link', 'company.contact_per_name', 'company.other_numbers as company_per_mobile')
                    ->where('name', $company_name)
                    ->where('version_code', $request->v_name)
                    ->where('interface_url.status', 1)
                    ->where('company.status', 1)
                    // ->orderBy('interface_url.id','DESC')
                    ->first();
                // dd($company_id_query);
                $is_user_name_exist = User::where('email', $uname)->first();
                if (!empty($is_user_name_exist)) {
                    if (!empty($company_id_query)) {
                        $company_id = $company_id_query->company_id;
                        $base_url = $company_id_query->base_url;
                        $login_url = $company_id_query->login_url;
                        $test_url = $company_id_query->test_url;
                        $company_name_title = $company_id_query->title;
                        $image_url = $company_id_query->image_url;
                        $sync_url = $company_id_query->sync_post_url;
                        $sync_image_url = $company_id_query->sync_image_url;
                        $company_image = $company_id_query->company_image;

                        $contact_per_name = $company_id_query->contact_per_name;
                        $company_per_mobile = $company_id_query->company_per_mobile;
                        $email = $company_id_query->email;
                        $website = $company_id_query->website;
                        $address = $company_id_query->address;

                        if (!empty($request->imei)) {
                            $check = DB::table('users')->join('employee_info', 'employee_info.user_primary_id', '=', 'users.id')
                                ->where('email', $uname)
                                ->where('employee_info.status', 1)
                                ->where('employee_info.company_id', $company_id)
                                ->whereNull('employee_info.imei_number')
                                ->first();
                            // dd($check);
                            if (isset($check)) {
                                // dd($check);
                                $update_person_query = DB::table('users')->join('employee_info', 'employee_info.user_primary_id', '=', 'users.id')
                                    ->where('email', $uname)
                                    ->where('employee_info.status', 1)
                                    ->where('employee_info.company_id', $company_id)
                                    ->update(['employee_info.imei_number' => $request->imei]);

                                return response()->json([
                                    'response' => True, 'message' => 'Success', 'company_image' => $company_image, 'company_image_url' => $image_url, 'sync_image_url' => $sync_image_url, 'company_name' => $company_name_title, 'company_id' => "$company_id", 'base_url' => $base_url, 'login_url' => $login_url, 'test_url' => $test_url, 'sync_url' => $sync_url,

                                    'company_website' => $website,
                                    'company_address' => $address,
                                    'company_email' => $email,
                                    'contact_per_name' => $contact_per_name,
                                    'contact_per_mobile' => $company_per_mobile,

                                ]);
                            } else {
                                $check_imei = DB::table('users')->join('employee_info', 'employee_info.user_primary_id', '=', 'users.id')
                                    ->where('email', $uname)
                                    ->where('employee_info.status', 1)
                                    ->where('employee_info.company_id', $company_id)
                                    ->where('imei_number', $request->imei)
                                    ->first();

                                if (!empty($check_imei)) {
                                    return response()->json([
                                        'response' => True, 'message' => 'Success', 'company_image' => $company_image, 'company_image_url' => $image_url, 'sync_image_url' => $sync_image_url, 'company_name' => $company_name_title, 'company_id' => "$company_id", 'base_url' => $base_url, 'login_url' => $login_url, 'test_url' => $test_url, 'sync_url' => $sync_url,

                                        'company_website' => $website,
                                        'company_address' => $address,
                                        'company_email' => $email,
                                        'contact_per_name' => $contact_per_name,
                                        'contact_per_mobile' => $company_per_mobile,

                                    ]);
                                } else {
                                    return response()->json(['response' => False, 'message' => 'IMEI already exist !!', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
                                }
                            }
                        } else {
                            return response()->json(['response' => False, 'message' => 'IMEI Not Found !!', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
                        }
                        // return response()->json([ 'response' =>True,'message'=>'Success','company_image'=> $company_image,'company_image_url'=> $image_url,'sync_image_url'=>$sync_image_url,'company_name'=>$company_name_title,'company_id'=>"$company_id",'base_url'=>$base_url,'login_url'=>$login_url,'test_url'=>$test_url,'sync_url'=>$sync_url]);
                    } else {
                        return response()->json(['response' => False, 'message' => 'Data Not Found', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
                    }
                } 
                else {
                    return response()->json(['response' => False, 'message' => 'Incorrect UserName', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
                }
            } else {
                return response()->json(['response' => False, 'message' => 'Company Not Found', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
            }
        } else {
            return response()->json(['response' => False, 'message' => 'Incorrect Username!!', 'company_id' => '', 'base_url' => '', 'login_url' => '', 'test_url' => '']);
        }
    }
    # first step ends here!!!!!!!!!!!!!!!!!!!!!!!!!!!

    # now second step starts here for login
    # below function is gateway for entery in our software starts here
    public function login_demo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uname' => 'required',
            'imei' => 'required',
            'v_name' => 'required',
            'v_code' => 'required',
            'pass' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 200);
        }
        $email = $request->uname;
        $password = $request->pass;
        $imei = $request->imei;
        $v_code = $request->v_code;
        $v_name = $request->v_name;
        $company_id = $request->company_id;
        $token = $request->token;
        $current_date = date('Y-m-d');
        // $table_name = TableReturn::table_return($current_date,$current_date);

        if (!empty($company_id)) {

            if (Auth::attempt(['email' => $email, 'password' => $password])) {

                $user = Auth::user();
                $person_query = User::join('employee_info', 'employee_info.user_primary_id', '=', 'users.id')
                    ->join('designation', 'designation.id', '=', 'employee_info.designation_id')
                    ->join('company', 'company.id', '=', 'employee_info.company_id')
                    ->select(DB::raw("CONCAT_WS(' ',f_name,l_name) as full_name"), 'person_image as person_image', 'users.email as person_username', 'users.id as user_id', 'contact_no as mobile', 'imei_number', 'users.email as user_email', 'designation.name as designation', 'employee_info.designation_id as designation_id', 'employee_info.id as emp_id', 'employee_info.char_id as emp_code', 'address1 as user_address', 'employee_info.created_at as user_created_date', 'users.user_type')
                    ->where('users.id', $user->id)
                    ->where('employee_info.company_id', $company_id)
                    ->where('employee_info.status', 1)
                    ->get();

                $url_details = DB::table('interface_url')
                    ->select('image_url as sync_image_url', 'company_id', 'signin_url', 'sync_post_url', 'test_url', 'version_code', 'status')
                    ->where('version_code', $v_name)
                    ->where('status', 1)
                    ->where('company_id', $company_id)
                    ->get();

                $url_list = DB::table('url_list')
                    ->select('url_list.code as code', 'url_list.url_list as url_list')
                    ->join('assign_url_list', 'assign_url_list.url_list_id', '=', 'url_list.id')
                    ->join('version_management', 'version_management.id', '=', 'assign_url_list.v_name')
                    ->where('version_management.version_name', $v_name)
                    ->where('assign_url_list.status', 1)
                    ->where('assign_url_list.company_id', $company_id)
                    ->where('version_management.company_id', $company_id)
                    ->get();

                foreach ($person_query as $key => $value) {

                    $user_personal_data['user_id'] = $value->user_id;
                    $user_personal_data['emp_id'] = $value->emp_id;
                    $user_personal_data['person_username'] = $value->person_username;
                    $user_personal_data['full_name'] = $value->full_name;
                    $image_name = !empty($value->person_image) ? str_replace('users-profile', '', $value->person_image) : '';
                    $user_personal_data['person_image'] = !empty($value->person_image) ? 'users-profile/' . $image_name : '';
                    $user_personal_data['mobile'] = $value->mobile;
                    $user_personal_data['imei_number'] = $value->imei_number;
                    $user_personal_data['user_email'] = $value->user_email;
                    $user_personal_data['designation_id'] = $value->designation_id;
                    $user_personal_data['designation'] = $value->designation;
                    $user_personal_data['emp_code'] = $value->emp_code;
                    $user_personal_data['user_address'] = $value->user_address;
                    $user_personal_data['user_type_name'] = ($value->user_type == 1) ? 'Client' : 'User';
                    $user_personal_data['user_type'] = ($value->user_type == 1) ? 1 : 0;

                    // $user_personal_data['file_no'] = !empty($value->file_no)?$value->file_no:'';
                    $user_personal_data['user_created_date'] = $value->user_created_date;
                }
                $user_id = $person_query[0]->user_id; // return user id
                $emp_code = $person_query[0]->emp_code; // return user id
                $emp_id = $person_query[0]->emp_id; // return user id
                $user_type = $person_query[0]->user_type; // return user id
                $fcm_token = !empty($request->fcm_token)?$request->fcm_token:0;
                $myArr = ['version_code_name' => "Version: $v_name/$v_code"];
                $update_query = DB::table('employee_info')->where('id', $emp_id)->update($myArr);
                $myArr2 = ['fcm_token'=>$fcm_token];
                $update_query_users = User::where('id', $user_id)->update($myArr2);
                $check_role_id = $person_query[0]->designation_id; // return user id

                // Session::forget('juniordata');
                //     $user_data=JuniorData::getJuniorUser($user_id,$company_id);
                //     // dd($user_data);
                //     // $junior_data = [];
                //     $junior_data = Session::get('juniordata');
                //     // dd($junior_data);
                //     Session::forget('seniorData');
                //        $fetch_senior_id = JuniorData::getSeniorUser($user_id,$company_id);
                //        $senior_data = Session::get('seniorData');
                //        // $senior_data = [];
                //        // print_r($senior_data); exit;
                //     $out = array();
                //     $custom = 1;
                //     // dd('1223');
                //     if(!empty($senior_data) && !empty($junior_data))
                //     {
                //         $juniors_name = Person::select(DB::raw("CONCAT_WS(' ',first_name,middle_name,last_name) as user_name"),'id')
                //                          ->where('company_id',$company_id)
                //                          ->whereIn('id',$junior_data)
                //                          ->get();

                //         $serniors_name = Person::select(DB::raw("CONCAT_WS(' ',first_name,middle_name,last_name) as user_name"),'id')
                //                          ->where('company_id',$company_id)
                //                          ->whereIn('id',$senior_data)
                //                          ->get();
                //         // dd($juniors_name);

                //          $out=[0=>['id'=>'0','name'=>'SELF']];

                //         foreach($serniors_name as $s_key => $s_value)
                //         {
                //             $out[$custom]['id'] = $s_value->id;
                //             $out[$custom]['name'] = $s_value->user_name;
                //             $custom++;
                //         }
                //         foreach ($juniors_name as $key => $value)
                //         {
                //             $out[$custom]['id'] = $value->id;
                //             $out[$custom]['name'] = $value->user_name;
                //             $custom++;
                //         }
                //     }
                //     elseif(!empty($senior_data))
                //     {
                //         $serniors_name = Person::select(DB::raw("CONCAT_WS(' ',first_name,middle_name,last_name) as user_name"),'id')
                //                          ->where('company_id',$company_id)
                //                          ->whereIn('id',$senior_data)
                //                          ->get();
                //         // dd($juniors_name);

                //          $out=[0=>['id'=>'0','name'=>'SELF']];

                //         foreach($serniors_name as $s_key => $s_value)
                //         {
                //             $out[$custom]['id'] = $s_value->id;
                //             $out[$custom]['name'] = $s_value->user_name;
                //             $custom++;
                //         }
                //     }
                //     elseif(!empty($junior_data))
                //     {
                //         $juniors_name = Person::select(DB::raw("CONCAT_WS(' ',first_name,middle_name,last_name) as user_name"),'id')
                //                          ->where('company_id',$company_id)
                //                          ->whereIn('id',$junior_data)
                //                          ->get();
                //         // dd($juniors_name);

                //          $out=[0=>['id'=>'0','name'=>'SELF']];

                //         foreach ($juniors_name as $key => $value)
                //         {
                //             $out[$custom]['id'] = $value->id;
                //             $out[$custom]['name'] = $value->user_name;
                //             $custom++;
                //         }
                //     }
                //     else
                //     {

                //     }


                $junior_data[] = $user_id;
                $out = [0 => ['id' => '0', 'name' => 'SELF']];
                $collegueArr = $out;

                $working_status = DB::table('_working_status')
                    ->select('name', 'id', 'company_id')
                    ->where('company_id', $company_id)
                    ->orderBy('sequence', 'ASC')
                    ->where('status', 1)
                    ->get();



                $check_role_wise_assing_module = DB::table('role_app_module')
                    ->join('master_list_module', 'master_list_module.id', '=', 'role_app_module.module_id')
                    ->select('master_list_module.icon_image as module_icon_image', 'master_list_module.id as module_id', 'role_app_module.title_name as module_name', 'master_list_module.url as module_url', 'role_app_module.app_view_status as bottom', 'role_app_module.center_app_view_status as center', 'role_app_module.left_app_view_status as left')
                    ->where('role_app_module.company_id', $company_id)
                    ->where('role_app_module.status', 1)
                    ->where('role_app_module.status', 1)
                    ->where('role_app_module.role_id', $check_role_id)
                    ->orderBy('role_app_module.module_sequence', 'ASC')
                    ->get();
                // dd($check_role_wise_assing_module);
                # retailer creation with otp condition start here

                # retailer creation with otp condition ends here
                if (COUNT($check_role_wise_assing_module) > 0) {
                    $module = array();
                    foreach ($check_role_wise_assing_module as $key => $value) {
                        $module[$key]['module_icon_image'] = !empty($value->module_icon_image) ? $value->module_icon_image : '';
                        $module[$key]['module_id'] = "$value->module_id";
                        $module[$key]['module_name'] = !empty($value->module_name) ? $value->module_name : '';
                        $module[$key]['module_url'] = !empty($value->module_url) ? $value->module_url : '';
                        // $module[$key]['bottom'] = '0';
                        // $module[$key]['center'] = '0';
                        // $module[$key]['left'] = '0';
                        $module[$key]['bottom'] = $value->bottom;
                        $module[$key]['center'] = $value->center;
                        $module[$key]['left'] = $value->left;
                    }
                    $role_sub_module = DB::table('role_sub_modules')
                        ->join('master_list_sub_module', 'master_list_sub_module.id', '=', 'role_sub_modules.sub_module_id')
                        ->select('master_list_sub_module.module_id as module_id', 'role_sub_modules.sub_module_name as sub_module_name', 'master_list_sub_module.id as sub_module_id', 'master_list_sub_module.path as sub_module_url', 'master_list_sub_module.image_name as sub_module_icon_image')
                        ->where('role_sub_modules.company_id', $company_id)
                        ->where('role_sub_modules.status', 1)
                        ->where('master_list_sub_module.status', 1)
                        ->where('role_sub_modules.role_id', $check_role_id)
                        ->orderBy('role_sub_modules.module_sequence', 'ASC')
                        ->get();
                    $sub_module_arr = array();
                    foreach ($role_sub_module as $key => $value) {
                        $sub_module_arr[$key]['sub_module_icon_image'] = !empty($value->sub_module_icon_image) ? $value->sub_module_icon_image : '';
                        $sub_module_arr[$key]['module_id'] = "$value->module_id";
                        $sub_module_arr[$key]['sub_module_id'] = "$value->sub_module_id";
                        $sub_module_arr[$key]['sub_module_name'] = !empty($value->sub_module_name) ? $value->sub_module_name : '';
                        $sub_module_arr[$key]['sub_module_url'] = !empty($value->sub_module_url) ? $value->sub_module_url : '';
                    }



                    // dd($other_module_arr);

                } else {
                    $app_module = DB::table('app_module')
                        ->join('master_list_module', 'master_list_module.id', '=', 'app_module.module_id')
                        ->select('master_list_module.icon_image as module_icon_image', 'master_list_module.id as module_id', 'app_module.title_name as module_name', 'master_list_module.url as module_url', 'app_module.app_view_status as bottom', 'app_module.center_app_view_status as center', 'app_module.left_app_view_status as left')
                        ->where('app_module.company_id', $company_id)
                        ->where('app_module.status', 1)
                        ->where('master_list_module.status', 1)
                        ->orderBy('app_module.module_sequence', 'ASC')
                        ->get();
                    $module = array();
                    foreach ($app_module as $key => $value) {
                        $module[$key]['module_icon_image'] = !empty($value->module_icon_image) ? $value->module_icon_image : '';
                        $module[$key]['module_id'] = "$value->module_id";
                        $module[$key]['module_name'] = !empty($value->module_name) ? $value->module_name : '';
                        $module[$key]['module_url'] = !empty($value->module_url) ? $value->module_url : '';
                        $module[$key]['bottom'] = $value->bottom;
                        $module[$key]['center'] = $value->center;
                        $module[$key]['left'] = $value->left;
                    }
                    $sub_module = DB::table('_sub_modules')
                        ->join('master_list_sub_module', 'master_list_sub_module.id', '=', '_sub_modules.sub_module_id')
                        ->select('master_list_sub_module.module_id as module_id', '_sub_modules.sub_module_name as sub_module_name', 'master_list_sub_module.id as sub_module_id', 'master_list_sub_module.path as sub_module_url', 'master_list_sub_module.image_name as sub_module_icon_image')
                        ->where('_sub_modules.company_id', $company_id)
                        ->where('_sub_modules.status', 1)
                        ->where('master_list_sub_module.status', 1)
                        ->orderBy('_sub_modules.module_sequence', 'ASC')
                        ->get();
                    $sub_module_arr = array();
                    foreach ($sub_module as $key => $value) {
                        $sub_module_arr[$key]['sub_module_icon_image'] = !empty($value->sub_module_icon_image) ? $value->sub_module_icon_image : '';
                        $sub_module_arr[$key]['module_id'] = "$value->module_id";
                        $sub_module_arr[$key]['sub_module_id'] = "$value->sub_module_id";
                        $sub_module_arr[$key]['sub_module_name'] = !empty($value->sub_module_name) ? $value->sub_module_name : '';
                        $sub_module_arr[$key]['sub_module_url'] = !empty($value->sub_module_url) ? $value->sub_module_url : '';
                    }

                    // dd($other_module_arr);
                }
                #...........................................product wise scheme ends here ..............................................##
                #......................................payment modes starts here ................................................................................................##
                $payment_modes  = DB::table('_payment_modes')
                    ->where('status', 1)
                    ->get();

                #......................................outlet type  starts here ................................................................................................##

                #......................................outlet category modes starts here ................................................................................................##

                #......................................schedule type starts here ................................................................................................##
                $daily_schedule  = DB::table('_daily_schedule')
                    ->where('status', 1)
                    ->where('company_id', $company_id)
                    ->orderBy('sequence', 'ASC')
                    ->get();
                #......................................return type starts here ................................................................................................##

                $meeting_type = array();
                $meeting_type  = DB::table('_meeting_type')
                    ->where('status', 1)
                    ->orderBy('sequence', 'ASC')
                    ->where('company_id', $company_id)
                    ->get();
                // $type_of_meeting = array();
                $type_of_meeting  = DB::table('_meeting_with_type')
                    ->where('status', 1)
                    ->orderBy('sequence', 'ASC')
                    ->where('company_id', $company_id)
                    ->get();

                $meeting_result = DB::table('_meeting_result')
                    ->where('status', 1)
                    ->orderBy('sequence', 'ASC')
                    ->where('company_id', $company_id)
                    ->get();


                $travelling_modes = DB::table('_travelling_mode')
                    ->where('status', 1)
                    ->where('company_id', $company_id)
                    ->get();


                $_leave_type = DB::table('_leave_type')
                    ->where('status', 1)
                    ->where('company_id', $company_id)
                    ->orderBy('sequence', 'ASC')
                    ->get();

                $beat_data = DB::table('client_type')
                    ->select('client_type.id as beat_id', 'client_Type as name')
                    ->where('client_type.company_id', $company_id)
                    ->where('client_type.status', 1)
                    ->get();

                $beat_id = array();
                foreach ($beat_data as $key => $value) {
                    $beat_id[] = $value->beat_id;
                    $beat_data_string['beat_id'] = "$value->beat_id"; // return the data in string
                    $beat_data_string['dealer_id'] = "1"; // return the data in string
                    $beat_data_string['name'] = "$value->name"; // return the data in string
                    $final_data_beat[] = $beat_data_string; // merge all data in one array
                }



                $DepartmentQ = DB::table('department')->where('status', 1)->select('department.id as department_id', 'name');




                $Department = $DepartmentQ->orderBy('name', 'ASC')->get();

                $dept_data_arr = array();
                foreach ($Department as $key => $value) {
                    $comp_type = DB::table('_complaint_type')
                        ->where('dept_id', $value->department_id)
                        ->where('_complaint_type.status', 1)
                        ->select('id', 'name', 'icon_code as icon_unicode')
                        ->orderBy('name', 'ASC')->get();
                    $dept_data_arr[] = array(
                        'dept_id' => $value->department_id,
                        'department_name' => $value->name,
                        'complaint_type' => $comp_type
                    );
                }


                $client_details_arr_set = array();
                if($user_type==1){
                    $client_details = Client::join('employee_info', 'employee_info.char_id', '=', 'client.client_char_id')
                    ->join('district', 'district.id', '=', 'client.district1')
                    ->join('master_state', 'master_state.id', '=', 'client.state1')
                    ->select('client.*', 'district.district as district_name', 'master_state.states as state_name')
                    ->where('employee_info.char_id', $emp_code)
                    ->whereIn('client.client_type', $beat_id)
                    ->get();
                }else{
                    $client_details = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
                    ->join('district', 'district.id', '=', 'client.district1')
                    ->join('master_state', 'master_state.id', '=', 'client.state1')
                    ->select('client.*', 'district.district as district_name', 'master_state.states as state_name')
                    ->where('employee_info.user_primary_id', $user_id)
                    ->whereIn('client.client_type', $beat_id)
                    ->get();
                }
                

                foreach ($client_details as $key => $value) {
                    // code...
                    // $get_pdf_name = DB::table('client_documents')->where('client_id',$value->id)->orderBy('id','')->first();
                    $client_details_arr['id'] = !empty($value->id) ? $value->id : '';
                    $client_details_arr['client_char_id'] = !empty($value->client_char_id) ? $value->client_char_id : '';
                    $client_details_arr['client_sec_char_id'] = !empty($value->client_sec_char_id) ? $value->client_sec_char_id : '';
                    $client_details_arr['business_name'] = !empty($value->business_name) ? $value->business_name : '';
                    $client_details_arr['address1'] = !empty($value->address1) ? $value->address1 : '';
                    $client_details_arr['state_name'] = !empty($value->state_name) ? $value->state_name : '';
                    $client_details_arr['district_name'] = !empty($value->district_name) ? $value->district_name : '';
                    $client_details_arr['pincode1'] = !empty($value->pincode1) ? $value->pincode1 : '';
                    $client_details_arr['address2'] = !empty($value->address2) ? $value->address2 : '';
                    $client_details_arr['city2'] = !empty($value->city2) ? $value->city2 : '';
                    $client_details_arr['district2'] = !empty($value->district2) ? $value->district2 : '';
                    $client_details_arr['state2'] = !empty($value->state2) ? $value->state2 : '';
                    $client_details_arr['pincode2'] = !empty($value->pincode2) ? $value->pincode2 : '';
                    $client_details_arr['is_govt_client'] = !empty($value->is_govt_client) ? $value->is_govt_client : '';
                    $client_details_arr['gst_no'] = !empty($value->gst_no) ? $value->gst_no : '';
                    $client_details_arr['is_gst_applicable'] = ($value->is_gst_applicable == 1) ? 'Yes' : 'No';
                    $client_details_arr['status'] = ($value->status == 1) ? 'Enabled' : 'Disable';
                    $client_details_arr['phone_no'] = !empty($value->phone_no) ? $value->phone_no : '';
                    $client_details_arr['email_id'] = !empty($value->email_id) ? $value->email_id : $value->person_email;
                    $client_details_arr['billing_type'] = !empty($value->billing_type) ? $value->billing_type : '';
                    $client_details_arr['excess_rate'] = !empty($value->excess_rate) ? $value->excess_rate : '';
                    $client_details_arr['file_no'] = !empty($value->file_no) ? $value->file_no : '';
                    $client_details_arr['aggrement_permission'] = 1; // 1 mtlb dikhana hai or 2 mtlb nhi dikhana hai chutiya kamal
                    $client_details_arr['aggrement_pdf_name'] = !empty($value->agreement_file) ? $value->agreement_file : '';
                    $client_details_arr['client_type'] = "$value->client_type";
                    $client_details_arr['executive'] = "$value->executive";
                    $client_details_arr['created_at'] = !empty($value->created_at) ? date('d-m-Y', strtotime($value->created_at)) : '';
                    $client_details_arr['created_by'] = !empty($value->created_by) ? $value->created_by : '';
                    $client_details_arr['lat'] = !empty($value->lat) ? $value->lat : '';
                    $client_details_arr['lng'] = !empty($value->lng) ? $value->lng : '';
                    $client_details_arr['track_addr'] = !empty($value->track_addr) ? $value->track_addr : '';
                    $client_details_arr_set[] = $client_details_arr;
                }
                $town = District::get();
                if (!empty($town)) {
                    foreach ($town as $key => $value) {
                        // code...
                        $town_arr['id'] = $value->id;
                        $town_arr['town_name'] = $value->district;
                        $final_arr[] = $town_arr;
                    }
                }
                $email_config = [
                    'email' => 'invoice@synergyworld.co.in',
                    'pass' => 'Invoice@126'
                ];
                #......................................reponse parameters starts here ..................................................##
                return response()->json([
                    'response' => True,

                    'url_list' => $url_list,
                    'url_details' => $url_details,
                    'company_id' => $company_id,
                    'app_module' => $module,
                    'beat' => !empty($final_data_beat) ? $final_data_beat : array(), // beat means client type 

                    'sub_module' => $sub_module_arr,
                    'dept_data_arr' => $dept_data_arr,
                    'email_config' => $email_config,
                    'user_details' => !empty($user_personal_data) ? $user_personal_data : array(), // user data
                    'hcf_client' => $client_details_arr_set,
                    'payment_modes' => $payment_modes,
                    'daily_schedule' => $daily_schedule,
                    'travelling_modes' => !empty($travelling_modes) ? $travelling_modes : array(),
                    'meeting_type' => $meeting_type,
                    'type_of_meeting' => $type_of_meeting,
                    'meeting_result' => $meeting_result,
                    '_leave_type' => $_leave_type,
                    'colleague' => $collegueArr,
                    'working_status' => $working_status,
                    'town_array' => $final_arr,

                    'message' => 'Success!!'
                ]);
                #......................................reponse parameters ends here ..................................................##

            } 
            else {
                return response()->json([
                    'response' => FALSE,
                    'message' => 'You registration not approved! Please contact to Admin..'
                ]);
            }
        }
    }
}
