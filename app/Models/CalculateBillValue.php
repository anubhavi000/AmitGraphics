<?php

namespace App\Models;

use Exception;
use App\Models\HcfCollection;
use App\Models\Client;
use App\Models\AccountingLedger;
use App\Models\PlantConfiguration;
use App\Models\Plant;
use App\Helpers\ConstantHelper;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use Illuminate\Support\Facades\Request;
class CalculateBillValue extends Model
{
	public static function calculateValue($client,$start_date,$end_date,$billing_month,$flag = 0,$billing_flag = 1){
		
		// validation
		if(empty($client->id)){
			return 0;
		}else{
			if($flag != 1){
		// dd($flag);
				if($client->is_govt_client == 1){

					$check_bill_conf = DB::table('bill_configuration')
		        				->where('plant_id',$client->plant)
		    					->first();
					if(!empty($check_bill_conf->plant_id)){
						Client::where('id',$client->id)
						->update([
							'per_bed_amount'=>$check_bill_conf->extra_bed_charges,
							'billing_type'=>2,
							'per_bed_maximum_weight'=>$check_bill_conf->excess_weight_limit,
							'per_bed_fixed_beds'=>$check_bill_conf->fixed_beds,
							'per_bed_fixed_amount'=>$check_bill_conf->fixed_bed_amount,
							'per_bed_excess_bill'=>$check_bill_conf->excess_rate,
						]);
					}
				}
			}
			$client = Client::find($client->id);
			if(empty($client->id)){
				return 0;
			}
		}
		$find_minus_billing_days = $client->bill_calculation_date;
		$minus_step1 = date('m',strtotime($find_minus_billing_days));
		$check_month_year = date('Y-m',strtotime($find_minus_billing_days));

		// calculate days ******************
		$startDate = strtotime($start_date);
        $get_month = date('m',strtotime($billing_month));
        $minus_days_count = 0;
        $rangArrayDetails = [];
        if($billing_flag != 2){
	        if($get_month == $minus_step1){
	            $get_fist_date = $check_month_year.'-01';
	        	$get_last_date = $find_minus_billing_days;

				$startDateDetails = strtotime($get_fist_date);
	        	$endDateDetails = strtotime($get_last_date);
	        	// dd($get_fist_date,$get_last_date);
		        for ($currentDate = $startDateDetails; $currentDate <= $endDateDetails; 

		                                        $currentDate += (86400)) {

		            $date = date('Y-m-d', $currentDate);
		            $rangArrayDetails[] = $date;
		        }
		        $minus_days_count = COUNT($rangArrayDetails);
		        if($minus_days_count > 0){
		        	$minus_days_count = $minus_days_count-1;
		        }

	        }
        }
        // dd($minus_days_count);
        $get_year = date('Y',strtotime($start_date));
        $endDate = strtotime($end_date);
        $rangArray = [];
        for ($currentDate = $startDate; $currentDate <= $endDate; 

                                        $currentDate += (86400)) {

            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }
        $billing_days = COUNT($rangArray)-$minus_days_count;
        // dd($billing_days);

        $month_day_count =  cal_days_in_month(CAL_GREGORIAN,$get_month,$get_year);
        
        // calculate collection details ******************
        $total_collection = 0; 
        $total_collection_details = HcfCollection::where('client_id', $client->id)
        					->where('status',1)
                            ->whereRaw("DATE_FORMAT(date,'%Y-%m-%d')>='$start_date' AND DATE_FORMAT(date,'%Y-%m-%d')<='$end_date'")
                            ->groupBy('client_id','date')
                            ->get();

        $wastecontainer = DB::table('waste_container')->where('status', 1)->get();

        $out_total = [];
        foreach ($total_collection_details as $collection_key => $collection_value) {
        	// code...
	        $count_col = count($wastecontainer);
	        for ($i=0; $i < $count_col ; $i++) { 
	        	// code...
	        	// dd($value);
	        	$variable = "bag" . $i . "quantity";

	        	$out_total[] = !empty($collection_value->$variable)?$collection_value->$variable:'0';
	        }
        }
        
        // dd($out_total);
        $total_collection = array_sum($out_total);


		// first check for billing Type ******************
		if($client->billing_type == 1){   // for fixed amount only  ******************
			// dd($client->minimum_amount);
			$minimum_amount = !empty($client->minimum_amount)?($client->minimum_amount/$month_day_count)*$billing_days:0;
			$maximum_weight = !empty($client->maximum_weight)?($client->maximum_weight/$month_day_count)*$billing_days:0;
			$fixed_amount_total_beds = !empty($client->fixed_amount_total_beds)?$client->fixed_amount_total_beds:0;
			// dd($minimum_amount,$month_day_count,$billing_days);
			$per_bed_total_beds = !empty($client->per_bed_total_beds)?$client->per_bed_total_beds:0;
			$return_total_amount = $minimum_amount;

			$weight_limit = $maximum_weight;
			$rate = 0;
			$excess_rate = 0;
			$total_bed = $per_bed_total_beds;
			// dd($return_total_amount);
			if(!empty($total_collection)){

				if($client->is_excess_billed == '1' || $client->is_excess_billed == 1){

					$excess_rate = $client->excess_rate;
					$find_excess_weight = $total_collection-$maximum_weight;
					// dd($find_excess_weight,$maximum_weight,$excess_rate);
					if($find_excess_weight > 0){
						$return_total_amount = (($return_total_amount)+($excess_rate*$find_excess_weight));
					}
			// dd($minimum_amount,$maximum_weight,$total_collection,$find_excess_weight,$return_total_amount);
					$final_array = [
						'final_amount' =>$return_total_amount,
						'weight_limit' =>round($weight_limit,2),
						'bill_fixed_amount' =>round($minimum_amount,2),
						'rate' =>$rate,
						'excess_rate' =>$excess_rate,
						'total_bed' =>$total_bed,
						'total_collection'=>$total_collection
					];
					return $final_array;

				}else{
					$final_array = [
						'final_amount' =>$return_total_amount,
						'weight_limit' =>round($weight_limit,2),
						'bill_fixed_amount' =>round($minimum_amount,2),
						'rate' =>$rate,
						'excess_rate' =>$excess_rate,
						'total_bed' =>$total_bed,
						'total_collection'=>$total_collection
					];
					return $final_array;
				}
			}else{
				$final_array = [
					'final_amount' =>$return_total_amount,
					'weight_limit' =>round($weight_limit,2),
					'bill_fixed_amount' =>round($minimum_amount,2),
					'rate' =>$rate,
					'excess_rate' =>$excess_rate,
					'total_bed' =>$total_bed,
					'total_collection'=>$total_collection
				];
				return $final_array;				
			}

		}elseif($client->billing_type == 2){ // for per bed  ******************
			$per_bed_amount = !empty($client->per_bed_amount)?$client->per_bed_amount:0;
			$per_bed_maximum_weight = !empty($client->per_bed_maximum_weight)?$client->per_bed_maximum_weight:0;
			$per_bed_fixed_beds = !empty($client->per_bed_fixed_beds)?$client->per_bed_fixed_beds:0;
			$per_bed_fixed_amount = !empty($client->per_bed_fixed_amount)?($client->per_bed_fixed_amount/$month_day_count)*$billing_days:0;
			$per_bed_total_beds = !empty($client->per_bed_total_beds)?$client->per_bed_total_beds:0;
			$per_bed_excess_bill = !empty($client->per_bed_excess_bill)?$client->per_bed_excess_bill:0;

			$no_of_beds = $per_bed_total_beds-$per_bed_fixed_beds;
			// dd($no_of_beds);
			
			$weight_limit = $per_bed_maximum_weight;
			$rate = $per_bed_amount;
			$excess_rate = 0;
			$total_bed = $per_bed_total_beds;

			if($no_of_beds < 0){
				$no_of_beds = 0;
			}
			$return_total_amount = ((($per_bed_amount*$no_of_beds)*$billing_days)+($per_bed_fixed_amount));
			if(!empty($total_collection)){
			// dd($per_bed_amount,$no_of_beds,$per_bed_fixed_amount,$client->is_excess_billed);
				if($client->is_excess_billed == '1' || $client->is_excess_billed == 1){

					$find_excess_weight = $total_collection-$per_bed_maximum_weight;
					// dd($find_excess_weight);
					$excess_rate = $per_bed_excess_bill;
					if($find_excess_weight > 0){
						$return_total_amount = (($return_total_amount)+($per_bed_excess_bill*$find_excess_weight));
					}
					$final_array = [
						'final_amount' =>$return_total_amount,
						'bill_fixed_amount' =>round($per_bed_fixed_amount,2),
						'weight_limit' =>round($weight_limit,2),
						'rate' =>$rate,
						'excess_rate' =>$excess_rate,
						'total_bed' =>$total_bed,
						'total_collection'=>$total_collection
					];
					return $final_array;

				}else{
					$final_array = [
						'final_amount' =>$return_total_amount,
						'weight_limit' =>round($weight_limit,2),
						'bill_fixed_amount' =>round($per_bed_fixed_amount,2),
						'rate' =>$rate,
						'excess_rate' =>$excess_rate,
						'total_bed' =>$total_bed,
						'total_collection'=>$total_collection
					];
					return $final_array;
				}
			}else{
				$final_array = [
					'final_amount' =>$return_total_amount,
					'weight_limit' =>round($weight_limit,2),
					'bill_fixed_amount' =>round($per_bed_fixed_amount,2),
					'rate' =>$rate,
					'excess_rate' =>$excess_rate,
					'total_bed' =>$total_bed,
					'total_collection'=>$total_collection
				];
				return $final_array;
			}


		}elseif($client->billing_type == 3){ // for per kg ******************
			$per_kg_amount = $client->per_kg_amount; // 10
			$per_kg_maximum_weight = $client->per_kg_maximum_weight; // 0
			$per_kg_total_beds = $client->per_kg_total_beds;
			$excess_rate = $client->excess_rate; // 
			$per_kg_excess_bill = $client->per_kg_excess_bill;

			$weight_limit = $per_kg_maximum_weight;
			$rate = $per_kg_amount;
			$excess_rate = $per_kg_excess_bill;
			$total_bed = 0;
			if($excess_rate == 0 || $excess_rate == '0'){
				$excess_rate = $rate;
				$per_kg_excess_bill = $rate;
			}
			if($rate == 0 || $rate == '0'){
				$rate = $excess_rate;
				$per_kg_amount = $excess_rate;
			}

			// dd($rate,$excess_rate);

			if($per_kg_maximum_weight  == 0 || $per_kg_maximum_weight  == '0'){
				if($per_kg_amount == 0 || $per_kg_amount == '0'){
					$return_total_amount = $per_kg_excess_bill*$total_collection;
				}else{
					$return_total_amount = $per_kg_amount*$total_collection;
				}
			}
			else{
				if($total_collection <= $per_kg_maximum_weight){
					$return_total_amount = $per_kg_amount*$total_collection; // 10 * 160 
				}else{
					$return_total_amount = $per_kg_amount*$per_kg_maximum_weight; // 10*0
					$return_total_amount = $return_total_amount+($total_collection-$per_kg_maximum_weight)*$per_kg_excess_bill; // (0)+(160-0)*50

				}
			}
			// dd($total_collection,$per_kg_amount,$per_kg_maximum_weight,($total_collection-$per_kg_maximum_weight));
			$final_array = [
				'final_amount' =>$return_total_amount,
				'bill_fixed_amount' =>0,
				'weight_limit' =>round($weight_limit,2),
				'rate' =>$rate,
				'excess_rate' =>$excess_rate,
				'total_bed' =>$total_bed,
				'total_collection'=>$total_collection
			];
			return $final_array;

			// dd($per_kg_amount,$per_kg_maximum_weight);
			// if(!empty($total_collection)){
			// 	if($client->is_excess_billed == '1' || $client->is_excess_billed == 1){

			// 		$find_excess_weight = $total_collection-$per_kg_maximum_weight;
			// 		if($find_excess_weight > 0){
			// 			$return_total_amount = (($return_total_amount)+($excess_rate*$find_excess_weight));
			// 		}
			// 		return $return_total_amount;

			// 	}else{
			// 		return $return_total_amount;
			// 	}
			// }else{
			// 	return $return_total_amount;
			// }
		}else{  // if billing type is not listing in above case ******************
			return 0 ;
		} 

	}
	public static function get_bill_no($bill_series_id,$gst_status){
        
        $bill_series= DB::table('bill_series')->where('id' , $bill_series_id)->first();
        $bill_no= $bill_series->series.($bill_series->voucher+1);
		// if($gst_status==1){
  //       }
  //       else{
  //           $bill_no= $bill_series->series.($bill_series->voucher+1);
  //       }
        return $bill_no;
	}
	public static function update_Bill_no($bill_series_id){
		$date = date('Y-m-d H:i:s');
        $user_id = Auth::user()->id;
        // dd($bill_series_id);
        DB::beginTransaction();
		$bill_series = DB::table('bill_series')->where('id',$bill_series_id)->first();
		$set_update = DB::table('bill_series')->where('id' , $bill_series_id)->update([
            'voucher'=>$bill_series->voucher+1,
            'updated_at' => $date,
            'updated_by' => $user_id
        ]);
        if($set_update){
        	DB::commit();
        	return true;
        }else{
        	DB::rollback();
        	return false;
        }
	}

	public static function check_account_posting($client){
        $plant = Plant::find($client->plant);

        if($client->billing_type == 1){
            $gst_applicable_status = $client->maximum_weight_gst_applicable;
        }elseif($client->billing_type == 2){
            $gst_applicable_status = $client->per_bed_gst_applicable;
        }elseif($client->billing_type == 3){
            $gst_applicable_status = $client->per_kg_gst_applicable;
        }else{
            $gst_applicable_status = 0;
        }
        $gst_applicable_status = $client->is_gst_applicable;
        $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
        if(empty($sundryAccountingLedger->id)){
	    	return 'Ledger Missign for this client Please check then make a bill';
        }

	    if ($gst_applicable_status == 1) {
	        if ($client->state1 == $plant->state) {
	        	$CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
		                                ->whereHas('ledgerType', function ($q) {
		                                    $q->where('name', ConstantHelper::CGST);
		                                })->first();

	            $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
	                                    ->whereHas('ledgerType', function ($q) {
	                                        $q->where('name', ConstantHelper::SGST);
	                                    })->first();

	            if(empty($CGSTAccountingLedger->id)){
	            	return 'CGST Ledger missing Please check then make a bill';
	        	}
	        	if(empty($CGSTAccountingLedger->id)){
	            	return 'SGST Ledger missing Please check then make a bill';
	        	}
	        }
	    }else{
	    	return 'Non Taxable Bill';
	    }

	    return true;

	}
	public static function calculate_gst_details($client,$final_amount){


        $plant = Plant::find($client->plant);
        $gsrt_array_details = [];
        $totalTaxAmt = 0;
		$SGSTtaxableAmount = 0;
		$CGSTtaxableAmount = 0;
		$IGSTtaxableAmount = 0;
        if ($client->state1 == $plant->state) {

            // FIND CGST LEDGER in DUTIES & TAXES GROUP
            $CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                ->whereHas('ledgerType', function ($q) {
                    $q->where('name', ConstantHelper::CGST);
                })->first();


            $CGSTpercentage = $CGSTAccountingLedger ? $CGSTAccountingLedger->percentage : 9;
            $CGSTtotalAmount = $final_amount * ((100 - $CGSTpercentage) / 100);
            $CGSTtaxableAmount = ($final_amount - $CGSTtotalAmount);
            

            // FIND SGST LEDGER in DUTIES & TAXES GROUP
            $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                ->whereHas('ledgerType', function ($q) {
                    $q->where('name', ConstantHelper::SGST);
                })->first();

            $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
            $SGSTtotalAmount = $final_amount * ((100 - $SGSTpercentage) / 100);
            $SGSTtaxableAmount = ($final_amount - $SGSTtotalAmount);

            
        } else {
    		$IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::IGST);
                                })->first();

            $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
            $IGSTtotalAmount = $final_amount * ((100 - $IGSTpercentage) / 100);
            $IGSTtaxableAmount = ($final_amount - $IGSTtotalAmount);
        }
        $totalTaxAmt = ($SGSTtaxableAmount + $CGSTtaxableAmount + $IGSTtaxableAmount);
        $gsrt_array_details['gst_amt'] = $totalTaxAmt;
        $gsrt_array_details['fimal_after_gst_amt'] = $final_amount+$totalTaxAmt;

        return $gsrt_array_details;

	}

	public static function get_po_number($client_id,$date){
		// return DB::table('client_purchase_orders')

		// 		->whereRaw("")
		// 		->orderBy('id','DESC')
		// 		->first();
		return 0;
	}
}