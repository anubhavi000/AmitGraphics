<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EntryLogs;
use App\models\VehicleMast;
use App\Models\VendorMast;
use Auth;
use DB;

class EntryMast extends Model
{
    use HasFactory;
    protected $table = 'entry_mast';
    public $timestamps = false;
    protected $fillable = [
    					'slip_no',
    					'series',
    					'datetime', 
                        'entry_rate',
                        'entry_weight',
                        'plant',
                        'items_included',
                        'gross_weight',
                        'acess_weight_quantity',
                        'vendor_id',
    					'created_at',
    					'created_by',
    					'updated_by',
                        'supervisor',
                        'vehicle',
                        'kanta_slip_no',
                        'site'
    					];

    static function store_slip($req){
    	$req['created_at'] = date('Y-m-d h:i:s');
    	$req['created_by'] =  Auth::user()->id;
    	$req['datetime']   =  date('Y-m-d h:i:s');

        $LastSlip  = Self::orderBy('id' , 'DESC')
                        ->first();
        if(!empty($LastSlip)){
            $req['slip_no']  =  $LastSlip->slip_no + 1;
        }
        else{
            $req['slip_no']  =  1;
        }

        if(!empty($req['vehicle'])){
            $vehicle = VehicleMast::where('vehicle_no' , (int)$req['vehicle'])
                                   ->first();
            $req['vendor_id'] = !empty($vehicle->vendor) ? $vehicle->vendor : NULL;
        }
        if(!empty($req['items_included'])){
            $req['items_included']  = json_encode($req['items_included']);
        }

    	$obj = Self::create($req);
    	
    	if(!empty($obj)){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    static function generateslip($req , $id){
        $now_id = decrypt($id);
        $entry = self::where('slip_no' , $now_id)->first();
        if(empty($entry)){
            return false;
        }
        else{
            DB::begintransaction();
            // updating the entry in entry_mast
            $update = self::where('slip_no' , $now_id)
                          ->update([
                                // 'acess_weight_quantity' => !empty($req['acess_weight_quantity']) ? $req['acess_weight_quantity'] : NULL,
                                'items_included'        => !empty($req['items_included']) ? json_encode($req['items_included'] , true) : NULL,
                                'plant'                 => !empty($req['plant']) ? $req['plant'] : NUll,
                                'updated_at'            => date('Y-m-d h:i:s'),
                                // 'entry_rate'            => !empty($req['entry_rate']) ? $req['entry_rate'] : NUll,
                                'entry_weight'          => !empty($req['entry_weight']) ? $req['entry_weight'] : NULL,
                                'supervisor'            => !empty($req['supervisor']) ? $req['supervisor'] : NULL,
                                'site'                  => !empty($req['site']) ? $req['site'] : NULL,
                                'kanta_slip_no'         => !empty($req['kanta_slip_no']) ? $req['kanta_slip_no'] : NULL,
                                'vendor_id'             => !empty($req['vendor_id']) ? $req['vendor_id'] : NUll,
                                'datetime'              => date('Y-m-d h:i:S'),
                                'updated_by'            => Auth::user()->id,
                                'vehicle'               => !empty($req['vehicle']) ? $req['vehicle'] :NULL,
                                'gross_weight'          => !empty($req['gross_weight']) ? $req['gross_weight'] : NULL,
                                'net_weight'            => !empty($req['net_weight']) ? $req['net_weight'] : NULL,
                                'excess_weight'         => !empty($req['excess_weight']) ? $req['excess_weight'] : NULL,
                                'vehicle_pass'          => !empty($req['vehicle_pass']) ? $req['vehicle_pass'] : NULL
                          ]);
            // inserting in the log table
            $arr = [
                'updated_by'    => Auth::user()->id,
                'updated_at'    => date('Y-m-d h:i:s'),
                'entry_slip_no' => $now_id 
            ];
            $insert = EntryLogs::create($arr);
            if($insert && $update){
                DB::commit();
                return true;
            }
            else{
                DB::rollback();
                return false;
            }
        }
    }
}
