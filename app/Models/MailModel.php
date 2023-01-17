<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\CalculateBillValue;
use App\Models\AllBill;
// use App\Models\MailModel;
use App\Models\AccountingEntry;
use App\Models\AccountingEntryItem;
use App\Models\Plant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use Illuminate\Support\Facades\Mail;
use App\Helpers\ConstantHelper;
use PDF;
use Exception;

class MailModel extends Model
{
	public static function bill_send_mail($request,$flag = 0){
        set_time_limit(100000);
        $plant_id = $request->plant_id;
        $route_id = $request->route_id;
        $district = $request->district;
        $bill_no = $request->bill_no;
        $billing_month = $request->billing_month;
        $from_bill_no = $request->from_bill_no;
        $to_bill_no = $request->to_bill_no;
        $billing_type = $request->billing_type;
        $company_id = Auth::user()->company_id;
        $get_company_details = DB::table('company')->where('id',$company_id)->first();
        if(empty($get_company_details->id)){
            $get_company_details = DB::table('company')->where('id',18)->first();  // manacle
        }
        if(!empty($plant_id) || !empty($route_id) || !empty($district) || !empty($bill_no)){

            $data_bill_details_data = AllBill::join('client','client.id','=','all_bills.client_id')
                                    ->join('district','district.id','=','client.district1')
                                    ->select('client.*','all_bills.bill_pdf_name as bill_pdf_name','all_bills.id as bill_id')
                                    ->where('month',$billing_month);
                                    
                                    if(!empty($plant_id)){
                                        $data_bill_details_data->where('plant_id',$plant_id)->where('is_bulk_bill',1);
                                    }
                                    if(!empty($route_id)){
                                        $data_bill_details_data->where('route_id',$route_id)->where('is_bulk_bill',1);
                                    }
                                    if(!empty($district)){
                                        $data_bill_details_data->where('district.id',$district)->where('is_bulk_bill',1);
                                    }
                                    if(!empty($bill_no)){
                                        $data_bill_details_data->where('all_bills.bill_no',$bill_no);
                                    }
                                    if(!empty($billing_type)){
                                        if($billing_type == 'gvt'){
                                            $data_bill_details_data->where('is_govt_client',1);
                                        }elseif($billing_type == 'pvt'){
                                            $data_bill_details_data->where('is_govt_client',0);
                                        }
                                    }
                                    if($flag == 1){
                                        // dd('1');
                                        $data_bill_details_data->where('all_bills.mail_send_status',0);
                                    }
                                    if (!empty($from_bill_no) && !empty($to_bill_no)) {
                                        $data_bill_details_data->whereRaw("bill_no>='$from_bill_no' AND bill_no<='$to_bill_no'");
                                    }
                $data_bill_details = $data_bill_details_data->orderBy('bill_no','ASC')->get();
                // dd($data_bill_details,$billing_month,$plant_id);
                $curr_date = date('Y-m-d');
                $count_bill_details = AllBill::where('mail_send_status','!=',0)->whereRaw("DATE_FORMAT(mail_send_date_time,'%Y-%m-%d')='$curr_date'")->count();
                if($count_bill_details == 1800){
                    $message = 'Gmail one day Limit is crossed,Please try next day';
                    return redirect('Consolidates/create')->with('message' , $message);
                }
                
                                // dd($data_bill_details,$billing_month);
                                if(empty($data_bill_details)){
                                    $message = 'No Data Found ';
                                    return redirect('Consolidates/create')->with('message' , $message);
                                }
                                    // $message = [];
                    foreach ($data_bill_details as $key => $value) {
                    // code...
                    // $mail_id = "kamal_logicedge@yahoo.com";
                    $mail_id = $value->email_id;
                    if(empty($mail_id)){
                        $mail_id = $value->person_email;
                    }
                    if(!empty($mail_id)){

                        

                        $pdf_path = public_path().'/pdf/'.$value->bill_pdf_name;
                        // dd($pdf_path);
                        $subject = "Bill Details";
                        // $message = " mSELL, developed and powered by Manacle Technologies Pvt. Ltd";
                        $body_part = '';

                        if($flag == 1){
                            $data_update = AllBill::where('id',$value->bill_id)->update([
                                            'mail_send_status'=>1,
                                            'mail_send_date_time'=>date('Y-m-d H:i:s'),
                                        ]);
                        }else{
                            $data_update = AllBill::where('id',$value->bill_id)->update([
                                            'mail_send_status'=>2,
                                            'mail_send_date_time'=>date('Y-m-d H:i:s'),
                                        ]);
                        }
                        // DB::commit();
                        // $mail_id = 'karan@manacleindia.com';s
                        if(!empty($mail_id)){

                            $mail_checker_1 = substr_count($mail_id,".");
                            $mail_checker_2 = substr_count($mail_id,"@");
                            if($mail_checker_2 > 1 || $mail_checker_2 == 0){

                            }else{
                                if($mail_checker_1 > 1){

                                }else{

                                    $data_get_plant = Plant::where('id',$value->plant)->first();
                                    if(!empty($data_get_plant->conf_email_id)){
                                        config([
                                           'mail.mailers.smtp.username' => $data_get_plant->conf_email_id,
                                           'mail.mailers.smtp.password' => $data_get_plant->conf_email_pass,
                                           'mail.from.address' => $data_get_plant->conf_email_id
                                           ]
                                        );
                                    }
                                    $mail = Mail::send('bulk_mail', array(
                                                'body_part' => $get_company_details,
                                                'month' => $billing_month
                                                                        
                                            ) , function($message1) use($mail_id,$subject,$pdf_path)
                                            {
                                                    
                                                $message1->from('manacle.php1@gmail.com','Synergy');

                                                $message1->to($mail_id)->subject($subject)->attach($pdf_path);

                                            });
                                }
                            }
                        }

                        
                        // $update_mail_status = AllBill::where('id',$value->id)->update([
                        //                         ''
                        //                     ]);
                    }
                }
            }else{
                $message = 'Please select Plant or Route or District';
                return redirect('Consolidates/create')->with('message' , $message);
            }
        return true;
    }
}