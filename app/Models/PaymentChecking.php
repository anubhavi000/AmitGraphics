<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use DB;
use Auth;
use App\Models\VendorRate;

use Illuminate\Database\Eloquent\Model;

class PaymentChecking extends Model
{
    use HasFactory;
    protected $table = 'payment_checking';

    static function CreateEntries($id){
    	DB::begintransaction();

        $data  =  EntryMast::whereIn('id' , $id)
                              ->get();    	
        // marking those entry checked in entry mast
        $update = EntryMast::whereIn('id' , $id)
        				   ->update(['is_checked' => 1]);

        $rate = VendorRate::plucksiterate(); 

    	$insert = array();
        $rate = VendorRate::plucksiterate();
    	foreach ($data as $key => $value) {
            $amount = 0;
            if(!empty($rate[$value->owner_site])){
                $amount = ($value->net_weight/1000) * $rate[$value->owner_site];
            }
            else{
                $amount = 0;
            }
    		$insert[] = [
    			'slip_no' 				  => $value->slip_no,
    			'kanta_slip_no' 		  => $value->kanta_slip_no,
    			'datetime'  			  => $value->datetime,
    			'is_owner'				  => !empty($value->is_owner) ? $value->is_owner : '',
    			'vendor_id'				  => $value->vendor_id , 
    			'entry_weight'			  => $value->entry_weight,	
    			'acess_weight_quantity'	  => !empty($value->acess_weight_quantity) ? $value->acess_weight_quantity : NULL,
                'amount'                  => !empty($amount) ? $amount : 0,
    			'items_included'		  => !empty($value->items_included) ? $value->items_included : NULL,
    			'supervisor'			  => !empty($value->supervisor) ? $value->supervisor : NULL,
    			'vehicle'				  => !empty($value->vehicle) ? $value->vehicle : NULL,
    			'site'					  => !empty($value->site) ? $value->site : NULL,
    			'plant'					  => $value->plant,
    			'gross_weight'			  => $value->gross_weight,
    			'net_weight'			  => $value->net_weight,
    			'vehicle_pass'			  => $value->vehicle_pass,
    			'excess_weight'			  => !empty($value->excess_weight) ? $value->excess_weight : 0,
    			'is_generated'			  => $value->is_generated,
    			'excess_wt_allowance'	  => $value->excess_wt_allowance,
    			'delete_status'			  => $value->delete_status,
    			'owner_site'			  => $value->owner_site,
    			'generation_time'		  => $value->generation_time,
    			'driver'				  => !empty($value->driver) ? $value->driver :NULL,
    			'manual'				  => $value->manual,
    			'remarks'				  => $value->remarks,
    			'generation_minutehours'  => $value->generation_minutehours,
    			'loading_minutehours' 	  => $value->loading_minutehours,
    			'created_at'			  => date('Y-m-d h:i:s'),
    			'created_by'			  => Auth::user()->id,	
    			'updated_by'			  => Auth::user()->id,
    			'updated_at'			  => date('Y-m-d h:i:s'),
    		];
    	}
    	$check = Self::insert($insert);
    	if($check && $update){
    		DB::commit();
    		return true;
    	}
    	else{
    		DB::rollback();
    		return false;
    	}
    }
}
