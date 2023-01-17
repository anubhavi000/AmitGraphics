<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Client;
use App\Models\District;
use App\Models\Route;
use App\Models\ClientRoutes;
use App\Models\AllBill;
use App\Models\Payment;
use App\Models\Notification;
use App\Models\AccountingLedger;
use App\Models\HcfCollection;
use App\Models\HcfCollectionTemp;
use App\Models\AccountingEntryItem;
use App\Models\AccountingEntry;
use App\UserDetail;
use App\Person;
use Illuminate\Support\Facades\Auth;
use App\TableReturn;
use Validator;
use DB;
use PDF;
use Session;
use DateTime;
use App\Helpers\ConstantHelper;
use phpDocumentor\Reflection\Types\Null_;

class CommonController extends Controller
{
    public $successStatus = 200;

    ####################

    # **********************ends hre *****************************#
    public function user_daily_attendance_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }


        $status_check = !empty($request->report_status) ? $request->report_status : '1';
        $company_id = $request->company_id;
        // $junior_data_check =-array($request->user_id);


        $attendance_query_data = DB::table('employee_info')
            ->join('users', 'users.id', '=', 'employee_info.user_primary_id')
            ->join('user_daily_attendance', 'user_daily_attendance.user_id', '=', 'employee_info.user_primary_id')
            ->join('_working_status', '_working_status.id', '=', 'user_daily_attendance.work_status')
            ->select('employee_info.contact_no as per_mobile', 'employee_info.user_primary_id as id', DB::raw("CONCAT_WS(' ',f_name,l_name) as user_name"), DB::raw("DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d') as work_date"), '_working_status.name as working_status', DB::raw("DATE_FORMAT(user_daily_attendance.work_date,'%H:%i:%s') as checkin_time"), 'user_daily_attendance.remarks as remarks', 'user_daily_attendance.image_name')
            ->whereRaw("DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')>='$request->from_date' AND DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')<='$request->to_date'")
            ->where('employee_info.user_primary_id', $request->user_id);

        $attendance_query = $attendance_query_data->where('employee_info.company_id', $request->company_id)
            ->where('user_daily_attendance.company_id', $request->company_id)
            ->where('employee_info.status', 1)
            ->get();
        $final_data = array();
        // dd($attendance_query);
        foreach ($attendance_query as $key => $value) {
            $check_out_query = DB::table('check_out')
                ->select(DB::raw("DATE_FORMAT(work_date,'%H:%i:%s') as check_out_time"), 'remarks')
                ->where('company_id', $request->company_id)
                ->whereRaw("DATE_FORMAT(check_out.work_date,'%Y-%m-%d')='$value->work_date'")
                ->where('user_id', $value->id)
                ->first();

            $checkOutTime = !empty($check_out_query->check_out_time) ? $check_out_query->check_out_time : '';
            $checkOutRemarks = !empty($check_out_query->remarks) ? $check_out_query->remarks : '';

            if ($request->company_id == 2) {
                $data['checkout_time'] = $checkOutTime . "\n" . $checkOutRemarks;
            } else {
                $data['checkout_time'] = $checkOutTime;
            }
            $data['id'] = "$value->id";
            $data['checkin_time'] = $value->checkin_time;
            // $data['hq'] = $value->hq;
            $data['fullname'] = $value->user_name . "\n" . $value->per_mobile;
            $data['date'] = $value->work_date;
            $data['working_status'] = $value->working_status;
            $data['remarks'] = !empty($value->remarks) ? $value->remarks : '';
            if ($value->image_name != NULL) {
                $data['att_image'] = "attendance_images/" . $value->image_name;
            } else {
                $data['att_image'] = "msell/images/avatars/profile-pic.jpg";
            }



            $final_data[] = $data;
        }
        if (!empty($final_data)) {
            return response()->json(['response' => True, 'result' => $final_data]);
        } else {
            return response()->json(['response' => False, 'result' => $final_data]);
        }
    }

    public function dashboard_attendacnce_api(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $final_data = array();

        $attendance_query_data = DB::table('employee_info')
            ->join('users', 'users.id', '=', 'employee_info.user_primary_id')
            ->join('user_daily_attendance', 'user_daily_attendance.user_id', '=', 'employee_info.user_primary_id')
            ->join('_working_status', '_working_status.id', '=', 'user_daily_attendance.work_status')
            ->select(DB::raw("COUNT(distinct order_id) as attendance_count"), 'user_primary_id')
            ->whereRaw("DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')>='$request->from_date' AND DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')<='$request->to_date'")
            ->where('employee_info.user_primary_id', $request->user_id);

        $attendance_query = $attendance_query_data->where('employee_info.company_id', $request->company_id)
            ->where('user_daily_attendance.company_id', $request->company_id)
            ->where('employee_info.status', 1)
            ->groupBy('employee_info.user_primary_id')
            ->get();

        $summary_count = DB::table('user_daily_attendance')
            ->where('user_daily_attendance.company_id', $request->company_id)
            ->whereRaw("DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')>='$request->from_date' AND DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d')<='$request->to_date'")
            ->groupBy('user_id', 'work_status')
            ->pluck(DB::raw("COUNT(distinct order_id) as attendance_count"), DB::raw("concat(user_id,work_status) as uaer_is"));


        $work_status = DB::table('_working_status')
            ->where('_working_status.company_id', $request->company_id)
            ->pluck('name', 'id');



        foreach ($attendance_query as $key => $value) {
            // code...
            $data['team_size'] = 1;
            $data['total_attendance'] = $value->attendance_count;

            foreach ($work_status as $w_key => $w_value) {
                // code...
                $data[$w_value] = !empty($summary_count[$value->user_primary_id . $w_key]) ? $summary_count[$value->user_primary_id . $w_key] : 0;
            }

            $final_data[] = $data;
        }
        if (!empty($final_data)) {
            return response()->json(['response' => True, 'result' => $final_data]);
        } else {
            $data['team_size'] = 1;
            $data['total_attendance'] = 0;
            foreach ($work_status as $w_key => $w_value) {
                // code...
                $data[$w_value] = 0;
            }
            $final_data[] = $data;
            return response()->json(['response' => True, 'result' => $final_data]);
        }
    }
    public function store_api_data(Request $request)
    {

        $vehicle_primary_id_data = DB::table('vehicle_registration')->get();
        if (empty($vehicle_primary_id_data)) {
            return response()->json(['response' => False, 'message' => 'Not Found in vehicle_registration master']);
        }
        foreach ($vehicle_primary_id_data as $v_key => $v_value) {
            // code...
            $imei = $v_value->gps_device_imei_number;
            // $imei = '864287032493650';
            if (empty($imei)) {
            } else {
                // $
                $imei = $v_value->gps_device_imei_number;
                $from_date_time = '2022-01-03T18:30:00';
                $to_date_time = '2022-01-04T18:29:00';
                $url = 'https://pullapi-s2.track360.co.in/api/v1/auth/pull_reports_api/summary?username=9654185000&password=Rc123456&deviceImei=' . $imei . '&start_rfc3339_date=' . $from_date_time . '.000Z&end_rfc3339_date=' . $to_date_time . '.000Z';
                // dd($url);
                $sending_array = array();
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_HTTPGET, TRUE);
                // curl_setopt($ch, CURLOPT_POSTFIELDS, $sending_array);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                // print_r(json_decode($response)); die;
                // dd($response->data);
                curl_close($ch);

                // foreach ($response as $key => $value) {
                // 	// code...
                // 	dd($value);
                // }
                $response_decode = json_decode($response);

                // dd($response_decode->data);
                if (!empty($response_decode->data)) {
                    foreach ($response_decode->data as $key => $value) {
                        // code...
                        // dd($value);
                        $arra[] = [
                            'timestamp' => date('Y-m-d H:i:s'),
                            'avg_speed' => !empty($value->avg_speed) ? $value->avg_speed : '',
                            'device_name' => !empty($value->device_name) ? $value->device_name : '',
                            'distance' => !empty($value->distance) ? $value->distance : '',
                            'end_lat' => !empty($value->end_lat) ? $value->end_lat : '',
                            'end_lng' => !empty($value->end_lng) ? $value->end_lng : '',
                            'end_time' => !empty($value->end_time) ? $value->end_time : '',
                            'engine_time' => !empty($value->engine_time) ? $value->engine_time : '',
                            'idle_time' => !empty($value->idle_time) ? $value->idle_time : '',
                            'max_speed' => !empty($value->max_speed) ? $value->max_speed : '',
                            'max_speed_time' => !empty($value->max_speed_time) ? $value->max_speed_time : '',
                            'motion_time' => !empty($value->motion_time) ? $value->motion_time : '',
                            'region' => !empty($value->region) ? $value->region : '',
                            'start_lat' => !empty($value->start_lat) ? $value->start_lat : '',
                            'start_lng' => !empty($value->start_lng) ? $value->start_lng : '',
                            'start_time' => !empty($value->start_time) ? $value->start_time : '',
                            'stop_time' => !empty($value->stop_time) ? $value->stop_time : '',
                            'utilization' => !empty($value->utilization) ? $value->utilization : '',
                            'vehicle_type' => !empty($value->vehicle_type) ? $value->vehicle_type : '',
                            'vehicle_primary_id' => !empty($v_value->id) ? $v_value->id : '',
                            'hit_imei' => $imei,
                            'hit_date_time' => date('Y-m-d H:i:s'),
                        ];
                    }
                    $data_submit = DB::table('vehicle_gps_api_response')->insert($arra);
                    return response()->json(['response' => True, 'message' => 'successfully saved']);
                }

                return response()->json(['response' => False, 'message' => 'API response error']);
            }
            return response()->json(['response' => False, 'message' => 'IMEI not found']);
        }
        return response()->json(['response' => False, 'message' => 'Data not found in vehicle_registration master ']);

        // dd($response_decode);
    }

    public function client_bill_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $client_id = $request->client_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        
        if (empty($client_id)) {
            $client_id_data = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
            ->join('all_bills', 'all_bills.client_id', '=', 'client.id')
            ->select('all_bills.*', 'client.email_id', 'person_email')
            ->where('is_pharma_bill', '!=', 1)
            ->where('employee_info.user_primary_id', $user_id);

        }else{
            $client_id_data = Client::join('all_bills', 'all_bills.client_id', '=', 'client.id')
            ->select('all_bills.*', 'client.email_id', 'person_email')
            ->where('is_pharma_bill', '!=', 1)
            ->where('client.id', $client_id);

        }
        if (!empty($from_date) && !empty($to_date)) {
            $client_id_data->whereRaw("DATE_FORMAT(billing_date,'%Y-%m-%d')>='$from_date' AND DATE_FORMAT(billing_date,'%Y-%m-%d')<='$to_date'");
        }
        $get_bill_details = $client_id_data->groupBy('client.id', 'billing_date', 'bill_no')->get();

        // $get_bill_details = AllBill::whereIn('client_id',$client_pluck)->get();

        if (!empty($get_bill_details)) {
            return response()->json(['response' => True, 'message' => 'found', 'bill_data' => $get_bill_details]);
        } else {
            return response()->json(['response' => False, 'message' => 'Not Found']);
        }
    }
    public function client_outstanding_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $client_id = $request->client_id;

        if (!empty($client_id)) {
            $client_id_data = Client::select('client.*')
                // ->where('employee_info.user_primary_id', $user_id);
                ->where('client.id', $client_id);
        }else{

            $client_id_data = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
                ->select('client.*')
                ->where('employee_info.user_primary_id', $user_id);
        }
        $client_data = $client_id_data->groupBy('client.id')
            ->get();
        $final_arr_detail = [];
        foreach ($client_data as $key => $value) {
            // code...
            $type = 'normal';
            $client_char_id = $value->client_char_id;
            $outstanding = Client::partyCurrentOutstanding($client_char_id, $type);

            $type = 'SEC';
            $outstanding_sec = Client::partyCurrentOutstanding($client_char_id, $type);

            $arr_client['client_char_id'] = !empty($value->client_char_id) ? $value->client_char_id : '';
            $arr_client['business_name'] = !empty($value->business_name) ? $value->business_name : '';
            $arr_client['outstanding'] = !empty($outstanding) ? $outstanding : '';
            $arr_client['security_amt'] = !empty($outstanding_sec) ? $outstanding_sec : '';
            $final_arr_detail[] = $arr_client;
        }
        // $get_bill_details = AllBill::whereIn('client_id',$client_id_data)->get();

        if (!empty($final_arr_detail)) {
            return response()->json(['response' => True, 'message' => 'found', 'bill_data' => $final_arr_detail]);
        } else {
            return response()->json(['response' => False, 'message' => 'Not Found']);
        }
    }

    public function client_wise_ledger_details(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'client_char_id' => 'required',
            'company_id' => 'required',
            'type' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }

        $client_char_id = $request->client_char_id;
        $type = $request->type;
        if ($type == 9) {
            $client_char_id = $client_char_id . '-SEC';
        }
        $entry_item = [];
        $final_common_out = [];
        $out_entry_wise = [];
        $entry_id_arr = [];
        $ledger = AccountingLedger::join('SYNERGY_groups', 'SYNERGY_groups.id', '=', 'SYNERGY_ledgers.group_id')
            ->select('SYNERGY_ledgers.name as ledger_name', 'SYNERGY_ledgers.code as ledger_code', 'SYNERGY_groups.name as group_name', 'SYNERGY_groups.code as group_code', 'SYNERGY_ledgers.id as voucher_name', 'SYNERGY_ledgers.notes as ledger_notes', 'SYNERGY_ledgers.type as ledger_type', 'SYNERGY_ledgers.op_balance', 'op_balance_dc')
            ->where('SYNERGY_ledgers.code', $client_char_id)
            ->first();
        // dd($ledger);
        if ($ledger) {
            $entry_item = AccountingEntryItem::with('entry')->where('ledger_id', $ledger->voucher_name)->orderBy('id', 'ASC')->get();
            // dd($entry_item);
            if (!empty($entry_item) && count($entry_item) > 0) {

                foreach ($entry_item as $key => $value) {
                    // code...
                    // if ($value->ledger_type == 9) { 
                    //     // code... for credit

                    // }elseif($value->ledger_type == 10){

                    // }
                    $entry_id_arr[] = !empty($value->entry->id) ? $value->entry->id : '0';
                    $out_common[$client_char_id]['blank_status'] = 0;
                    $out_common[$client_char_id]['ledger_name'] = $ledger->ledger_name;
                    $out_common[$client_char_id]['ledger_code'] = $ledger->ledger_code;
                    $out_common[$client_char_id]['group_name'] = $ledger->group_name;
                    $out_common[$client_char_id]['group_code'] = $ledger->group_code;
                    $out_common[$client_char_id]['voucher_name'] = $ledger->voucher_name;
                    $out_common[$client_char_id]['voucher_no'] = $value->entry->number;
                    $out_common[$client_char_id]['entry_id'] = $value->entry->id;
                    $out_common[$client_char_id]['ledger_notes'] = $ledger->ledger_notes;
                    $out_common[$client_char_id]['ledger_type'] = $ledger->ledger_type;
                    $out_common[$client_char_id]['item_narration'] = $value->item_narration;
                    $out_common[$client_char_id]['opening_balance'] = $ledger->op_balance;
                    $out_common[$client_char_id]['op_balance_dc'] = $ledger->op_balance_dc;
                    $out_common[$client_char_id]['date'] = date('d/m/Y', strtotime($value->entry->date));
                    if ($value->dc == 'D') {
                        $out_common[$client_char_id]['credit_amt'] = $value->amount;
                        $out_common[$client_char_id]['debit_amt'] = 0;
                    } else {
                        $out_common[$client_char_id]['debit_amt'] = $value->amount;
                        $out_common[$client_char_id]['credit_amt'] = 0;
                    }
                    $final_common_out[] = $out_common;
                }
                // dd('1');
                $entry_wise_details = AccountingEntryItem::with('entry_ledger')->where('ledger_id', '!=', $ledger->voucher_name)->whereIn('entry_id', $entry_id_arr)->groupBy('id')->get();
                // dd($entry_wise_details);
                foreach ($entry_wise_details as $key => $value) {
                    // code...
                    if ($value->entry_ledger->name != 'Round Off A/c') {

                        $entry_id_key = $value->entry_id;
                        $dc = ($value->dc == 'C') ? 'CR' : 'DR';
                        $amount = $value->amount;
                        if ($dc == 'CR') {
                            $out_entry_wise[$entry_id_key]['ledger_description'][] = $dc . ' ' . $value->entry_ledger->name . '<small style="color:green;">(' . $dc . ' ' . $amount . ')</small>';
                        } else {
                            $out_entry_wise[$entry_id_key]['ledger_description'][] = $dc . ' ' . $value->entry_ledger->name . '<small style="color:red;">(' . $dc . ' ' . $amount . ')</small>';
                        }
                    }
                }
                // dd($out_entry_wise);
            } else {
                // dd('1');
                $out_common[$client_char_id]['ledger_name'] = $ledger->ledger_name;
                $out_common[$client_char_id]['ledger_code'] = $ledger->ledger_code;
                $out_common[$client_char_id]['group_name'] = $ledger->group_name;
                $out_common[$client_char_id]['group_code'] = $ledger->group_code;
                $out_common[$client_char_id]['voucher_name'] = $ledger->voucher_name;
                $out_common[$client_char_id]['voucher_no'] = '-';
                $out_common[$client_char_id]['entry_id'] = '-';
                $out_common[$client_char_id]['ledger_notes'] = $ledger->ledger_notes;
                $out_common[$client_char_id]['ledger_type'] = $ledger->ledger_type;
                $out_common[$client_char_id]['item_narration'] = '-';
                $out_common[$client_char_id]['opening_balance'] = $ledger->op_balance;
                $out_common[$client_char_id]['op_balance_dc'] = $ledger->op_balance_dc;
                $out_common[$client_char_id]['date'] = '-';
                $out_common[$client_char_id]['debit_amt'] = 0;
                $out_common[$client_char_id]['credit_amt'] = 0;
                $out_common[$client_char_id]['blank_status'] = 1;

                $final_common_out[] = $out_common;
            }
            // dd($final_common_out);
        }
        // dd($entry_id_arr,$entry_wise_details);
        // dd($final_common_out);

        return response()->json([
            'response' => True,
            'message' => 'found',
            'final_common_out' => $final_common_out,
            'client_char_id' => $client_char_id,
            'status' => 'general',
            'out_entry_wise' => $out_entry_wise,
            'company_name' => 'Synergy Waste Management(P) Ltd.',
        ]);
    }


    public function no_attendance_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }


        $startTime = strtotime($request->from_date);
        $endTime = strtotime($request->to_date);

        for (
            $currentDate = $startTime;
            $currentDate <= $endTime;
            $currentDate += (86400)
        ) {

            $Store = date('Y-m-d', $currentDate);
            $datearray[] = $Store;
        }
        // dd($datearray);
        $no_attendance_array = array();



        $state = DB::table("master_state")
            ->pluck('states', 'id')->toArray();


        foreach ($datearray as $key => $value) {


            $attendance_query_data = DB::table('employee_info')
                ->join('users', 'users.id', '=', 'employee_info.user_primary_id')
                ->join('designation', 'designation.id', '=', 'employee_info.designation_id')
                ->select(DB::raw("CONCAT_WS(' ',f_name,l_name) as fullname"), 'designation.name as rolename', 'employee_info.user_primary_id as user_id', 'employee_info.contact_no as per_mobile', 'employee_info.person_image', 'employee_info.state as state_id')
                ->where('employee_info.user_primary_id', $request->user_id)
                ->whereNotIn('employee_info.user_primary_id', function ($query) use ($value) {
                    $query->select('user_id')->from('user_daily_attendance')
                        ->whereRaw("DATE_FORMAT(user_daily_attendance.work_date,'%Y-%m-%d') ='$value'");
                });

            $no_attendance_query = $attendance_query_data->where('employee_info.company_id', $request->company_id)
                ->where('employee_info.status', 1)
                ->get();




            if (!empty($no_attendance_query)) {
                foreach ($no_attendance_query as $no_key => $no_value) {
                    $data['fullname'] = $no_value->fullname . "\n" . $no_value->per_mobile;
                    $data['rolename'] = $no_value->rolename;
                    $data['date'] = $value;
                    $data['id'] = $no_value->user_id;
                    $data['hq'] = '';
                    $data['state'] = !empty($state[$no_value->state_id]) ? $state[$no_value->state_id] : '';
                    $data['senior'] = '';

                    if ($no_value->person_image != NULL) {

                        $explode = explode('/', $no_value->person_image);

                        if (isset($explode[1])) {
                            $data['att_image'] = "users-profile/" . $explode[1];
                        } elseif (isset($explode[0])) {
                            $data['att_image'] = "users-profile/" . $no_value->person_image;
                        } else {
                            $data['att_image'] = "users-profile/" . $no_value->person_image;
                        }
                    } else {
                        $data['att_image'] = "msell/images/avatars/profile-pic.jpg";
                    }


                    $no_attendance_array[] = $data;
                }
            } else {
                $no_attendance_array = array();
            }
        }
        if (!empty($no_attendance_array)) {
            return response()->json(['response' => True, 'result' => $no_attendance_array]);
        } else {
            return response()->json(['response' => False, 'result' => $no_attendance_array]);
        }
    }
    public function get_client_collection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $client_id = $request->client_id;
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $get_collection = [];
        $to_date = $request->to_date;
        $get_collection_data = HcfCollection::join('client', 'client.id', '=', 'hcf_collection.client_id')
            ->join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
            ->where('employee_info.user_primary_id', $user_id)
            ->groupBy('date', 'client_id');
        if (!empty($from_date) && !empty($to_date)) {
            $get_collection_data->whereRaw("DATE_FORMAT(date,'%Y-%m-%d')>='$from_date' AND DATE_FORMAT(date,'%Y-%m-%d')<='$to_date'");
        }
        if (!empty($client_id)) {
            $get_collection_data->where('client_id', $client_id);
        }
        $get_collection = $get_collection_data->orderBy('date', 'ASC')->orderBy('client_id', 'ASC')->get();

        $wastecontainer = DB::table('waste_container')->where('status', 1)->get();
        $final_arr = [];

        if (!empty($get_collection)) {
            foreach ($get_collection as $key => $value) {
                $final_arr[$value->client_id][4]['bag'] = (!empty($final_arr[$value->client_id][4]['bag']) ? $final_arr[$value->client_id][4]['bag'] : 0) + $value->bag0number;
                $final_arr[$value->client_id][5]['bag'] = (!empty($final_arr[$value->client_id][5]['bag']) ? $final_arr[$value->client_id][5]['bag'] : 0) + $value->bag1number;
                $final_arr[$value->client_id][8]['bag'] = (!empty($final_arr[$value->client_id][8]['bag']) ? $final_arr[$value->client_id][8]['bag'] : 0) + $value->bag2number;
                $final_arr[$value->client_id][9]['bag'] = (!empty($final_arr[$value->client_id][9]['bag']) ? $final_arr[$value->client_id][9]['bag'] : 0) + $value->bag3number;
                $final_arr[$value->client_id][4]['kg'] = (!empty($final_arr[$value->client_id][4]['kg']) ? $final_arr[$value->client_id][4]['kg'] : 0) + $value->bag0quantity;
                $final_arr[$value->client_id][5]['kg'] = (!empty($final_arr[$value->client_id][5]['kg']) ? $final_arr[$value->client_id][5]['kg'] : 0) + $value->bag1quantity;
                $final_arr[$value->client_id][8]['kg'] = (!empty($final_arr[$value->client_id][8]['kg']) ? $final_arr[$value->client_id][8]['kg'] : 0) + $value->bag2quantity;
                $final_arr[$value->client_id][9]['kg'] = (!empty($final_arr[$value->client_id][9]['kg']) ? $final_arr[$value->client_id][9]['kg'] : 0) + $value->bag3quantity;
            }
        }
        // dd($final_arr);
        $final_details = [];
        foreach ($final_arr as $key => $value) {
            $details['client_id'] = $key;
            $inner_bag_array = [];
            foreach ($wastecontainer as $nner_key => $inner_value) {
                $bag_name = $inner_value->name;
                $bag_id = $inner_value->id;
                $inner_bag_array[$bag_name]['bag'] =  $value[$bag_id]['bag'];
                $inner_bag_array[$bag_name]['kg'] =  $value[$bag_id]['kg'];
            }
            $details['details_arr'] = $inner_bag_array;
            $final_details[] = $details;
        }
        if (!empty($final_details)) {
            return response()->json(['response' => True, 'collection_details' => $final_details]);
        } else {
            return response()->json(['response' => False, 'collection_details' => $final_details]);
        }
    }

    public function get_client_payment_details(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $client_id = $request->client_id;
        $user_id = $request->user_id;
        $company_id = $request->company_id;
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        $payment_details_data = Payment::join('client', 'client.id', '=', 'payment.client')
            ->join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
            ->select(DB::raw("SUM(amount) as amount"), 'bulk_payment_id', 'payment.char_id as char_id', 'payment.client as client_id', 'client.business_name as business_name', DB::raw("SUM(security_amount) as security_amount"), DB::raw("SUM(registration_amount) as registration_amount"), DB::raw("SUM(is_previous_payment_amount) as is_previous_payment_amount"), DB::raw("SUM(is_on_account_payment) as is_on_account_payment"))
            ->where('employee_info.user_primary_id', $user_id)
            ->whereRaw("DATE_FORMAT(clearing_date,'%Y-%m-%d')>='$from_date' AND DATE_FORMAT(clearing_date,'%Y-%m-%d')<='$to_date'");
        if (!empty($client_id)) {
            $payment_details_data->where('client.id', $client_id);
        }
        $payment_details = $payment_details_data->groupBy('clearing_date', 'payment.client')->get();

        if (!empty($payment_details)) {
            return response()->json(['response' => True, 'payment_details' => $payment_details]);
        } else {
            return response()->json(['response' => False, 'payment_details' => $payment_details]);
        }
    }
    public function DepartmentAndSubType(Request $request)
    {

        $DepartmentQ = DB::table('department')->where('status', 1)->select('department.id as department_id', 'name');




        $Department = $DepartmentQ->orderBy('name', 'ASC')->get();

        $data_arr = array();
        foreach ($Department as $key => $value) {
            $comp_type = DB::table('_complaint_type')
                ->where('dept_id', $value->department_id)
                ->where('_complaint_type.status', 1)
                ->select('id', 'name', 'icon_code as icon_unicode')
                ->orderBy('name', 'ASC')->get();
            $data_arr[] = array(
                'dept_id' => $value->department_id,
                'department_name' => $value->name,
                'complaint_type' => $comp_type
            );
        }
        if (empty($data_arr)) {
            return response()->json(['response' => FALSE, 'message' => 'No record found']);
        }

        return response()->json(['response' => TRUE, 'data' => $data_arr]);
    }



    public function daily_reporting_pagination(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'company_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $daily_reporting_query = array();


        $page = '50';


        $schedule_name =  DB::table('_daily_schedule')->where('company_id', $request->company_id)->pluck('name', 'id');

        $daily_reporting_query = DB::table('daily_reporting')
            ->Join('employee_info', 'employee_info.user_primary_id', '=', 'daily_reporting.user_id')

            ->select('employee_info.contact_no as per_mobile', DB::raw("DATE_FORMAT(daily_reporting.work_date,'%d-%m-%Y') as wdate"), 'daily_reporting.working_with as working_with_id', DB::raw("CONCAT_WS(' ',f_name,l_name) AS user_name"), DB::raw("DATE_FORMAT(work_date,'%d-%m-%Y') AS date"), 'work_status', 'work_date', 'employee_info.user_primary_id AS user_id', 'remarks', 'daily_reporting.daily_schedule_id', 'daily_reporting.order_id')
            ->whereRaw("DATE_FORMAT(daily_reporting.work_date,'%Y-%m-%d')>='$request->from_date' AND DATE_FORMAT(daily_reporting.work_date,'%Y-%m-%d')<='$request->to_date'")
            ->where('employee_info.user_primary_id', $request->user_id)
            ->where('daily_reporting.company_id', $request->company_id)
            ->groupBy('employee_info.user_primary_id', 'work_date', 'daily_reporting.order_id')
            ->orderBy('work_date', 'ASC')
            ->paginate($page);
        $person_name = DB::table('employee_info')
            ->pluck(DB::raw("CONCAT_WS(' ',f_name,l_name) as working_with_name"), 'user_primary_id');

        $total = $daily_reporting_query->total();
        $lastPage = $daily_reporting_query->hasMorePages();

        if ($daily_reporting_query->currentPage() == 1) {
            $message = "Total $total records found";
        } elseif (!$lastPage) {
            $message = "No more records found";
        } else {
            $message = "";
        }


        $final_out_array = array();
        foreach ($daily_reporting_query as $key => $value) {
            $working_with_id = $value->working_with_id;
            if ($working_with_id == 0) {
                $working_with_name = "SELF";
            } else {
                $working_with_name = !empty($person_name[$working_with_id]) ? $person_name[$working_with_id] : '';
            }
            $landline = !empty($value->landline) ? $value->landline : '';
            $dealer_no = !empty($value->other_numbers) ? $value->other_numbers : $landline;
            $out['dealer_name'] = !empty($value->dealer_name) ? $value->dealer_name . "\n" . $dealer_no : '';
            $out['work_status_name'] = $value->work_status;
            $out['wdate'] = $value->wdate;
            $out['working_with'] = $working_with_name;
            $out['work_status'] = $value->work_status;
            $out['remarks'] = $value->remarks;
            $out['order_id'] = $value->order_id;
            $out['user_name'] = $value->user_name . "\n" . $value->per_mobile;
            $out['schedule_name'] = !empty($schedule_name[$value->daily_schedule_id]) ? $schedule_name[$value->daily_schedule_id] : '';
            $final_out_array[] = $out;
        }
        if (COUNT($final_out_array) > 0) {
            return response()->json(['response' => True, 'result' => $final_out_array, 'message' => "$message", 'per_page' => $daily_reporting_query->perPage(), 'nextPage' => $daily_reporting_query->currentPage() + 1, 'lastPage' => $daily_reporting_query->lastPage(), 'hasMorePages' => $daily_reporting_query->hasMorePages()]);
        } else {
            return response()->json(['response' => False, 'result' => $final_out_array]);
        }
    }

    public function agreementpdf(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_char_id' => 'required',
            'company_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }

        $client = DB::table('client')->where('client_char_id', $request->client_char_id)->first();
        $constitution = DB::table('constitution')->where('status', 1)->get();
        $client_group = DB::table('client_group')->where('status', 1)->get();
        //$date_flag = Date('Y-m-d', strtotime($client->agreement_end_date) + 86400); //adding 1 to a date to include both dates in the range
        $state = DB::table('master_state')->get();
        $distict = DB::table('district')->get();
        // dd($client);
        $state2 = DB::table('master_state')->where('id', $client->state1)->first();
        // dd($client->district1);
        $district2 = DB::table('district')->where('id', $client->district1)->first();
        // dd($district2);
        $new_address = (!empty($client->address1) ? $client->address1 . ', ' : '') . (!empty($district2->district) ? $district2->district . ', ' : '') . (!empty($state2->states) ? $state2->states . '-' . $client->pincode1 : '');

        $authorized_person = DB::table('client_agreement_person_list')->where('status', 1)->where('client_id', $client->id)->where('is_authorized_signatory', 1)->first();
        if (!empty($authorized_person)) {
            if ($client->name_of_person == $authorized_person->name) {
                $authorized_person = [];
            }
        }
        $authorized_person_array = DB::table('client_agreement_person_list')->where('status', 1)->where('client_id', $client->id)->where('is_authorized_signatory', 1)->get();

        if (!empty($client->parent_group)) {
            $client_parent_group = DB::table('client')->where('id', $client->parent_group)->first();
            // dd($client_parent_group);
            $state1 = DB::table('master_state')->where('id', $client_parent_group->state1)->first();
            $district1 = DB::table('district')->where('id', $client_parent_group->district1)->first();
            $parent_address = $client_parent_group->address1 . ', ' . $district1->district . ', ' . $state1->states . '-' . $client_parent_group->pincode1;
        } else {
            $parent_address = '';
        }

        $years = 0;
        $months = 0;
        $days = 0;
        if (!empty($client)) {
            // dd(1);
            $date_flag = Date('Y-m-d', strtotime($client->agreement_end_date) + 86400); //adding 1 to a date to include both dates in the range
            $diff = abs(strtotime($date_flag) - strtotime($client->agreement_start_date));
            $years = floor($diff / (365 * 60 * 60 * 24));
            $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
            $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
            // dd($years);

        }

        $number_to_text = [];
        $number_to_text[1] = "One";
        $number_to_text[2] = "Two";
        $number_to_text[3] = "Three";
        $number_to_text[4] = "Four";
        $number_to_text[5] = "Five";
        $number_to_text[6] = "Six";
        $number_to_text[7] = "Seven";
        $number_to_text[8] = "Eight";
        $number_to_text[9] = "Nine";
        $number_to_text[10] = "Ten";
        $number_to_text[11] = "Eleven";
        $number_to_text[12] = "Twelve";
        $number_to_text[13] = "Thirteen";
        $number_to_text[14] = "Forteen";
        $number_to_text[15] = "Fifteen";
        $number_to_text[16] = "Sixteen";
        $number_to_text[17] = "Seventeen";
        $number_to_text[18] = "Eighteen";
        $number_to_text[19] = "Nineteen";
        $number_to_text[20] = "Twenty";
        $number_to_text[21] = "Twenty One";
        $number_to_text[22] = "Twenty Two";
        $number_to_text[23] = "Twenty Three";
        $number_to_text[24] = "Twenty Four";
        $number_to_text[25] = "Twenty Five";
        $number_to_text[26] = "Twenty Six";
        $number_to_text[27] = "Twenty Seven";
        $number_to_text[28] = "Twenty Eight";
        $number_to_text[29] = "Twenty Nine";
        $number_to_text[30] = "Thirty";

        $cur_date = $client->agreement_start_date;
        //  dd($cur_date);
        $end_date = $client->agreement_end_date;
        $loop_start_date = strtotime($cur_date);
        $loop_end_date = strtotime($end_date);
        $each = $client->every;
        $ren_date = [];
        //dd($each);

        $amount = $client->minimum_amount;

        $rate = $client->rate_increment;
        $varamount = $amount;
        $incremented_amount = [$amount,];

        $is_rate_increment =  $client->is_rate_increment;


        if ($is_rate_increment == 1) {
            if ($client->duration == "Week") {
                $dur = $each * 7;
                $ren_date[] = $cur_date;
                $next_date = date('Y-m-d', strtotime($cur_date . $dur . 'days'));

                for ($d = $next_date; $d <= $end_date; $d = date('Y-m-d', strtotime($d . $dur . 'days'))) {
                    $ren_date[] = date('Y-m-d', strtotime($d . '-1 day'));
                    $ren_date[] = $d;

                    $varamount += $varamount * $rate / 100;
                    $incremented_amount[] = $varamount;
                }
                $ren_date[] = $end_date;

                // dd($cur_date, $end_date , $ren_date);
            } else if ($client->duration == "Month") {
                $ren_date[] = $cur_date;
                $next_date = date('Y-m-d', strtotime($cur_date . $each . 'months'));
                for ($d = $next_date; $d <= $end_date; $d = date('Y-m-d', strtotime($d . $each . 'months'))) {
                    $ren_date[] = date('Y-m-d', strtotime($d . '-1 day'));
                    $ren_date[] = $d;
                    $varamount += $varamount * $rate / 100;
                    $incremented_amount[] = $varamount;
                }
                // dd($ren_date);
                $ren_date[] = $end_date;
                // dd($cur_date, $end_date , $ren_date);

            } else if ($client->duration == "Year") {
                $ren_date[] = $cur_date;
                $next_date = date('Y-m-d', strtotime($cur_date . $each . 'years'));
                for ($d = $next_date; $d <= $end_date; $d = date('Y-m-d', strtotime($d . $each . 'years'))) {
                    $ren_date[] = date('Y-m-d', strtotime($d . '-1 day'));
                    $ren_date[] = $d;
                    $varamount += $varamount * $rate / 100;
                    $incremented_amount[] = $varamount;
                }
                // dd($ren_date);
                $ren_date[] = $end_date;
                // dd($cur_date, $end_date , $ren_date);
            } else {
                $ren_date[] = $cur_date;
                if (!empty($client->amount_renewal_date)) {
                    $ren_date[] = date('Y-m-d', strtotime($client->amount_renewal_date . '-1 day'));
                    $ren_date[] = $client->amount_renewal_date;
                }
                // dd($ren_date);
                $ren_date[] = $end_date;
                $varamount += $client->increment_amount;
                $incremented_amount[] = $varamount;
            }
        }







        $plant = DB::table('plant')
            ->join('master_state', 'plant.state', 'master_state.id')
            ->join('district', 'plant.district', 'district.id')
            ->where('plant.id', $client->plant)->first();
        $plant_address = (!empty($plant->address1) ? $plant->address1 . ', ' : '') . (!empty($plant->address2) ? $plant->address2 . ', ' : '') . (!empty($plant->district) ? $plant->district . ', ' : '') . (!empty($plant->states) ? $plant->states . '-' . $plant->pincode : '');
        // dd($client);
        $security_deposit = !empty($client->security_deposit) ? $client->security_deposit : 0;
        if ($client->billing_type == 1) {
            $advance_deposit = $client->advance_deposit;
            if ($client->minimum_amount != 0) {
                $advance_payment_equivalent_to_months = $client->advance_deposit / (float) $client->minimum_amount;
                $security_payment_equivalent_to_months = $client->security_deposit / (float) $client->minimum_amount;
            } else {
                $advance_payment_equivalent_to_months = 0.00;
                $security_payment_equivalent_to_months = 0.00;
            }
        } else if ($client->billing_type == 2) {
            $advance_deposit = $client->advance_deposit;
            $advance_payment_equivalent_to_months = $client->advance_deposit / (float) ($client->per_bed_total_beds * $client->per_bed_amount);

            $security_payment_equivalent_to_months = $client->security_deposit / (float) ($client->per_bed_total_beds * $client->per_bed_amount);
        } else if ($client->billing_type == 3) {
            $advance_deposit = $client->advance_deposit;
            $advance_payment_equivalent_to_months = $client->advance_deposit / (float) ($client->per_kg_total_beds * $client->per_kg_amount);

            $security_payment_equivalent_to_months = $client->security_deposit / (float) ($client->per_kg_total_beds * $client->per_kg_amount);
        } else {  //for error checking if none of the billing type is matched
            $advance_deposit = $client->advance_deposit;
            $advance_payment_equivalent_to_months = 0;
            $security_payment_equivalent_to_months = 0;
        }


        if (!empty($client->advance_deposit) && $client->advance_deposit != 0) {

            if ($client->billing_type == 1) {
                $advance_deposit_advance = $client->advance_deposit;
                $advance_payment_equivalent_to_months_advance = $client->advance_deposit / (float) $client->minimum_amount;

                $security_payment_equivalent_to_months_advance = $client->security_deposit / (float) $client->minimum_amount;
            } else if ($client->billing_type == 2) {
                $advance_deposit = $client->advance_deposit;
                $advance_payment_equivalent_to_months_advance = $client->advance_deposit / (float) ($client->per_bed_total_beds * $client->per_bed_amount);

                $security_payment_equivalent_to_months_advance = $client->security_deposit / (float) ($client->per_bed_total_beds * $client->per_bed_amount);
            } else if ($client->billing_type == 3) {
                $advance_deposit = $client->advance_deposit;
                $advance_payment_equivalent_to_months_advance = $client->advance_deposit / (float) ($client->per_kg_total_beds * $client->per_kg_amount);

                $security_payment_equivalent_to_months_advance = $client->security_deposit / (float) ($client->per_kg_total_beds * $client->per_kg_amount);
            } else {  //for error checking if none of the billing type is matched
                $advance_deposit = $client->advance_deposit;
                $advance_payment_equivalent_to_months_advance = 0;
                $security_payment_equivalent_to_months_advance = 0;
            }
        } else {
            $advance_deposit_advance = 0;
            $advance_payment_equivalent_to_months_advance = 0;
            $security_payment_equivalent_to_months_advance = 0;
        }


        if ($client->billing_type == 1) {
            $client_billing_numeric = $client->minimum_amount;
            $client_billing_numeric ?  $client_billing_words = self::getIndianCurrency($client->minimum_amount) : $client_billing_words = self::getIndianCurrency(0);
            // $client_billing_words = self::getIndianCurrency($client->minimum_amount);
        } else if ($client->billing_type == 2) {
            $client_billing_numeric = $client->per_bed_amount * $client->per_bed_total_beds;
            $client_billing_numeric ? $client_billing_words = self::getIndianCurrency($client->per_bed_amount * $client->per_bed_total_beds) : $client_billing_words = self::getIndianCurrency(0);
        } else if ($client->billing_type == 3) {
            $client_billing_numeric = $client->per_kg_amount * $client->per_kg_total_beds;
            $client_billing_numeric ? $client_billing_words = self::getIndianCurrency($client->per_kg_amount * $client->per_kg_total_beds) : $client_billing_words = self::getIndianCurrency(0);
        } else {  //for error checking if none of the billing type is matched
            $client_billing_numeric = 0;
            $client_billing_words = self::getIndianCurrency(0);
        }

        $pdf = PDF::loadView('Client/pdf/new_agreement_for_app', [
            'transport_details' => 'transport_details',
            'invoice_data' => 'invoice_data',
            'data_query' => 'data_query',
            'address_invoice' => 'address_invoice',
            'client' => $client,
            'constitution' => $constitution,
            'client_group' => $client_group,
            'state' => $state,
            'authorized_person_array' => $authorized_person_array,
            'custom_date' => $request->custom_date,
            'parent_address' => $parent_address,
            'client1' => $new_address,
            'client_billing_words' => $client_billing_words,
            'client_billing_numeric' => $client_billing_numeric,
            'years' => $years,
            'months' => $months,
            'days' => $days,
            'number_to_text' => $number_to_text,
            'date_list' => $ren_date,
            'amount_list' => $incremented_amount,
            'plant_address' => $plant_address,
            'advance_deposit' => $advance_deposit,
            'advance_payment_equivalent_to_months' => $advance_payment_equivalent_to_months,
            'security_deposit' => $security_deposit,
            'authorized_person' => $authorized_person,
            'security_payment_equivalent_to_months' => $security_payment_equivalent_to_months,
            'plant' => $plant,

            'advance_deposit_advance' => $advance_deposit_advance,
            'advance_payment_equivalent_to_months_advance' => round($advance_payment_equivalent_to_months_advance, 2),
            'security_payment_equivalent_to_months_advance' => $security_payment_equivalent_to_months_advance,


        ]);

        $name_of_pdf = date('YmdHis') . '.pdf';
        $pdf->save(public_path('app_pdf/' . $name_of_pdf));


        $data['client_char_id'] = $client->client_char_id;
        $data['business_name'] = $client->business_name;
        $data['name_of_person'] = $client->name_of_person;
        $data['person_contact'] = $client->person_contact;
        $data['person_email'] = $client->person_email;
        $data['pdf_path'] = 'https://synergy.msell.in/public/app_pdf/' . $name_of_pdf;

        $final_data[] = $data;

        if (!empty($final_data)) {
            return response()->json(['response' => True, 'result' => $final_data]);
        } else {
            return response()->json(['response' => False, 'result' => $final_data]);
        }
    }



    function getIndianCurrency(float $number)
    {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(
            0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Forteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        );
        $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? 'Rupees ' . $Rupees : '') . $paise . 'Only';
    }

    public function clientoptions(Request $request)
    {
        // dd($request);
        $search = $request->search;


        if ($search == '') {
            $clients = [];
        } else {
            $entry_type = $request->entry_type;
            $key = $request->key;
            $clients_data = DB::table('SYNERGY_ledgers')->select('id', 'name as text', 'code')->where('name', 'like', '%' . $search . '%')->limit(25);

            if ($entry_type == 1 && $key == 0) {
                $clients_data->where('SYNERGY_ledgers.type', 1);
            } else if ($entry_type == 1 && $key != 0) {
                $clients_data->where('SYNERGY_ledgers.type', '!=', 1);
            } else if ($entry_type == 2 && $key == 0) {
                $clients_data->where('SYNERGY_ledgers.type', 1);
            } else if ($entry_type == 2 && $key != 0) {
                $clients_data->where('SYNERGY_ledgers.type', '!=', 1);
            }
            $clients = $clients_data->get();
        }

        $response = array();
        foreach ($clients as $client) {
            $response[] = array(
                "id" => $client->id,
                "text" => $client->text,
                "code" => $client->code
            );
        }

        $results = [
            'results' => $response,
            "pagination" => [
                "more" =>  count($response) > 0 ? true : false
            ],
        ];
        return json_encode($results);
        // return response()->json($response); 
    }
    public function groupoptions(Request $request)
    {
        // dd($request);
        $search = $request->search;


        if ($search == '') {
            $clients = [];
        } else {
            $clients = DB::table('SYNERGY_groups')->select('id', 'name as text', 'code')->where('name', 'like', '%' . $search . '%')->limit(25)->get();
        }

        $response = array();
        foreach ($clients as $client) {
            $response[] = array(
                "id" => $client->id,
                "text" => $client->text,
                "code" => $client->code
            );
        }

        $results = [
            'results' => $response,
            "pagination" => [
                "more" =>  count($response) > 0 ? true : false
            ],
        ];
        return json_encode($results);
        // return response()->json($response); 
    }

    public function getclientlocation(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'company_id' => 'required',
            'lng' => 'required',
            'user_id' => 'required',
            'track_addr' => 'required',
            'client_char_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }

        $lat = $request->lat;
        $lng = $request->lng;
        $track_addr = $request->track_addr;
        $user_id = $request->user_id;
        $client_char_id = $request->client_char_id;

        $set_data = Client::where('client.client_char_id', $client_char_id)
            ->update([
                'lat' => $lat,
                'lng' => $lng,
                'track_addr' => $track_addr,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => $user_id
            ]);

        if ($set_data) {
            return response()->json(['response' => True, 'result' => 'Successfully Updated']);
        } else {
            return response()->json(['response' => False, 'result' => 'Not Updated Please Try Again']);
        }
    }
    public function checkbarcodekey(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'barcode_str' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $barcode_str = $request->barcode_str;
        $explode_str = explode('||', $barcode_str);
        if (empty($explode_str[0])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }
        if (empty($explode_str[1])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }
        if (empty($explode_str[2])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }

        // $data_set_details = HcfCollection::where('bag_p_id',$explode_str[2])->first();
        // $data_set = COUNT($data_set_details->);
        $data_set = 0;
        if ($data_set == 0 || $data_set == NULL || empty($data_set)) {
            $bag_details = DB::table('waste_container')->where('status', 1)->get();
            return response()->json(['response' => True, 'client_char_id' => $explode_str[0], 'bag_id' => $explode_str[1], 'unique_id' => $explode_str[2], 'bag_details' => $bag_details]);
        } else {
            return response()->json(['response' => False, 'result' => 'Data Already exist please scan another bag or contact adminstrator. Thank You! ']);
        }
    }
    public function barcode_check(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'barcode_str' => 'required',
            'user_id' => 'required',
            'user_type' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $barcode_str = $request->barcode_str;
        $explode_str = explode('||', $barcode_str);
        if (empty($explode_str[0])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }
        if (empty($explode_str[1])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }
        if (empty($explode_str[2])) {
            return response()->json(['response' => False, 'result' => 'Scan Properly']);
        }
        // dd($explode_str[2]);
        $str_bag_p_id = (int)($explode_str[2]);
        $user_id = $request->user_id;
        $user_type = $request->user_type;

        if($user_type == '1'){

            $get_waste_collector_details = Route::join('vehicle_registration','vehicle_registration.id','=','routes.vehicle')
                                            ->join('users', 'users.id', '=', 'vehicle_registration.executive_id')
                                            ->join('client_routes', 'routes.id', '=', 'client_routes.route_id')
                                            ->join('client', 'client.id', '=', 'client_routes.client_id')
                                            ->select('users.*','client.business_name as business_name','client.id as client_id')
                                            ->where('client.client_char_id',$explode_str[0])
                                            ->first();
                    // dd($get_waste_collector_details);
            if(empty($get_waste_collector_details->client_id)){
                return response()->json(['response' => False, 'result' => 'You are not in route,So please contact with adminstrator. Thank You! ']);
            }
        }else{
            $get_waste_collector_details = Route::join('vehicle_registration','vehicle_registration.id','=','routes.vehicle')
                                            ->join('users', 'users.id', '=', 'vehicle_registration.executive_id')
                                            ->join('client_routes', 'routes.id', '=', 'client_routes.route_id')
                                            ->join('client', 'client.id', '=', 'client_routes.client_id')
                                            ->select('users.*','client.business_name as business_name','client.id as client_id')
                                            ->where('client.client_char_id',$explode_str[0])
                                            ->where('vehicle_registration.executive_id',$user_id)
                                            ->first();
                    // dd($get_waste_collector_details);
            if(empty($get_waste_collector_details->client_id)){
                return response()->json(['response' => False, 'result' => 'This Client is not in your route please check or contact with adminstrator. Thank You! ']);
            }
        }
        // dd($str_bag_p_id);
        if ($str_bag_p_id == 0) {
            $data_set = 0;
        } else {

            $data_set_details = HcfCollection::where('bag_p_id', $str_bag_p_id)->first();
            // dd($data_set_details);
            if (!empty($data_set_details->id)) {
                return response()->json(['response' => False, 'result' => 'Data Already exist please scan another bag or contact adminstrator. Thank You! ']);
            } else {
                $data_set = 0;
            }
        }

        if ($data_set == 0 || $data_set == NULL || empty($data_set)) {
            $bag_details = DB::table('waste_container')->where('status', 1)->get();
            return response()->json(['response' => True, 'client_char_id' => $explode_str[0], 'bag_id' => $explode_str[1], 'unique_id' => $explode_str[2], 'bag_details' => $bag_details]);
        } else {
            return response()->json(['response' => False, 'result' => 'Data Already exist please scan another bag or contact adminstrator. Thank You! ']);
        }
    }
    public function wastecontainersubmit_old(Request $request)
    {

        $bag_name = [];
        $bag_count_name = [];
        $this_client_total_quantity = 0;
        $this_client_total_bag = 0;
        $date = '';

        $validator = Validator::make($request->all(), [
            'info_weight' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $response_data = json_decode($request->info_weight);
        if (!empty($response_data->client_char_id)) {

            $clientData = DB::table('client')
                ->join('client_routes', 'client.id', '=', 'client_routes.client_id')
                ->join('routes', 'routes.id', '=', 'client_routes.route_id')
                ->select('client.*', 'client_routes.route_id as client_route_id', 'routes.name as client_route_name', 'client_routes.client_address as client_full_address')
                ->where('client.client_char_id', $response_data->client_char_id)
                ->first();
            if (!empty($clientData)) {
                $date_time = !empty($response_data->bag_details) ? $response_data->bag_details[0]->date_time : '';
                $date = !empty($date_time) ? date('Y-m-d', strtotime($date_time)) : '';

                $prev_entry = HcfCollection::where('client_id', $clientData->id)
                    ->where('date', $date)
                    ->where('route_id', $clientData->client_route_id)->first();

                if (!empty($prev_entry)) {
                    if (!empty($response_data->bag_details)) {

                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_entry = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_entry->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_entry->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_entry->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_entry->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_entry->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_entry->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollection::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_update && $ins_update_2) {
                        return response()->json(['response' => TRUE, 'result' => 'Data Saved Successfully! ']);
                    } 
                    else {
                        return response()->json(['response' => FALSE, 'result' => 'Data Not Saved! ']);
                    }
                } 
                else {
                    $hcfCollection = HcfCollection::select('id')->orderBy('id', 'desc')->first();
                    $char_id = !empty($hcfCollection) ? "WCLn" . ($hcfCollection->id + 1 + 1000) : 'WCLn1000';
                    $ins_data = HcfCollection::insert([
                        'char_id' => $char_id,
                        'route_id' => $clientData->client_route_id,
                        'plant' => $clientData->plant,
                        'route_name' => $clientData->client_route_name,
                        'client_id' => $clientData->id,
                        'client_name' => $clientData->business_name,
                        'client_address' => $clientData->client_full_address,
                        'is_active_client' => $clientData->status,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'date' => !empty($response_data->bag_details[0]) ? date('Y-m-d', strtotime($response_data->bag_details[0]->date_time)) : Null,
                        'created_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                        'updated_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                    ]);


                    if (!empty($response_data->bag_details)) {
                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_inserted_details = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_inserted_details->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_inserted_details->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_inserted_details->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_inserted_details->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_inserted_details->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_inserted_details->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollection::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_data && $ins_update && $ins_update_2) {

                        return response()->json(['response' => True, 'message' => 'Data Saved Successfully']);
                    } else {
                        return response()->json(['response' => False, 'message' => 'Failed To Save Data']);
                    }
                }
            } else {
                return response()->json(['response' => False, 'message' => 'Client Data Not Found']);
            }
        } else {
            return response()->json(['response' => False, 'message' => 'Client Char Id Not Found']);
        }
    }

    // public function wastecontainersubmit_temp(Request $request)
    // {

    //     $bag_name = [];
    //     $bag_count_name = [];
    //     $this_client_total_quantity = 0;
    //     $this_client_total_bag = 0;
    //     $date = '';

    //     $validator = Validator::make($request->all(), [
    //         'info_weight' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
    //     }
    //     $response_data = json_decode($request->info_weight);
    //     if (!empty($response_data->client_char_id)) {
    //         $clientData = DB::table('client')
    //             ->join('client_routes', 'client.id', '=', 'client_routes.client_id')
    //             ->join('routes', 'routes.id', '=', 'client_routes.route_id')
    //             ->select('client.*', 'client_routes.route_id as client_route_id', 'routes.name as client_route_name', 'client_routes.client_address as client_full_address')
    //             ->where('client.client_char_id', $response_data->client_char_id)
    //             ->first();

    //         $hcfCollection = HcfCollectionTemp::select('id')->orderBy('id', 'desc')->first();
    //         $char_id = !empty($hcfCollection) ? "WCLn" . ($hcfCollection->id + 1 + 1000) : 'WCLn1000';
    //         $ins_data = HcfCollectionTemp::insert([
    //             'char_id' => $char_id,
    //             'route_id' => $clientData->client_route_id,
    //             'plant' => $clientData->plant,
    //             'route_name' => $clientData->client_route_name,
    //             'client_id' => $clientData->id,
    //             'client_name' => $clientData->business_name,
    //             'client_address' => $clientData->client_full_address,
    //             'is_active_client' => $clientData->status,
    //             'status' => 1,
    //             'created_at' => date('Y-m-d H:i:s'),
    //             'updated_at' => date('Y-m-d H:i:s'),
    //             'date' => !empty($response_data->bag_details[0]) ? date('Y-m-d', strtotime($response_data->bag_details[0]->date_time)) : Null,
    //             'created_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
    //             'updated_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
    //         ]);


    //         if (!empty($response_data->bag_details)) {

    //             foreach ($response_data->bag_details as $inc => $value) {
    //                 $container_details = DB::table('waste_container')->find($value->bag_id);
    //                 if (!empty($container_details)) {
    //                     $bag_name[$value->bag_id] = $container_details->collection_col_name;
    //                     $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
    //                 }

    //                 $this_client_total_quantity += $value->weight;
    //                 $this_client_total_bag += $value->bag_count;
    //                 $date = date('Y-m-d', strtotime($value->date_time));
    //                 $ins_update = HcfCollectionTemp::where('client_id', $clientData->id)
    //                     ->where('date', $date)
    //                     ->where('route_id', $clientData->client_route_id)
    //                     ->update([
    //                         $bag_name[$value->bag_id] => $value->weight,
    //                         $bag_count_name[$value->bag_id] => $value->bag_count,
    //                         'bag_p_id' => $value->unique_id,

    //                     ]);
    //             }
    //         }
    //         if (!empty($date)) {
    //             $ins_update_2 = HcfCollectionTemp::where('client_id', $clientData->id)
    //                 ->where('date', $date)
    //                 ->where('route_id', $clientData->client_route_id)
    //                 ->update([
    //                     'this_client_total_quantity' => $this_client_total_quantity,
    //                     'this_client_total_bag' => $this_client_total_bag,
    //                     'total_collection' => $this_client_total_quantity,
    //                     'total_bag' => $this_client_total_bag
    //                 ]);
    //         }
    //     }
    //     if ($ins_data && $ins_update && $ins_update_2) {

    //         return response()->json(['response' => True, 'message' => 'Data Saved Successfully']);
    //     } else {
    //         return response()->json(['response' => False, 'message' => 'Failed To Save Data']);
    //     }
    // }
    public function notification_list(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }

        $user_id = $request->user_id;
        $get_data = Notification::join('client','client.id','=','notification.client_id')
                ->select('client.client_char_id','client.business_name as client_name','notification.*')
                ->where('user_id',$user_id)->groupBy('notification.id')->orderBy('id','DESC')->get();
        return response()->json(['response' => True, 'data' => $get_data]);
    }

    public function wastecontainersubmit_temp(Request $request)
    {

        $bag_name = [];
        $bag_count_name = [];
        $this_client_total_quantity = 0;
        $this_client_total_bag = 0;
        $date = '';

        $validator = Validator::make($request->all(), [
            'info_weight' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $response_data = json_decode($request->info_weight);
        if (!empty($response_data->client_char_id)) {

            $get_waste_collector_details = Route::join('vehicle_registration','vehicle_registration.id','=','routes.vehicle')
                                            ->join('users', 'users.id', '=', 'vehicle_registration.executive_id')
                                            ->join('client_routes', 'routes.id', '=', 'client_routes.route_id')
                                            ->join('client', 'client.id', '=', 'client_routes.client_id')
                                            ->select('users.*','client.business_name as business_name','client.id as client_id')
                                            ->where('client.client_char_id',$response_data->client_char_id)
                                            ->first();

            $fcm_token = $get_waste_collector_details->fcm_token;
            $user_id = $get_waste_collector_details->id;
            $msg = 'hi todays weight scanned by client : '.$get_waste_collector_details->business_name;
            $date_time = date('d-m-Y H:i:s');
            $data = [
                        'msg' => $msg,
                        'body' => $msg,
                        'title' => 'Waste Notification'.' :'.$date_time,
                        'sound' => 'mySound'/*Default sound*/

                ];
            $notification_send = Notification::notification($fcm_token,$data);
            $insert = Notification::create([
                    'user_id'=>$user_id,
                    'client_id'=>$get_waste_collector_details->client_id,
                    'fcm_token'=>$fcm_token,
                    'created_at'=>date('Y-m-d H:i:s',strtotime($date_time)),
                    'created_by'=>0,
                    'msg'=>$msg
            ]);



            $clientData = DB::table('client')
                ->join('client_routes', 'client.id', '=', 'client_routes.client_id')
                ->join('routes', 'routes.id', '=', 'client_routes.route_id')
                ->select('client.*', 'client_routes.route_id as client_route_id', 'routes.name as client_route_name', 'client_routes.client_address as client_full_address')
                ->where('client.client_char_id', $response_data->client_char_id)
                ->first();
            if (!empty($clientData)) {
                $date_time = !empty($response_data->bag_details) ? $response_data->bag_details[0]->date_time : '';
                $date = !empty($date_time) ? date('Y-m-d', strtotime($date_time)) : '';

                $prev_entry = HcfCollectionTemp::where('client_id', $clientData->id)
                    ->where('date', $date)
                    ->where('route_id', $clientData->client_route_id)->first();

                if (!empty($prev_entry)) {
                    if (!empty($response_data->bag_details)) {

                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_entry = HcfCollectionTemp::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_entry->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_entry->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollectionTemp::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_entry->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_entry->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_entry->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_entry->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollectionTemp::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_update && $ins_update_2) {
                        return response()->json(['response' => TRUE, 'result' => 'Data Saved Successfully! ']);
                    } 
                    else {
                        return response()->json(['response' => FALSE, 'result' => 'Data Not Saved! ']);
                    }
                } 
                else {
                    $hcfCollection = HcfCollectionTemp::select('id')->orderBy('id', 'desc')->first();
                    $char_id = !empty($hcfCollection) ? "WCLn" . ($hcfCollection->id + 1 + 1000) : 'WCLn1000';
                    $ins_data = HcfCollectionTemp::insert([
                        'char_id' => $char_id,
                        'route_id' => $clientData->client_route_id,
                        'plant' => $clientData->plant,
                        'route_name' => $clientData->client_route_name,
                        'client_id' => $clientData->id,
                        'client_name' => $clientData->business_name,
                        'client_address' => $clientData->client_full_address,
                        'is_active_client' => $clientData->status,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'date' => !empty($response_data->bag_details[0]) ? date('Y-m-d', strtotime($response_data->bag_details[0]->date_time)) : Null,
                        'created_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                        'updated_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                    ]);


                    if (!empty($response_data->bag_details)) {
                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_inserted_details = HcfCollectionTemp::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_inserted_details->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_inserted_details->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollectionTemp::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_inserted_details->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_inserted_details->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_inserted_details->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_inserted_details->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollectionTemp::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_data && $ins_update && $ins_update_2) {

                        return response()->json(['response' => True, 'message' => 'Data Saved Successfully']);
                    } else {
                        return response()->json(['response' => False, 'message' => 'Failed To Save Data']);
                    }
                }
            } else {
                return response()->json(['response' => False, 'message' => 'Client Data Not Found']);
            }
        } else {
            return response()->json(['response' => False, 'message' => 'Client Char Id Not Found']);
        }
    }

    public function update_hcf_client(Request $request)
    {
        $user_id = $request->user_id;

        $client_details_arr_set = array();
        $client_details = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
            ->join('district', 'district.id', '=', 'client.district1')
            ->join('master_state', 'master_state.id', '=', 'client.state1')
            ->select('client.*', 'district.district as district_name', 'master_state.states as state_name')
            ->where('employee_info.user_primary_id', $user_id)
            // ->whereIn('client.client_type',$beat_id)
            ->get();

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
        if (!empty($client_details_arr_set)) {

            return response()->json(['response' => True, 'hcf_client' => $client_details_arr_set, 'message' => '']);
        } else {
            return response()->json(['response' => False, 'hcf_client' => $client_details_arr_set, 'message' => "Not Found"]);
        }
    }
    public function submit_bulk_credit(Request $request)
    {
        // dd($request);
        $get_entry_item_details = $request->data['Entryitem'];
        $plant_char_id = $request->data['Entry']['plant_char_id'];
        $entry_type = $request->data['Entry']['entry_type'];
        $credit_ledger = $request->data['Entry']['credit_ledger'];
        $temp_date = str_replace('/', '-', $request->data['Entry']['date']);
        $date = date('Y-m-d', strtotime($temp_date));
        // dd($date,$request->data['Entry']['date']);
        // dd($get_entry_item_details);
        if (empty($get_entry_item_details)) {
            return response()->json(['response' => False, 'message' => "Please Enter Debit ledger and Amount details correctly", 'code' => 12]);
        }
        if (empty($credit_ledger)) {
            return response()->json(['response' => False, 'message' => "Please Select Credit Ledger correctly", 'code' => 12]);
        }
        if (empty($date)) {
            return response()->json(['response' => False, 'message' => "Please Enter Proper date", 'code' => 12]);
        }
        if (empty($plant_char_id)) {
            return response()->json(['response' => False, 'message' => "Please Select Plant Properly", 'code' => 12]);
        }
        DB::beginTransaction();
        foreach ($get_entry_item_details as $key => $value) {
            // code...
            // dd($value);
            if (empty($value)) {
                return response()->json(['response' => False, 'message' => "Unknown error ", 'code' => 12]);
            }
            if (empty($value['dr_amount'])) {
                return response()->json(['response' => False, 'message' => "Please Enter Debit Amount correctly at row ", 'code' => 12]);
            }
            if (empty($value['ledger_id'])) {
                return response()->json(['response' => False, 'message' => "Please Select Ledger correctly at row ", 'code' => 12]);
            }
            $dc = $value['dc'];
            $ledger_id = $value['ledger_id'];
            $dr_amount = $value['dr_amount'];
            $narration = !empty($value['narration']) ? $value['narration'] : '';
            if (!empty($dr_amount)) {
                $last_entry_data = AccountingEntry::orderBy('id', 'DESC')->first();
                // dd($last_entry_data);
                $last_id = $last_entry_data->id + 1;
                // dd($last_id);
                $entry_arr = [
                    'entrytype_id' => $entry_type,
                    'number' => 'BCV-' . $last_id,
                    'date' => $date,
                    'dr_total' => $dr_amount,
                    'cr_total' => $dr_amount,
                    'narration' => $narration,
                    'plant_char_id' => $plant_char_id,
                    'is_locked' => 0,
                ];
                // dd($last_entry_data,$entry_arr);
                $store_entry = AccountingEntry::create($entry_arr);
                if ($store_entry) {
                    $entry_id = $store_entry->id;
                    if (empty($entry_id)) {
                        return response()->json(['response' => False, 'message' => "Something Wrong in insertion please contact and then try again", 'code' => 12]);
                    }
                    

                    $store_in_synergy_item_credit = [
                        'entry_id' => $entry_id,
                        'ledger_id' => $credit_ledger,
                        'amount' => $dr_amount,
                        'dc' => 'C',
                        'item_narration' => $narration,
                    ];
                    $store_entry_item_credit = AccountingEntryItem::create($store_in_synergy_item_credit);

                    $store_in_synergy_item = [
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_id,
                        'amount' => $dr_amount,
                        'dc' => 'D',
                        'item_narration' => $narration,
                    ];
                    $store_entry_item = AccountingEntryItem::create($store_in_synergy_item);

                    if ($store_entry_item) {
                    } else {
                        DB::rollback();
                    }
                }
            } else {
                // dd('1');s
                DB::rollback();
                return response()->json(['response' => False, 'message' => "Please Enter Debit Amount correctly", 'code' => 12]);
            }
        }

        DB::commit();
        return response()->json(['response' => True, 'message' => "Successfully Generated", 'code' => 200]);
    }
    public function submit_bulk_debit(Request $request)
    {
        // dd($request);
        $get_entry_item_details = $request->data['Entryitem'];
        $plant_char_id = $request->data['Entry']['plant_char_id'];
        $entry_type = $request->data['Entry']['entry_type'];
        $debit_ledger = $request->data['Entry']['debit_ledger'];
        $temp_date = str_replace('/', '-', $request->data['Entry']['date']);
        $date = date('Y-m-d', strtotime($temp_date));
        // dd($date,$request->data['Entry']['date']);
        // dd($get_entry_item_details);
        if (empty($get_entry_item_details)) {
            return response()->json(['response' => False, 'message' => "Please Enter Credit ledger and Amount details correctly", 'code' => 12]);
        }
        if (empty($debit_ledger)) {
            return response()->json(['response' => False, 'message' => "Please Select debit Ledger correctly", 'code' => 12]);
        }
        if (empty($date)) {
            return response()->json(['response' => False, 'message' => "Please Enter Proper date", 'code' => 12]);
        }
        if (empty($plant_char_id)) {
            return response()->json(['response' => False, 'message' => "Please Select Plant Properly", 'code' => 12]);
        }
        DB::beginTransaction();
        foreach ($get_entry_item_details as $key => $value) {
            // code...
            // dd($value);
            if (empty($value)) {
                return response()->json(['response' => False, 'message' => "Unknown error ", 'code' => 12]);
            }
            if (empty($value['cr_amount'])) {
                return response()->json(['response' => False, 'message' => "Please Enter Credit Amount correctly at row ", 'code' => 12]);
            }
            if (empty($value['ledger_id'])) {
                return response()->json(['response' => False, 'message' => "Please Select Ledger correctly at row ", 'code' => 12]);
            }
            $dc = $value['dc'];
            $ledger_id = $value['ledger_id'];
            $cr_amount = $value['cr_amount'];
            $narration = !empty($value['narration']) ? $value['narration'] : '';
            if (!empty($cr_amount)) {
                $last_entry_data = AccountingEntry::orderBy('id', 'DESC')->first();
                // dd($last_entry_data);
                $last_id = $last_entry_data->id + 1;
                // dd($last_id);
                $entry_arr = [
                    'entrytype_id' => $entry_type,
                    'number' => 'BDV-' . $last_id,
                    'date' => $date,
                    'dr_total' => $cr_amount,
                    'cr_total' => $cr_amount,
                    'narration' =>  $narration,
                    'plant_char_id' => $plant_char_id,
                    'is_locked' => 0,
                ];
                // dd($last_entry_data,$entry_arr);
                $store_entry = AccountingEntry::create($entry_arr);
                if ($store_entry) {
                    $entry_id = $store_entry->id;
                    if (empty($entry_id)) {
                        return response()->json(['response' => False, 'message' => "Something Wrong in insertion please contact and then try again", 'code' => 12]);
                    }
                    $store_in_synergy_item = [
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_id,
                        'amount' => $cr_amount,
                        'dc' => 'C',
                        'item_narration' => $narration,
                    ];
                    $store_entry_item = AccountingEntryItem::create($store_in_synergy_item);

                    $store_in_synergy_item_credit = [
                        'entry_id' => $entry_id,
                        'ledger_id' => $debit_ledger,
                        'amount' => $cr_amount,
                        'dc' => 'D',
                        'item_narration' => $narration,
                    ];
                    $store_entry_item_credit = AccountingEntryItem::create($store_in_synergy_item_credit);

                    if ($store_entry_item) {
                    } else {
                        DB::rollback();
                    }
                }
            } else {
                // dd('1');s
                DB::rollback();
                return response()->json(['response' => False, 'message' => "Please Enter Debit Amount correctly", 'code' => 12]);
            }
        }

        DB::commit();
        return response()->json(['response' => True, 'message' => "Successfully Generated", 'code' => 200]);
    }

    public function hcfCollectiontempReport(Request $request)
    {
        $get_user_id = $request->user_id;
        $client_id = $request->client_id;

        // $client_details = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
        //     ->join('district', 'district.id', '=', 'client.district1')
        //     ->join('master_state', 'master_state.id', '=', 'client.state1')
        //     // ->select('client.*', 'district.district as district_name', 'master_state.states as state_name')
        //     ->where('employee_info.user_primary_id', $get_user_id)
        //     ->pluck('client.id as client_id');

        $get_data = HcfCollectionTemp::join('client','client.id','=','hcf_collection_temp.client_id')
                    ->join('routes','routes.id','=','hcf_collection_temp.route_id')
                    ->join('plant','plant.id','=','hcf_collection_temp.plant')
                    ->select('routes.name as route_name','client.id as client_id','routes.id as route_id','client.client_char_id as client_char_id','client.business_name as client_name',DB::raw("SUM(IFNULL(bag0quantity,'0')+IFNULL(bag1quantity,'0')+IFNULL(bag2quantity,'0')+IFNULL(bag3quantity,'0')) as total_weight"),DB::raw("SUM(IFNULL(bag0number,'0')+IFNULL(bag1number,'0')+IFNULL(bag2number,'0')+IFNULL(bag3number,'0')) as total_bag"),DB::raw("date_format(date,'%d-%m-%Y') as date"),'plant.name as plant_name','agree_status')
                    ->where('client_id', $client_id)
                    ->where('agree_status',0)
                    ->groupBy('client_id', 'date', 'route_id')
                    ->orderBy('hcf_collection_temp.date','DESC')
                    ->get();

        $bag_details = DB::table('waste_container')->where('status', 1)->get();
        return response()->json(['response' => True, 'message' => "Found", 'report_data' => $get_data, 'bag_master_details' => $bag_details]);
    }
    public function master_dropdown_api(Request $request)
    {

        $routes_mast_arr_out = [];
        $dist_arr = [];
        $client_details_arr_set = array();
        $dist_id = $request->dist_id;
        $route_id = $request->route_id;
        $client_char_id = $request->client_char_id;

        $town = District::join('client', 'district.id', '=', 'client.district1')->select('district.*')->groupBy('district.id')->get();
        if (!empty($town)) {
            foreach ($town as $key => $value) {
                // code...
                $town_arr['id'] = $value->id;
                $town_arr['town_name'] = $value->district;
                $dist_arr[] = $town_arr;
            }
        }

        if (!empty($dist_id)) {

            $route_master_data = Route::join('client_routes', 'client_routes.route_id', '=', 'routes.id')
                ->join('client', 'client_routes.client_id', '=', 'client.id')
                ->select('routes.*')
                ->groupBy('routes.id');
            if (!empty($dist_id)) {
                $route_master_data->where('client.district1', $dist_id);
            }
            $route_master = $route_master_data->orderBy('routes.created_at', 'ASC')->get();

            if (!empty($route_master)) {
                foreach ($route_master as $key => $r_value) {
                    // code...
                    $routes_mast_arr['id'] = $r_value->id;
                    $routes_mast_arr['town_name'] = $r_value->name;
                    $routes_mast_arr_out[] = $routes_mast_arr;
                }
            }

            $user_id = $request->user_id;
            $dist_id = $request->dist_id;
            $route_id = $request->route_id;
            $client_char_id = $request->client_char_id;

            $client_details_data = Client::join('employee_info', 'employee_info.user_primary_id', '=', 'client.executive')
                ->join('client_routes', 'client_routes.client_id', '=', 'client.id')
                ->join('district', 'district.id', '=', 'client.district1')
                ->join('master_state', 'master_state.id', '=', 'client.state1')
                ->select('client.*', 'district.district as district_name', 'master_state.states as state_name');
            // ->where('employee_info.user_primary_id', $user_id)
            // ->whereIn('client.client_type', $beat_id);
            if (!empty($dist_id)) {
                $client_details_data->where('district.id', $dist_id);
            }
            if (!empty($route_id)) {
                $client_details_data->where('client_routes.route_id', $route_id);
            }
            if (!empty($client_char_id)) {
                $client_details_data->where('client_routes.client_char_id', $client_char_id);
            }
            $client_details = $client_details_data->get();

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
        }
        return response()->json(['response' => True, 'message' => "Found", 'dist_arr' => $dist_arr, 'route_master_arr' => $routes_mast_arr_out, 'client_arr' => $client_details_arr_set]);
    }

    public function syncClientClosingBalance(Request $request)
    {
        // dd($request->response);
        $get_json_str = json_decode($request->response);
        // $decoded_str = json
        // dd();
        $ledger_type = $get_json_str->ledger_type;
        $data = [];
        if (!empty($get_json_str->response)) {
            foreach ($get_json_str->response as $key => $clientData) {
                // code...
                // dd($value);
                if ($clientData->closing_balance || $clientData->closing_balance == 0) {
                    $client = Client::where('client_char_id', $clientData->client_char_id)->first();
                    // dd($client);
                    $closingBalance = ($clientData->closing_balance * -1);

                    if ($client) {
                        if ($ledger_type == ConstantHelper::SUNDRY_DEBTORS) {
                            $client->closing_balance = $closingBalance;
                        } else {
                            $client->sec_closing_balance = $closingBalance;
                        }
                        $client->save();

                        // Find Ledger && Sync into Accounting Application
                        // GET CLIENT SUNDRY DEBTORS LEDGER
                        $ledgerCode = $ledger_type == ConstantHelper::SUNDRY_DEBTORS ? $clientData->client_char_id : $clientData->client_char_id . '-SEC';
                        $sundryAccountingLedger = AccountingLedger::where('code', $ledgerCode)->first();
                        if ($sundryAccountingLedger) {
                            if ($closingBalance < 0) {
                                $opBalanceType = 'C';
                            } else {
                                $opBalanceType = 'D';
                            }
                            $sundryAccountingLedger->op_balance = abs($closingBalance);
                            $sundryAccountingLedger->op_balance_dc = $opBalanceType;
                            $sundryAccountingLedger->update();
                        }
                    }

                    $data[] = $clientData;
                }
            }
            if (count($data) > 0) {
                // \Session::flash("flash_notification", [
                //     "message"   => "Client closing balance synced successfully.",
                //     "type"   => "success",
                //     "data" => $data
                // ]);
                return response()->json(['response' => True, 'message' => "Client closing balance synced successfully"]);
                // return redirect('syncClientClosingBalance')->with('success','Inserted Successfully');
            } else {
                return response()->json(['response' => True, 'message' => "No closing balance found for sync."]);
                // \Session::flash("flash_notification", [
                //     "message"   => "No closing balance found for sync.",
                //     "type"   => "danger",
                //     "data" => null
                // ]);
                // return redirect('syncClientClosingBalance')->with('success','Inserted Successfully');
            }
        }
    }


    public function wastecontainersubmit(Request $request)
    {

        $bag_name = [];
        $bag_count_name = [];
        $this_client_total_quantity = 0;
        $this_client_total_bag = 0;
        $date = '';

        $validator = Validator::make($request->all(), [
            'info_weight' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $response_data = json_decode($request->info_weight);
        if (!empty($response_data->client_char_id)) {

            $clientData = DB::table('client')
                ->join('client_routes', 'client.id', '=', 'client_routes.client_id')
                ->join('routes', 'routes.id', '=', 'client_routes.route_id')
                ->select('client.*', 'client_routes.route_id as client_route_id', 'routes.name as client_route_name', 'client_routes.client_address as client_full_address')
                ->where('client.client_char_id', $response_data->client_char_id)
                ->first();
            if (!empty($clientData)) {
                $date_time = !empty($response_data->bag_details) ? $response_data->bag_details[0]->date_time : '';
                $date = !empty($date_time) ? date('Y-m-d', strtotime($date_time)) : '';

                $prev_entry = HcfCollection::where('client_id', $clientData->id)
                    ->where('date', $date)
                    ->where('route_id', $clientData->client_route_id)->first();

                if (!empty($prev_entry)) {
                    if (!empty($response_data->bag_details)) {

                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_entry = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_entry->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_entry->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_entry->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_entry->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_entry->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_entry->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollection::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_update && $ins_update_2) {
                        return response()->json(['response' => TRUE, 'result' => 'Data Saved Successfully! ']);
                    } 
                    else {
                        return response()->json(['response' => FALSE, 'result' => 'Data Not Saved! ']);
                    }
                } 
                else {
                    $hcfCollection = HcfCollection::select('id')->orderBy('id', 'desc')->first();
                    $char_id = !empty($hcfCollection) ? "WCLn" . ($hcfCollection->id + 1 + 1000) : 'WCLn1000';
                    $ins_data = HcfCollection::insert([
                        'char_id' => $char_id,
                        'route_id' => $clientData->client_route_id,
                        'plant' => $clientData->plant,
                        'route_name' => $clientData->client_route_name,
                        'client_id' => $clientData->id,
                        'client_name' => $clientData->business_name,
                        'client_address' => $clientData->client_full_address,
                        'is_active_client' => $clientData->status,
                        'status' => 1,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'date' => !empty($response_data->bag_details[0]) ? date('Y-m-d', strtotime($response_data->bag_details[0]->date_time)) : Null,
                        'created_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                        'updated_by' => !empty($response_data->bag_details[0]) ? $response_data->bag_details[0]->user_id : '',
                    ]);


                    if (!empty($response_data->bag_details)) {
                        foreach ($response_data->bag_details as $inc => $value) {
                            $container_details = DB::table('waste_container')->find($value->bag_id);
                            if (!empty($container_details)) {
                                $bag_name[$value->bag_id] = $container_details->collection_col_name;
                                $bag_count_name[$value->bag_id] = $container_details->collection_bag_count_name;
                            }
                            $prev_inserted_details = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)->first();
                            $this_client_total_quantity += $value->weight;
                            $this_client_total_bag += $value->bag_count;
                            $date = date('Y-m-d', strtotime($value->date_time));
                            $bag_final_name = $bag_name[$value->bag_id];
                            $bag_final_count = $bag_count_name[$value->bag_id];
                            $new_updated_weight = (float)$prev_inserted_details->$bag_final_name + $value->weight;
                            $new_updated_bag_count = (int)$prev_inserted_details->$bag_final_count + $value->bag_count;

                            $ins_update = HcfCollection::where('client_id', $clientData->id)
                                ->where('date', $date)
                                ->where('route_id', $clientData->client_route_id)
                                ->update([
                                    $bag_name[$value->bag_id] => $new_updated_weight,
                                    $bag_count_name[$value->bag_id] => $new_updated_bag_count,
                                    'bag_p_id' => $value->unique_id,

                                ]);
                        }
                    }
                    if (!empty($date)) {
                        $new_total_quantity = (float)$prev_inserted_details->this_client_total_quantity + $this_client_total_quantity;
                        $new_total_bag = (int)$prev_inserted_details->this_client_total_bag + $this_client_total_bag;
                        $new_total_bag_total = (int)$prev_inserted_details->total_bag + $this_client_total_bag;
                        $new_total_weight_total = (float)$prev_inserted_details->total_collection + $this_client_total_quantity;
                        $ins_update_2 = HcfCollection::where('client_id', $clientData->id)
                            ->where('date', $date)
                            ->where('route_id', $clientData->client_route_id)
                            ->update([
                                'this_client_total_quantity' => $new_total_quantity,
                                'this_client_total_bag' => $new_total_bag,
                                'total_collection' => $new_total_weight_total,
                                'total_bag' => $new_total_bag_total
                            ]);
                    }
                    if ($ins_data && $ins_update && $ins_update_2) {

                        return response()->json(['response' => True, 'message' => 'Data Saved Successfully']);
                    } else {
                        return response()->json(['response' => False, 'message' => 'Failed To Save Data']);
                    }
                }
            } else {
                return response()->json(['response' => False, 'message' => 'Client Data Not Found']);
            }
        } else {
            return response()->json(['response' => False, 'message' => 'Client Char Id Not Found']);
        }
    }

    public function agree_disagree_collection_details(Request $request){
        $validator = Validator::make($request->all(), [
            'client_id' => 'required',
            'route_id' => 'required',
            'date' => 'required',
            'user_id' => 'required',
            'user_type' => 'required',
            'agree_status' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['response' => FALSE, 'message' => 'Validation Error!', 'Error' => $validator->errors()], 401);
        }
        $date = date('Y-m-d',strtotime($request->date));
        $route_id = $request->route_id;
        $client_id = $request->client_id;
        $user_id = $request->user_id;
        $user_type = $request->user_type;
        $agree_status = $request->agree_status; // 1 for agree and 2 for disaggree 

        $get_data_details = HcfCollectionTemp::where('client_id',$client_id)
                            ->where('route_id',$route_id)
                            ->where('date',$date)
                            ->first();
        if(!empty($get_data_details->client_id)){

            $update_data = HcfCollectionTemp::where('client_id',$client_id)
                            ->where('route_id',$route_id)
                            ->where('date',$date)
                            ->update(['agree_status'=>$agree_status]);

            if($update_data && $agree_status == 1){
                $hcfCollection = HcfCollection::select('id')->orderBy('id', 'desc')->first();
                $hcf_collection_id = $hcfCollection ? ($hcfCollection->id+1) : 1; 
                $last_id = $hcf_collection_id;
                $char_id = "WCLn" . ($last_id + 1000);

                $collection_arr[] = [

                    'char_id' => $char_id,
                    'route_id' => $get_data_details->route_id,
                    'route_name' => $get_data_details->route_name,
                    'plant' => $get_data_details->plant,
                    'date' => $get_data_details->date,
                    'client_id' => $get_data_details->client_id,
                    'client_name' => $get_data_details->client_name,
                    'client_address' => $get_data_details->client_address,
                    'total_collection' => $get_data_details->total_collection,
                    'total_bag' => $get_data_details->total_bag,
                    'this_client_total_quantity' => $get_data_details->this_client_total_quantity,
                    'this_client_total_bag' => $get_data_details->this_client_total_bag,
                    'is_active_client' => $get_data_details->is_active_client,
                    'bag0quantity' => $get_data_details->bag0quantity,
                    'bag1quantity' => $get_data_details->bag1quantity,
                    'bag2quantity' => $get_data_details->bag2quantity,
                    'bag3quantity' => $get_data_details->bag3quantity,

                    'bag0number' => $get_data_details->bag0number,
                    'bag1number' => $get_data_details->bag1number,
                    'bag2number' => $get_data_details->bag2number,
                    'bag3number' => $get_data_details->bag3number,

                    'status' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_by' => $user_id,
                    'updated_by' => $user_id,
                    'user_type'=>$user_type,
                    'temp_id'=>$get_data_details->id,
                ];
                $insert_data_collection = HcfCollection::insert($collection_arr);
            }
        }
            return response()->json(['response' => True, 'message' => 'Successfully Updated']);

    }
    
}
