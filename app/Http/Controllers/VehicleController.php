<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\DB;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ExportExcel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $vehicle_id = $request->vehicle_id;

        $vehicle_type = $request->vehicle_type;
        $driver_name = $request->driver_name;
        $driver_contact = $request->driver_no;
        $helper_name = $request->helper_name;
        $helper_contact = $request->helper_no;
        $status = $request->status;
        $plant = $request->plant;

        $company_id = Auth::user()->company_id;
        $vehicle = DB::table('vehicle_registration')//->where('company_id', Auth::user()->company_id)
        ->leftJoin('manufacturer','vehicle_registration.manufacturer' ,'=', 'manufacturer.id' )
        ->leftJoin('plant' , 'vehicle_registration.plant_Type' , '=' ,'plant.id')
        ->leftJoin('vehicle_type' , 'vehicle_registration.vehicle_Type' , '=' , 'vehicle_type.id')
        ->leftJoin('fuel_type' , 'vehicle_registration.fuel_Type' , '=' , 'fuel_type.id')
        ->leftJoin('employee_info' , 'employee_info.id', '=' , 'vehicle_registration.executive_id')
        ->select( 'vehicle_registration.*','manufacturer.manufacturer as manufacturername' ,'plant.name as plant_name', 'vehicle_type.vehicle_Type as type' , 'fuel_type.fuel_type as fuel_type'
          , 'vehicle_registration.vehicle_Number as number' , 'vehicle_registration.owner_Name as ownername' , 
          'vehicle_registration.driver_Name as drivername' , 'vehicle_registration.id as id',
          'vehicle_registration.vehicle_char_id as vehicle_char_id' , DB::raw("CONCAT_WS(' ',employee_info.char_id ,employee_info.f_name, employee_info.l_name) as emp_full_name"))
        // ->where('plant.status' , 1)
        // ->where('vehicle_registration.status',1)
        ->where('vehicle_registration.company_id', Auth::user()->company_id);
    
        if (!empty($vehicle_id)) {
            $vehicle->where('vehicle_registration.vehicle_char_id','LIKE', '%'.$vehicle_id.'%');
        }
        if (!empty($helper_name)) {
            $vehicle->where('vehicle_registration.helper_Name','LIKE', '%'.$helper_name.'%');
        }
        if (!empty($driver_name)) {
            $vehicle->where('vehicle_registration.driver_Name', 'LIKE', '%'.$driver_name.'%');
        }
        if (!empty($driver_contact)) {
            $vehicle->where('vehicle_registration.driver_Contact','LIKE', '%'.$driver_contact.'%');
        }
        if (!empty($vehicle->helper_contact)) {
            $vehicle->where('vehicle_registration.helper_Contact', 'LIKE', '%'.$helper_contact.'%');
        }
        if (!empty($vehicle_type)) {
            $vehicle->where('vehicle_registration.vehicle_Type', $vehicle_type);
        }
        if (!empty($plant)) {
            $vehicle->where('vehicle_registration.plant_Type', $plant);
        }
        if($status==1){
            $vehicle->where('vehicle_registration.onBoard', 1);

        }
        if($status==0 && $status !=null){
            $vehicle->where('vehicle_registration.onBoard', 0);

        }
         

        $vehicle_info = $vehicle->get();
       

         $vehicle_type = DB::table('vehicle_type')->where('company_id', $company_id)->get();
         $manufacturer = DB::table('manufacturer')->where('company_id', $company_id)->get();
         $plant = DB::table('plant')->where('status', 1)->where('company_id', $company_id)->get();

         
    if(!empty($request->export_to_pdf)){
        $pdf = PDF::loadView('Vehicle.vehicle_index_pdf', [
           'vehicle_info' => $vehicle_info,
        ]);
        // $customPaper = array(0, 0, 1000, 1000);
        // $pdf->setPaper($customPaper);
        $pdf_name= "vehicles.pdf";
        return $pdf->download($pdf_name);
    }

         if(!empty($request->export_to_excel)){
            $file_name="Vehicle";
            $thead=[
                "S. No.",
                "ID",
                "vehicle Number",
                "Fuel Type",
                "Manufacturer",
                "Owner Name",
                "Driver Name" ,
                "Plant",
                "Imei No" ,           
                "Status"            
            ];
            ExportExcel::export_dynamically($thead ,$vehicle_info , $file_name);
        }
        else{
        
        return view('Vehicle.index', [
             'vehicle_type' => $vehicle_type,
             'manufacturer' => $manufacturer,
            'vehicle_info' => $vehicle_info,
            'plant' => $plant

        ]);
    }
}

    
    // public function index()
    // {
        
    //     $company_id=Auth::user()->company_id;
    //     $vehicle_info = DB::table('vehicle_registration')->where('status' , 1)->where('company_id' , Auth::user()->company_id)->orderBy('id', 'desc')->get();
    //     $vehicle_type = DB::table('vehicle_type')->where('company_id' , $company_id)->get();
    //     $manufacturer = DB::table('manufacturer')->where('company_id' , $company_id)->get();
    //      $plant = DB::table('plant')->where('status', 1)->where('company_id' , $company_id)->get();
     
    //     return view('Vehicle.index',[
    //         'vehicle_type'=>$vehicle_type,
    //         'manufacturer'=>$manufacturer,
    //         'vehicle_info'=>$vehicle_info,
    //          'plant'=>$plant
          
    //     ]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
           $company_id=Auth::user()->company_id;
        $plant = DB::table('plant')->where('status', 1)->where('company_id' , $company_id)->get();
        $vehicle_type = DB::table('vehicle_type')->where('company_id' , $company_id)->get();
        $manufacturer = DB::table('manufacturer')->where('company_id' , $company_id)->get();
        $road_tax = DB::table('road_tax')->where('company_id' , $company_id)->get();
        $state = DB::table('master_state')->get();
        $fuel_type = DB::table('fuel_type')->where('company_id' , $company_id)->get();
         $model = DB::table('model')->where('company_id' , $company_id)->get();
         $executive= DB::table('employee_info')
                    ->leftJoin('designation' , 'designation.id' , '=' , 'employee_info.designation_id')
                    ->select(DB::raw("CONCAT_WS(' ',employee_info.char_id ,employee_info.f_name, employee_info.l_name) as full_name"),'employee_info.*')
                    ->where('employee_info.status' , 1)
                    ->where('designation.name' , 'Waste Collector')
                    ->where('employee_info.company_id' , $company_id)
                    ->get();
        return view('Vehicle.create',[
            'vehicle_type'=>$vehicle_type,
            'manufacturer'=>$manufacturer,
            'road_tax'=>$road_tax,
            'fuel_type'=>$fuel_type,
            'state'=>$state,
            'plant'=>$plant,
            'models'=>$model,
            'executives'=>$executive
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
        // dd($request);
        
        $last_id= DB::table('vehicle_registration')->select('id')->orderBy('id' , 'desc')->first();
        // dd($last_id);
        $vehicle_char_id="VHCLn".($last_id->id+1000);
        // dd($vehicle_char_id);
        
        $vehicle_info = DB::table('vehicle_registration')->insert([
            'vehicle_char_id'=>$vehicle_char_id,
            'vehicle_Number'=>$request->vehicle_Number,
            'vehicle_Type'=>$request->vehicle_Type,
                   'gps_device_imei_number'=>$request->gps_device_imei_number,
            'manufacturer'=>$request->manufacturer,
            'model'=>$request->model,
            'onBoard'=>!empty($request->onBoard)?$request->onBoard:0,
            'agreement_date'=>!empty($request->agreement_date)?date('Y-m-d',strtotime($request->agreement_date)):NULL,
            'valid_upto'=>!empty($request->valid_upto)?date('Y-m-d',strtotime($request->valid_upto)):NULL,
            'vehicle_policy_no'=>$request->vehicle_policy_no,
            'vehicle_policy_valid_upto'=>!empty($request->vehicle_policy_valid_upto)?date('Y-m-d',strtotime($request->vehicle_policy_valid_upto)):NULL,
            'vehicle_Pucc_no'=>$request->vehicle_Pucc_no,
            'vehicle_Pucc_end'=>!empty($request->vehicle_Pucc_valid_end)?date('Y-m-d',strtotime($request->vehicle_Pucc_valid_end)):NULL,
            'road_Tax_Date'=>!empty($request->road_Tax_Date)?date('Y-m-d',strtotime($request->road_Tax_Date)):NULL,
            'road_Tax_Type'=>$request->road_Tax_Type,
            'registration_Date'=>!empty($request->registration_Date)?date('Y-m-d',strtotime($request->registration_Date)):NULL,
            'owner_Name'=>$request->owner_Name,
            'owner_Father'=>$request->owner_Father,
            'owner_Contact'=>$request->owner_Contact,
            'owner_Pan_Number'=>$request->owner_Pan_Number,
            'service_Date'=>!empty($request->service_Date)?date('Y-m-d',strtotime($request->service_Date)):NULL,
            'fuel_Type'=>$request->fuel_Type,
            'rate_perkm'=>$request->rate_perkm,
            'signee_Name'=>$request->signee_Name,
            'signee_Designation'=>$request->signee_Designation,
            'route'=>$request->route,
            'fitness_Valid'=>!empty($request->fitness_Valid)?date('Y-m-d',strtotime($request->fitness_Valid)):NULL,
            'agreement_Certification_no'=>$request->Agreement_Certification_no,
            'e_stamp_Date'=>!empty($request->e_stamp_Date)?date('Y-m-d',strtotime($request->e_stamp_Date)):NULL,
            'vehicle_Comment'=>$request->vehicle_Comment,
            'plant_Type'=>$request->plant_Type,
            'address_1'=>$request->address_1,
            'address_2'=>$request->address_2,
            'state_id'=>$request->state,
            'district_id'=>$request->district_name,
            // 'city'=>$request->city,
            'pincode'=>$request->pincode,
            'driver_Name'=>$request->driver_Name,
            'helper_Name'=>$request->helper_Name,
            'driver_Father'=>$request->driver_Father,
            'driver_Address'=>$request->driver_Address,
            'driver_Contact'=>$request->driver_contact,
            'helper_Contact'=>$request->helper_Number,
            'created_at'=> date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'status'=>1,
            'renewal_start_date'=>$request->agreement_date,
             'renewal_end_date'=>$request->valid_upto,
             'stamp_paper_no'=>$request->Agreement_Certification_no,
             'fixed_petrol_charges' => !empty($request->fixed_petrol_charges)?$request->fixed_petrol_charges:0,
             'executive_id'=>$request->executive_id
        ]);
        return redirect('Vehicle')->with('success','Inserted Successfully');

    
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(request $request)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
           $company_id=Auth::user()->company_id;
        $encrypt_id = Crypt::deCrypt($id);
        $vehicle_info = DB::table('vehicle_registration')->where('id',$encrypt_id)->first();
        $plant = DB::table('plant')->where('status', 1)->where('company_id' , $company_id)->get();
        $vehicle_type = DB::table('vehicle_type')->where('company_id' , $company_id)->get();
        $manufacturer = DB::table('manufacturer')->where('company_id' , $company_id)->get();
        $road_tax = DB::table('road_tax')->where('company_id' , $company_id)->get();
        $fuel_type = DB::table('fuel_type')->get();
          $model = DB::table('model')->where('company_id' , $company_id)->get();
        $state = DB::table('master_state')->get();
        // DD($state->id);
        $all = DB::table('master_state')->get();
        // dd($all_State);
        $district = DB::table('district')->first();

        $executive= DB::table('employee_info')
        ->leftJoin('designation' , 'designation.id' , '=' , 'employee_info.designation_id')
        ->select(DB::raw("CONCAT_WS(' ',employee_info.char_id ,employee_info.f_name, employee_info.l_name) as full_name"),'employee_info.*')
        ->where('employee_info.status' , 1)
        ->where('designation.name' , 'Waste Collector')
        ->where('employee_info.company_id' , $company_id)
        ->get();
        return view(
            'Vehicle.edit',
            [
                'vehicle_info'=>$vehicle_info,
                'vehicle_type'=>$vehicle_type,
                'fuel_type'=>$fuel_type,
                'manufacturer'=>$manufacturer,
                'state'=>$state,
                'all'=>$all,
                'district'=>$district,
                'road_tax'=>$road_tax,
                'plant'=>$plant,
                'models'=>$model,
                'executives'=>$executive
            ]
        );
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
        // dd($request);

        $vehicle_info= DB::table('vehicle_registration')->where('id',$id)->update([
            'vehicle_Number'=>$request->vehicle_Number,
            'vehicle_Type'=>$request->vehicle_Type,
          
            'manufacturer'=>$request->manufacturer,
            'model'=>$request->model,
            'onBoard'=>!empty($request->onBoard)?$request->onBoard:0,
            'agreement_date'=>(!empty($request->agreement_date)?date('Y-m-d',strtotime($request->agreement_date)):NULL),
            'valid_upto'=>(!empty($request->valid_upto)?date('Y-m-d',strtotime($request->valid_upto)):NULL),
            'vehicle_policy_no'=>$request->vehicle_policy_no,
            'vehicle_policy_valid_upto'=>(!empty($request->vehicle_policy_valid_upto)?date('Y-m-d',strtotime($request->vehicle_policy_valid_upto)):NULL),
            'vehicle_Pucc_no'=>$request->vehicle_Pucc_no,
            'vehicle_Pucc_end'=>(!empty($request->vehicle_Pucc_valid_end)?date('Y-m-d',strtotime($request->vehicle_Pucc_valid_end)):NULL),
            'road_Tax_Date'=>(!empty($request->road_Tax_Date)?date('Y-m-d',strtotime($request->road_Tax_Date)):NULL),
            'road_Tax_Type'=>$request->road_Tax_Type,
            'registration_Date'=>(!empty($request->registration_Date)?date('Y-m-d',strtotime($request->registration_Date)):NULL),
            'owner_Name'=>$request->owner_Name,
            'owner_Father'=>$request->owner_Father,
            'owner_Contact'=>$request->owner_Contact,
            'owner_Pan_Number'=>$request->owner_Pan_Number,
            'service_Date'=>(!empty($request->service_Date)?date('Y-m-d',strtotime($request->service_Date)):NULL),
            'fuel_Type'=>$request->fuel_Type,
            'rate_perkm'=>$request->rate_perkm,
            'signee_Name'=>$request->signee_Name,
            'signee_Designation'=>$request->signee_Designation,
            'route'=>$request->route,
            'fitness_Valid'=>(!empty($request->fitness_Valid)?date('Y-m-d',strtotime($request->fitness_Valid)):NULL),
            'agreement_Certification_no'=>$request->Agreement_Certification_no,
            'e_stamp_Date'=>(!empty($request->e_stamp_Date)?date('Y-m-d',strtotime($request->e_stamp_Date)):NULL),
            'vehicle_Comment'=>$request->vehicle_Comment,
            'plant_Type'=>$request->plant_Type,
            'address_1'=>$request->address_1,
            'address_2'=>$request->address_2,
            'state_id'=>$request->state,
            'district_id'=>$request->district_name,
            'gps_device_imei_number'=>$request->gps_device_imei_number,
            // 'city'=>$request->city,
            'pincode'=>$request->pincode,
            'driver_Name'=>$request->driver_Name,
            'helper_Name'=>$request->helper_Name,
            'driver_Father'=>$request->driver_Father,
            'driver_Address'=>$request->driver_Address,
            'driver_Contact'=>$request->driver_contact,
            'helper_Contact'=>$request->helper_Number,
            'fixed_petrol_charges' => !empty($request->fixed_petrol_charges)?$request->fixed_petrol_charges:0,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'executive_id'=>$request->executive_id
           
            
        ]);
    

        return redirect('Vehicle')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $details = DB::table('vehicle_registration')->find($id);
                Db::table('synergy_logs_vehicle_registration')->insert([
                    'id'=>$details->id,
                'vehicle_char_id'=>$details->vehicle_char_id,
                'vehicle_Number'=>$details->vehicle_Number,
                'vehicle_Type'=>$details->vehicle_Type,
                       'gps_device_imei_number'=>$details->gps_device_imei_number,
                'manufacturer'=>$details->manufacturer,
                'model'=>$details->model,
                'onBoard'=>$details->onBoard,
                'agreement_date'=>$details->agreement_date,
                'valid_upto'=>$details->agreement_date,
                'vehicle_policy_no'=>$details->vehicle_policy_no,
                'vehicle_policy_valid_upto'=>$details->vehicle_policy_valid_upto,
                'vehicle_Pucc_no'=>$details->vehicle_Pucc_no,
                'vehicle_Pucc_end'=>$details->vehicle_Pucc_end,
                'road_Tax_Date'=>$details->road_Tax_Date,
                'road_Tax_Type'=>$details->road_Tax_Type,
                'registration_Date'=>$details->registration_Date,
                'owner_Name'=>$details->owner_Name,
                'owner_Father'=>$details->owner_Father,
                'owner_Contact'=>$details->owner_Contact,
                'owner_Pan_Number'=>$details->owner_Pan_Number,
                'service_Date'=>$details->service_Date,
                'fuel_Type'=>$details->fuel_Type,
                'rate_perkm'=>$details->rate_perkm,
                'signee_Name'=>$details->signee_Name,
                'signee_Designation'=>$details->signee_Designation,
                'route'=>$details->route,
                'fitness_Valid'=>$details->fitness_Valid,
                'agreement_Certification_no'=>$details->agreement_Certification_no,
                'e_stamp_Date'=>$details->e_stamp_Date,
                'vehicle_Comment'=>$details->vehicle_Comment,
                'plant_Type'=>$details->plant_Type,
                'address_1'=>$details->address_1,
                'address_2'=>$details->address_2,
                'state_id'=>$details->state_id,
                'district_id'=>$details->district_id,
                // 'city'=>$details->city,
                'pincode'=>$details->pincode,
                'driver_Name'=>$details->driver_Name,
                'helper_Name'=>$details->helper_Name,
                'driver_Father'=>$details->driver_Father,
                'driver_Address'=>$details->driver_Address,
                'driver_Contact'=>$details->driver_Contact,
                'helper_Contact'=>$details->helper_Contact,
                'created_at'=> $details->created_at,
                'created_by' => $details->created_by,
                'updated_at' => $details->updated_at,
                'updated_by' => $details->updated_by,
                'status'=>$details->status,
                'renewal_start_date'=>$details->agreement_date,
                 'renewal_end_date'=>$details->valid_upto,
                 'stamp_paper_no'=>$details->stamp_paper_no,
                 'fixed_petrol_charges' =>$details->fixed_petrol_charges,
    
                 
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => Auth::user()->id,
                'uid_status'=>'D'
            ]);
    
    
    
        DB::table('vehicle_registration')->where('id' , $id)->delete();
        return redirect('Vehicle')->with('success','Deleted Successfully');
    }
    
     public function getpdf($id){
       
        $decrypt_id= Crypt::deCrypt($id);
        $vehicle= DB::table('vehicle_registration')->find($decrypt_id);
        // dd($vehicle);
  $plant = DB::table('plant')->where('id', $vehicle->plant_Type)->first();
    
    
        $model = DB::table('model')->where('id', $vehicle->model)->first();
    //  dd($model);
               $manufacturer = DB::table('manufacturer')->where('id', $vehicle->manufacturer)->first();
    // dd($manufacturer);
                      $vehicle_type = DB::table('vehicle_type')->where('id', $vehicle->vehicle_Type)->first();
                // dd($vehicle_type);
        return view('Vehicle.vehiclepdf' , ['vehicle'=>$vehicle , 'model'=>$model, 'manufacturer'=>$manufacturer, 'vehicle_type'=>$vehicle_type , 'plant'=>$plant]);

    }
    
    
    public function downloadpdf($pagename , $id,Request $request){
        // dd($request->custom_date);
        $decrypt_id= Crypt::deCrypt($id);
        $pdf_name = rand().'.pdf';
        $vehicle= DB::table('vehicle_registration')->find($decrypt_id);
        // $current_agreement_start_date= DB::table('vehicle_renewal')->where('vehicle_registration_primary_id' , $decrypt_id)->select('current_agreement_start_date')->orderBy('vehicle_registration_primary_id' , 'desc')->first();
        //   $current_agreement_end_date=DB::table('vehicle_renewal')->where('vehicle_registration_primary_id' , $decrypt_id)->select('current_agreement_end_date')->orderBy('vehicle_registration_primary_id' , 'desc')->first();
        // dd($current_agreement_start_date, $current_agreement_end_date);
        $plant_id = $vehicle->plant_Type;
        $plant = DB::table('plant')->where('id', $plant_id)->first();
        $fuel_type = DB::table('fuel_type')->where('id',$vehicle->fuel_Type)->first();
        // dd($fuel_type);
        $model = DB::table('model')->where('id', $vehicle->model)->first();
        
 
        $state = DB::table('master_state')->where('id', $vehicle->state_id)->first();
        $district = DB::table('district')->where('id', $vehicle->district_id)->first();        
        // $interval = ->diff();
        // $date_flag = Date('Y-m-d', strtotime($vehicle->valid_upto) + 86400); //adding 1 to a date to include both dates in the range
        $date_flag = Date('Y-m-d', strtotime($vehicle->valid_upto) ); //adding 1 to a date to include both dates in the range
        // dd($model, $vehicle->model);
        
        $diff = abs(strtotime($date_flag) - strtotime($vehicle->agreement_date));
        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        // dd($fuel_type, $vehicle->agreement_date, $vehicle->valid_upto, $date_flag, $diff, $years, $months, $days, $vehicle, $plant);
        if($vehicle->agreement_date=='2022-04-01' && $vehicle->valid_upto=='2023-03-31') {
            $years = 1;
            $months = 0;
            $days = 0;
        }
        else if($vehicle->agreement_date=='2023-04-01' && $vehicle->valid_upto=='2024-03-31') {
            $years = 1;
            $months = 0;
            $days = 0;
        }
        else if($vehicle->agreement_date=='2024-04-01' && $vehicle->valid_upto=='2025-03-31') {
            $years = 1;
            $months = 0;
            $days = 0;
        }
        else if($vehicle->agreement_date=='2025-04-01' && $vehicle->valid_upto=='2026-03-31') {
            $years = 1;
            $months = 0;
            $days = 0;
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
        
        
             $state_name= DB::table('master_state')->where('id' , $vehicle->state_id)->first();
                 $district_name= DB::table('district')->where('id' , $vehicle->district_id)->first();
            $per_km_amount_in_words = self::getIndianCurrency($vehicle->rate_perkm);
            // dd($per_km_amount_in_words);    
        
        if($pagename=="agreement"){
            $pdf= PDF::loadView('Vehicle.agreement', [
                  'vehicle'=>$vehicle,
                  'plant' => $plant,
                  'years' => $years,
                  'months' => $months,
                  'days' => $days,
                  'number_to_text' => $number_to_text,
                  'per_km_amount_in_words' => $per_km_amount_in_words,
                  'fuel_type' => $fuel_type,
                  'model' => $model,
                  'state' => $state,
                  'district' => $district,
                    'state_name'=>$state_name,
               'district_name'=>$district_name,
               'custom_date'=>$request->custom_date,
            ]);
        }
        else if($pagename=="annexure_a"){
            $pdf= PDF::loadView('Vehicle.annexure_a', [
               'vehicle'=>$vehicle,
                  'plant' => $plant,
                  'years' => $years,
                  'months' => $months,
                  'days' => $days,
                  'number_to_text' => $number_to_text,
                  'per_km_amount_in_words' => $per_km_amount_in_words,
                  'fuel_type' => $fuel_type,
                  'model' => $model,
                  'state' => $state,
                  'district' => $district,
                    'state_name'=>$state_name,
               'district_name'=>$district_name,
               'custom_date'=>$request->custom_date,
            ]);
        }
        else if($pagename=="annexure_b"){
        
            $pdf= PDF::loadView('Vehicle.annexure_b', [
                'vehicle'=>$vehicle,
                  'plant' => $plant,
                  'years' => $years,
                  'months' => $months,
                  'days' => $days,
                  'number_to_text' => $number_to_text,
                  'per_km_amount_in_words' => $per_km_amount_in_words,
                  'fuel_type' => $fuel_type,
                  'model' => $model,
                  'state' => $state,
                  'district' => $district,
                    'state_name'=>$state_name,
               'district_name'=>$district_name,
               'custom_date'=>$request->custom_date,
            ]);
        }
        else if($pagename=="synergypdf"){
        
            $pdf= PDF::loadView('Vehicle.synergypdf', [
                'vehicle'=>$vehicle,
                  'plant' => $plant,
                  'years' => $years,
                  'months' => $months,
                  'days' => $days,
                  'number_to_text' => $number_to_text,
                  'per_km_amount_in_words' => $per_km_amount_in_words,
                  'fuel_type' => $fuel_type,
                  'model' => $model,
                  'state' => $state,
                  'district' => $district,
                    'state_name'=>$state_name,
               'district_name'=>$district_name,
               'custom_date'=>$request->custom_date,
            ]);
        }
         else if($pagename=="synergypdf2"){
        
            $pdf= PDF::loadView('Vehicle.synergypdf2', [
                'vehicle'=>$vehicle,
                  'plant' => $plant,
                  'years' => $years,
                  'months' => $months,
                  'days' => $days,
                  'number_to_text' => $number_to_text,
                  'per_km_amount_in_words' => $per_km_amount_in_words,
                  'fuel_type' => $fuel_type,
                  'model' => $model,
                  'state' => $state,
                  'district' => $district,
                    'state_name'=>$state_name,
               'district_name'=>$district_name,
               'custom_date'=>$request->custom_date,
            ]);
        }
        
          else if($pagename=="renewalpdf"){
            //   dd($decrypt_id);
          $vehicle_renewal = DB::table('vehicle_renewal')->where('vehicle_registration_primary_id',$decrypt_id)->orderBy('after_renew_end_date','desc')->get();
             $state_name= DB::table('master_state')->where('id' , $vehicle->state_id)->first();
                 $district_name= DB::table('district')->where('id' , $vehicle->district_id)->first();
            // dd($vehicle_renewal);
            $model= DB::table('model')->select('model')->where('id',$vehicle->model)->first();
            // dd($model->model);
            $pdf= PDF::loadView('Vehicle.renewalpdf', [
                'vehicle'=>$vehicle,
                'vehicle_renewal'=>$vehicle_renewal,
                'model'=>$model,
                'state'=>$state_name,
                'district'=>$district_name,
                'plant' => $plant,
                'years' => $years,
                'months' => $months,
                'days' => $days,
                'number_to_text' => $number_to_text,
                'per_km_amount_in_words' => $per_km_amount_in_words,
                'fuel_type' => $fuel_type,
                'state_name'=>$state_name,
                'district_name'=>$district_name,
                'custom_date'=>$request->custom_date,
            ]);
            
        }
        
        else if($pagename=="renewal"){
            // dd($model);
            return view('Vehicle.renewal' , ['vehicle'=>$vehicle,'model'=> $model]);
        }
        

        $pdf->save(public_path('pdf/'.$pdf_name));
            return $pdf->download(public_path('pdf/'.$pdf_name));
    
        
    }
    
    
   public function renew($id , Request $request){
      // dd($request, $request->stamp_paper_no_logs, $request->stamp_paper_no, !empty($request->stamp_paper_no_logs));
   
    $decrypt_id= Crypt::deCrypt($id);
   
    if($request->stamp_paper_no != null) {
        $validator = Validator::make($request->all(), [
            'stamp_paper_no' => 'required',
            'stamp_paper_date' => 'required',
            'renewal_date' => 'required',
            'renewal_start_date' => 'required',
            'renewal_end_date' => 'required',
        ]);
        if($validator->fails()) {
            // dd($validator);
            return redirect('Vehicle')
                        ->withErrors($validator)
                        ->withInput();
        }
        DB::table('vehicle_registration')->where('id' , $decrypt_id)->update([
                // 'address_1'=>$request->address,
                'stamp_paper_no'=>$request->stamp_paper_no,
                'renewal_date'=>$request->renewal_date,
                'renewal_start_date'=>$request->renewal_start_date,
                'renewal_end_date'=>$request->renewal_end_date,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
            ]);
            
                DB::table('vehicle_renewal')->insert([
                'vehicle_registration_primary_id'=> $decrypt_id,  
                'vehicle_number'=>$request->vehicle_no,
                'vehicle_model'=>$request->vehicle_model,
                'current_agreement_start_date' =>$request->current_agreement_date,
                'current_agreement_end_date' =>$request->current_agreement_end_date,
                'stamp_paper_no' => !empty($request->stamp_paper_no)?$request->stamp_paper_no:null,
                'stamp_paper_date' => !empty($request->stamp_paper_date)?$request->stamp_paper_date:null,
                'renewal_date' => !empty($request->renewal_date)?$request->renewal_date:null,
                'after_renew_start_date' => !empty($request->renewal_start_date)?$request->renewal_start_date:null,
                'after_renew_end_date' => !empty($request->renewal_end_date)?$request->renewal_end_date:null,
                'created_at'=> date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id,
                'status'=>1
            ]);
    }


        $stamp_paper_no_logs = $request->stamp_paper_no_logs;
        $stamp_paper_date_logs = $request->stamp_paper_date_logs;
        $renewal_date_logs = $request->renewal_date_logs;
        $renewal_start_date_logs = $request->renewal_start_date_logs;
        $renewal_end_date_logs = $request->renewal_end_date_logs;
        $row_count = count($stamp_paper_no_logs);
        for($i=0; $i<$row_count; $i++) {
            if($request->stamp_paper_no_logs[$i] != NULL) {
                // dd($request);
                DB::table('vehicle_renewal')->insert([
                    'vehicle_registration_primary_id'=> $decrypt_id,  
                    'vehicle_number'=>$request->vehicle_no,
                    'vehicle_model'=>$request->vehicle_model,
                    'current_agreement_start_date' =>$request->current_agreement_date,
                    'current_agreement_end_date' =>$request->current_agreement_end_date,
                    'stamp_paper_no' => !empty($stamp_paper_no_logs[$i])?$stamp_paper_no_logs[$i]:null,
                    'stamp_paper_date' => !empty($stamp_paper_date_logs[$i])?$stamp_paper_date_logs[$i]:null,   
                    'renewal_date' => !empty($renewal_date_logs[$i])?$renewal_date_logs[$i]:null,
                    'after_renew_start_date' => !empty($renewal_start_date_logs[$i])?$renewal_start_date_logs[$i]:null,
                    'after_renew_end_date' => !empty($renewal_end_date_logs[$i])?$renewal_end_date_logs[$i]:null,
                    'created_at'=> date('Y-m-d H:i:s'),
                    'created_by' => Auth::user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Auth::user()->id,
                    'status'=>1
                ]);                
            }

        }
        

        // return back()->with('success' , "Agreement Renewal Successfull");
        $vehicle_id= $request->vehicle_id;
        return redirect("vehiclepdf/{$vehicle_id}");
   }
    
    
    function getIndianCurrency(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        // dd($decimal);
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Forteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        // $paise = ($decimal > 0) ? "and " . ($words[$decimal/10] . " " . $words[$decimal % 10]) . ' Paise ' : '';
        $paise = self::getIndianCurrencyPaise($decimal);
        return ($Rupees ? 'Rupees '.$Rupees : '') . (!empty($paise)?'and '.$paise.' Paise ':'');
    }


    function getIndianCurrencyPaise(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        // dd($decimal);
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'One', 2 => 'Two',
            3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
            7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
            10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
            13 => 'Thirteen', 14 => 'Forteen', 15 => 'Fifteen',
            16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
            40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
            70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
        $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
        while( $i < $digits_length ) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
            } else $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        // dd($Rupees);
        return $Rupees;

    }

  
}
