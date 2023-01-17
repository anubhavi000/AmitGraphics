<?php

namespace App\Http\Controllers;

use Session;
use App\Models\Plant;
Use App\Models\ExportExcel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class PlantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $page=50;
        $state= $request->state;
        $name= $request->name;
        $status= $request->status;
   
        $company_id = Auth::user()->company_id;
        $plant = DB::table('plant')->where('status', 1)->where('company_id', $company_id);

        if(!empty($state)){
            $plant->where('state',$state);
        }
        if(!empty($name)){
            $plant->where('name','LIKE', '%'.$name.'%');
        }
        if(!empty($status)){
            $plant->where('enabled',1);
        }
        if($status ==0 && $status !=null){
            $plant->where('enabled',0);
        }
        $plant_details= $plant->paginate($page);
        if(!empty($request->export_to_pdf)){
        $pdf = PDF::loadView('Plant.plant_index_pdf', [
                'plant' => $plant_details
            ]);
            // $customPaper = array(0, 0, 1000, 1000);
            // $pdf->setPaper($customPaper);
            $pdf_name= "plant.pdf";
            return $pdf->download($pdf_name);
        }

            if(!empty($request->export_to_excel)){
                $file_name="Plant";
                $thead=[
                    "S. No.",
                    "ID",
                    "Name",
                    "Certificate no",
                    "Email",
                    "Telephone",
                    "Landline",
                    "Contact Person",
                    "Description"             
                ];
                ExportExcel::export_dynamically($thead ,$plant_details , $file_name);
            }
            else{
      
        $states  = DB::table('master_state')->get();
        return view('Plant.index', ['plant' => $plant_details , 'states'=>$states]);
    }
            }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company_id = Auth::user()->company_id;
        $certificate_status = DB::table('certificate_status')->where('status', 1)->where('company_id', $company_id)->get();
        $financial_year = DB::table('financial_year')->orderBy('id' , 'desc')->first();
      
        $state  = DB::table('master_state')->get();
        return view('Plant.create', [
            'state' => $state,
            'certificate_status' => $certificate_status , 
            'financial_year'=>$financial_year
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


        $last_id = DB::table('plant')->select('id')->orderBy('id', 'desc')->first();
        $char_id = "PLn" . ($last_id->id + 1000);
    $bill_series = $request->bill_prefix.'/'.$request->financial_year.'/';
   
    $prev_bill_series= DB::table('bill_series')->get();
    $is_exist= 0;
    
    foreach($prev_bill_series as $pv_bill){
             if($pv_bill->series==$bill_series){
                 $is_exist++;
                 $existing_series=$pv_bill;
             }
        
    }
        if($is_exist==0){
              DB::table('bill_series')->insert([
                  'series'=>$bill_series,
                  'voucher'=>0,
                  'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id

              ]);
        }
      
    $new_series= DB::table('bill_series')->orderBy('id' ,'desc')->first();
              

        $plant = DB::table('plant')->insert([
            'char_id' => $char_id,
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'landline' => $request->landline,
            
            'enabled' => $request->enabled,
            'contact_person' => $request->contact_person,
            'gstin' => $request->gstin,
            'description' => $request->description,
            'plant_certificate_number' => $request->plant_certificate_number,
            'plant_certificate_status' => $request->plant_certificate_status,
            'plant_valid_from' => !empty($request->plant_valid_from)?date('Y-m-d' , strtotime($request->plant_valid_from)):'',
            'plant_valid_till' => !empty($request->plant_valid_till)?date('Y-m-d' , strtotime($request->plant_valid_till)):'',
            'water_valid_from' => !empty($request->water_valid_from)?date('Y-m-d' , strtotime($request->water_valid_from)):'',
            'water_valid_till' => !empty($request->water_valid_till)?date('Y-m-d' , strtotime($request->water_valid_till)):'',
            'air_valid_from' => !empty($request->air_valid_from)?date('Y-m-d' , strtotime($request->air_valid_from)):'',
            'air_valid_till' => !empty($request->air_valid_till)?date('Y-m-d' , strtotime($request->air_valid_till)):'',
            'hazardous_valid_from' => !empty($request->hazardous_valid_from)?date('Y-m-d' , strtotime($request->hazardous_valid_from)):'',
            'hazardous_valid_till' => !empty($request->hazardous_valid_till)?date('Y-m-d' , strtotime($request->hazardous_valid_till)):'',
            'water_certificate_number' => $request->water_certificate_number,
            'water_certificate_status' => $request->water_certificate_status,
            'air_certificate_number' => $request->air_certificate_number,
            'air_certificate_status' => $request->air_certificate_status,
            'hazardous_certificate_number' => $request->hazardous_certificate_number,
            'hazardous_certificate_status' => $request->hazardous_certificate_status,
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'acc_number' => $request->acc_number,
            'ifsc_code' => $request->ifsc_code,
            'bihar_govt_bank_name' => $request->bihar_govt_bank_name,
            'bihar_govt_bank_branch' => $request->bihar_govt_bank_branch,
            'bihar_govt_acc_number' => $request->bihar_govt_acc_number,
            'bihar_govt_ifsc_code' => $request->bihar_govt_ifsc_code,
            'occupancy_bank_name' => $request->occupancy_bank_name,
            'occupancy_bank_branch' => $request->occupancy_bank_branch,
            'occupancy_acc_number' => $request->occupancy_acc_number,
            'occupancy_ifsc_code' => $request->occupancy_ifsc_code,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'state' => $request->state,
            'district' => $request->district,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'upi_payment_no' => $request->upi_payment_no,
            'payment_url' => $request->payment_url,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id , 
            'bill_series_id'=>!empty($existing_series)?$existing_series->id :$new_series->id

        ]);
        return redirect('Plant')->with('success','Inserted Successfully');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function setPlant(Plant $plant)
    {
        Session::put('ses_plant_id', $plant->id);
        Session::put('ses_plant_name', $plant->name);
        Session::put('ses_plants', $plant);
        return redirect()->back()->with('message', 'Plant set successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $certificate_status = DB::table('certificate_status')->where('status', 1)->where('company_id', $company_id)->get();
        $financial_year = DB::table('financial_year')->orderBy('id' , 'desc')->first();
        $state  = DB::table('master_state')->get();
        $decrypt_id = Crypt::deCrypt($id);
        $plant = DB::table('plant')->find($decrypt_id);
        return view('Plant.edit', ['plant' => $plant, 'certificate_status' => $certificate_status, 'state' => $state , 'financial_year'=>$financial_year] );
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

        $bill_series = $request->bill_prefix.'/'.$request->financial_year.'/';
   
        $prev_bill_series= DB::table('bill_series')->get();
        $is_exist= 0;
        
        foreach($prev_bill_series as $pv_bill){
                 if($pv_bill->series==$bill_series){
                     $is_exist++;
                     $existing_series=$pv_bill;
                 }
            
        }
            if($is_exist==0){
                  DB::table('bill_series')->insert([
                      'series'=>$bill_series,
                      'voucher'=>0,
                      'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id
    
                  ]);
            }
        $new_series= DB::table('bill_series')->orderBy('id' ,'desc')->first();
    






        DB::table('plant')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'landline' => $request->landline,
            'enabled' => $request->enabled,
            'contact_person' => $request->contact_person,
            'gstin' => $request->gstin,
            'description' => $request->description,
            'plant_certificate_number' => $request->plant_certificate_number,
            'plant_certificate_status' => $request->plant_certificate_status,
            'plant_valid_from' => !empty($request->plant_valid_from)?date('Y-m-d' , strtotime($request->plant_valid_from)):'',
            'plant_valid_till' => !empty($request->plant_valid_till)?date('Y-m-d' , strtotime($request->plant_valid_till)):'',
            'water_valid_from' => !empty($request->water_valid_from)?date('Y-m-d' , strtotime($request->water_valid_from)):'',
            'water_valid_till' => !empty($request->water_valid_till)?date('Y-m-d' , strtotime($request->water_valid_till)):'',
            'air_valid_from' => !empty($request->air_valid_from)?date('Y-m-d' , strtotime($request->air_valid_from)):'',
            'air_valid_till' => !empty($request->air_valid_till)?date('Y-m-d' , strtotime($request->air_valid_till)):'',
            'hazardous_valid_from' => !empty($request->hazardous_valid_from)?date('Y-m-d' , strtotime($request->hazardous_valid_from)):'',
            'hazardous_valid_till' => !empty($request->hazardous_valid_till)?date('Y-m-d' , strtotime($request->hazardous_valid_till)):'',
            'water_certificate_number' => $request->water_certificate_number,
            'water_certificate_status' => $request->water_certificate_status,
            'air_certificate_number' => $request->air_certificate_number,
            'air_certificate_status' => $request->air_certificate_status,
            'hazardous_certificate_number' => $request->hazardous_certificate_number,
            'hazardous_certificate_status' => $request->hazardous_certificate_status,
       
            'bank_name' => $request->bank_name,
            'bank_branch' => $request->bank_branch,
            'acc_number' => $request->acc_number,
            'ifsc_code' => $request->ifsc_code,
            'bihar_govt_bank_name' => $request->bihar_govt_bank_name,
            'bihar_govt_bank_branch' => $request->bihar_govt_bank_branch,
            'bihar_govt_acc_number' => $request->bihar_govt_acc_number,
            'bihar_govt_ifsc_code' => $request->bihar_govt_ifsc_code,
            'occupancy_bank_name' => $request->occupancy_bank_name,
            'occupancy_bank_branch' => $request->occupancy_bank_branch,
            'occupancy_acc_number' => $request->occupancy_acc_number,
            'occupancy_ifsc_code' => $request->occupancy_ifsc_code,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'state' => $request->state,
            'district' => $request->district,
            'city' => $request->city,
            'pincode' => $request->pincode,
            'upi_payment_no' => $request->upi_payment_no,
            'payment_url' => $request->payment_url,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
            'bill_series_id'=>!empty($existing_series)?$existing_series->id :$new_series->id
        ]);
        return redirect('Plant')->with('success','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $details= DB::table('plant')->find($id);
        $plant = DB::table('synergy_logs_plant')->insert([
            'id'=>$details->id,
            'char_id' => $details->char_id,
            'name' => $details->name,
            'email' => $details->email,
            'telephone' => $details->telephone,
            'landline' => $details->landline,
            
            'enabled' => $details->enabled,
            'contact_person' => $details->contact_person,
            'gstin' => $details->gstin,
            'description' => $details->description,
            'plant_certificate_number' => $details->plant_certificate_number,
            'plant_certificate_status' => $details->plant_certificate_status,
            'plant_valid_from' => $details->plant_valid_from,
            'plant_valid_till' => $details->plant_valid_till,
            'water_valid_from' => $details->water_valid_from,
            'water_valid_till' => $details->water_valid_till,
            'air_valid_from' => $details->air_valid_from,
            'air_valid_till' => $details->air_valid_till,
            'hazardous_valid_from' => $details->hazardous_valid_from,
            'hazardous_valid_till' => $details->hazardous_valid_till,
            'water_certificate_number' => $details->water_certificate_number,
            'water_certificate_status' => $details->water_certificate_status,
          
            'air_certificate_number' => $details->air_certificate_number,
            'air_certificate_status' => $details->air_certificate_status,
      
            'hazardous_certificate_number' => $details->hazardous_certificate_number,
            'hazardous_certificate_status' => $details->hazardous_certificate_status,
        
            'bank_name' => $details->bank_name,
            'bank_branch' => $details->bank_branch,
            'acc_number' => $details->acc_number,
            'ifsc_code' => $details->ifsc_code,
            'bihar_govt_bank_name' => $details->bihar_govt_bank_name,
            'bihar_govt_bank_branch' => $details->bihar_govt_bank_branch,
            'bihar_govt_acc_number' => $details->bihar_govt_acc_number,
            'bihar_govt_ifsc_code' => $details->bihar_govt_ifsc_code,
            'occupancy_bank_name' => $details->occupancy_bank_name,
            'occupancy_bank_branch' => $details->occupancy_bank_branch,
            'occupancy_acc_number' => $details->occupancy_acc_number,
            'occupancy_ifsc_code' => $details->occupancy_ifsc_code,
            'address1' => $details->address1,
            'address2' => $details->address2,
            'state' => $details->state,
            'district' => $details->district,
            'city' => $details->city,
            'pincode' => $details->pincode,
            'upi_payment_no' => $details->upi_payment_no,
            'payment_url' => $details->payment_url,
            'status' => $details->status,
            'created_at' => $details->created_at,
            'created_by' => $details->created_by,
            'updated_at' => $details->updated_at,
            'updated_by' => $details->updated_by , 
            'bill_series_id'=>$details->bill_series_id,

            
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
            'uid_status'=>'D'

        ]);

        DB::table('plant')->where('id', $id)->delete();
        return redirect('Plant')->with('success','Deleted Successfully');
    }

    public function getpdf($id)
    {
        // dd($id);
        $decrypt_id = Crypt::deCrypt($id);
        $plant = DB::table('plant')->find($decrypt_id);

        $state  = DB::table('master_state')->where('id', $plant->state)->first();
        $district  = DB::table('district')->where('id', $plant->district)->first();

        //  dd($state , $district);
        $plant_address = $plant->address1 . ', ' . $plant->address2 . ' ,' . $district->district . ' , ' . $state->states . ' , ' . $plant->pincode;
        //  dd($plant_address);
        // $acc_head= DB::table('accounting_head')->where('status' , 1)->get();

        return view('Plant.plantpdf', ['plant' => $plant, 'plant_address' => $plant_address]);
    }

    public function storeqrcode(Request $request, $id)
    {
        // dd($id);
        // $file= $_POST['qr_code'];
        // dd($file);
        // dd($request);


        if ($request->file('qr_code')) {
            $img = $request->file('qr_code');
            $img_name = $img->getClientOriginalName();

            // dd($img_name);

            $final_img_name = $img_name . date('Y-m-d H:i:s');
            $img->move('images/plant_qr_code/', $final_img_name);


            DB::table('plant')->where('id', $id)->update([
                'qr_file' => $final_img_name,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => Auth::user()->id

            ]);


            return redirect()->back()->with('img_name', $final_img_name);
        } else {
            return back();
        }
    }
    // public function excesswastereport(Request $request)
    // {
    //     // dd($request);
    //     $plants = DB::table('plant')->where('status', 1)->get();
    //     $plant = DB::table('plant')->find($request->plant);
    //     $data = DB::table('hcf_collection')
    //         ->join('client', 'client.id', '=', 'hcf_collection.client_id')
    //         ->join('district', 'client.district1', '=', 'district.id')
    //         ->select('hcf_collection.*', 'district.district as district')
    //         ->where('hcf_collection.plant', $request->plant)
    //         ->where('client.status', 1)
            
    //         ->get();
    //     // dd($data);
    //     //     $pdf_name= "excess_waste_export";
    //     //     $pdf = PDF::loadView('plant/excess_waste_export_report', ['data'=>$data , 'plant'=>$plant]);
    //     //   $name_of_pdf = $pdf_name.'.pdf';
    //     //       $pdf->save(public_path('pdf/' . $name_of_pdf));
    //     //       return $pdf->download( $name_of_pdf);
    //     return view('Plant/excess_waste_export_report', ['plant' => $plants, 'data' => $data, 'plant_info' => $plant]);
    // }
}
