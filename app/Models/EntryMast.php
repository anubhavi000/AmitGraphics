<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EntryLogs;
use App\Models\VehicleMast;
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
                        'site',
                        'is_generated',
                        'excess_wt_allowance',
                        'print_status',
                        'delete_status',
                        'owner_site',
                        'generation_time'
    					];

    static function store_slip($req){
        $auth = Auth::user();
    	$req['created_at'] = date('Y-m-d h:i:s');
    	$req['created_by'] =  Auth::user()->id;
    	$req['datetime']   =  date('Y-m-d');
        $req['owner_site'] =  $auth->site;
        $LastSlip  = Self::orderBy('id' , 'DESC')
                        ->first();
        if(!empty($LastSlip)){
            $req['slip_no']  =  $LastSlip->slip_no + 1;
        }
        else{
            $req['slip_no']  =  1;
        }

        if(!empty($req['vehicle'])){
            $vehicle = VehicleMast::where('id' , $req['vehicle'])
                                   ->first();
            $req['vendor_id'] = !empty($vehicle->vendor) ? $vehicle->vendor : NULL;
        }
        if(!empty($req['items_included'])){
            $req['items_included']  = json_encode($req['items_included']);
        }

        $req['excess_wt_allowance'] = $vehicle->excess_wt_allowance; 
    	$obj = Self::create($req);
    	
    	if(!empty($obj)){
            $res = [
                'res'    => true,
                'slip_no'=> $obj['slip_no'] 
            ];
    		return $res;
    	}
    	else{
            $res = [
                'res'    => false,
                'slip_no'=> NULL 
            ];
    		return $res;
    	}
    }
    static function editslip($req  , $slip_no){
        $req['updated_at'] = date('Y-m-d h:i:s');
        $req['updated_by'] =  Auth::user()->id;
        $req['datetime']   =  date('Y-m-d');

        if(!empty($req['vehicle'])){
            $vehicle = VehicleMast::where('id' , $req['vehicle'])
                                   ->first();
            $req['vendor_id'] = !empty($vehicle->vendor) ? $vehicle->vendor : NULL;
        }
        if(!empty($req['items_included'])){
            $req['items_included']  = json_encode($req['items_included']);
        }

        $req['excess_wt_allowance'] = $vehicle->excess_wt_allowance; 
        $obj = Self::where('slip_no' , $slip_no)->update($req);

                    // ->update($req);
        
        if($obj){
            // $res = [
            //     'res'    => true,
            //     'slip_no'=> $id 
            // ];
            return true;
        }
        else{
            // $res = [
            //     'res'    => false,
            //     'slip_no'=> NULL 
            // ];
            return false;
        }        
    }
    static function generateslip($req , $id){
        $now_id = decrypt($id);
        $entry = self::where('slip_no' , $now_id)->first();
        if(empty($entry)){
            return [
                'res'   => false,
                'print' => false
            ];
        }
        else{
        $auth = Auth::user();
            DB::begintransaction();
            // updating the entry in entry_mast
            if($req['excess_weight'] == 0 || $req['excess_weight'] < 0){
                $print_status = 1;
            }
            else{
                $print_status = 0;
            }
            $update_arr = [
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
                                'gross_weight'          => !empty($req['gross_weight']) ? $req['gross_weight'] : NULL,
                                'net_weight'            => !empty($req['net_weight']) ? $req['net_weight'] : NULL,
                                'excess_weight'         => !empty($req['excess_weight']) ? $req['excess_weight'] : NULL,
                                'vehicle_pass'          => !empty($req['vehicle_pass']) ? $req['vehicle_pass'] : NULL,
                                'is_generated'          => 1,
                                'print_status'          => $print_status,
                                'owner_site'            => $auth->site
                            ];
            $checkifedited = EntryLogs::where('entry_slip_no' , $now_id)
                                      ->get();
            if(count($checkifedited) == 0){
                $update_arr['generation_time'] = date('Y-m-d h:i:s');
            }                            
            $update = self::where('slip_no' , $now_id)
                          ->update($update_arr
                                // 'acess_weight_quantity' => !empty($req['acess_weight_quantity']) ? $req['acess_weight_quantity'] : NULL,
                                // 'items_included'        => !empty($req['items_included']) ? json_encode($req['items_included'] , true) : NULL,
                                // 'plant'                 => !empty($req['plant']) ? $req['plant'] : NUll,
                                // 'updated_at'            => date('Y-m-d h:i:s'),
                                // // 'entry_rate'            => !empty($req['entry_rate']) ? $req['entry_rate'] : NUll,
                                // 'entry_weight'          => !empty($req['entry_weight']) ? $req['entry_weight'] : NULL,
                                // 'supervisor'            => !empty($req['supervisor']) ? $req['supervisor'] : NULL,
                                // 'site'                  => !empty($req['site']) ? $req['site'] : NULL,
                                // 'kanta_slip_no'         => !empty($req['kanta_slip_no']) ? $req['kanta_slip_no'] : NULL,
                                // 'vendor_id'             => !empty($req['vendor_id']) ? $req['vendor_id'] : NUll,
                                // 'datetime'              => date('Y-m-d h:i:S'),
                                // 'updated_by'            => Auth::user()->id,
                                // 'gross_weight'          => !empty($req['gross_weight']) ? $req['gross_weight'] : NULL,
                                // 'net_weight'            => !empty($req['net_weight']) ? $req['net_weight'] : NULL,
                                // 'excess_weight'         => !empty($req['excess_weight']) ? $req['excess_weight'] : NULL,
                                // 'vehicle_pass'          => !empty($req['vehicle_pass']) ? $req['vehicle_pass'] : NULL,
                                // 'is_generated'          => 1,
                                // 'print_status'          => $print_status,
                                // 'owner_site'            => $auth->site
                          );
            // inserting in the log table
            $arr = [
                'updated_by'    => Auth::user()->id,
                'updated_at'    => date('Y-m-d h:i:s'),
                'entry_slip_no' => $now_id 
            ];
            $insert = EntryLogs::create($arr);
            if($insert && $update){
                DB::commit();
                return [
                    'res'  => true,
                    'plant'=> $req['plant'],
                    'print'=> $print_status
                ];
            }
            else{
                DB::rollback();
                return [
                    'res'   => true,
                    'plant' => $req['plant'],
                    'print' => false
                ];
            }
        }
    }
}
