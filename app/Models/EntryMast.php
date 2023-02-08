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
                        'net_weight',
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
                        'generation_time',
                        'driver',
                        'manual',
                        'vehicle_pass',
                        'remarks'
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
            if(isset($req['vehicle'])){
                $vehicle = VehicleMast::where('id' , $req['vehicle'])
                                       ->first();
                $req['vendor_id'] = !empty($vehicle->vendor) ? $vehicle->vendor : NULL;
            }            
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
                                'vehicle'               => !empty($req['vehicle']) ? $req['vehicle'] : NULL,
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
                                'owner_site'            => $auth->site,
                                'driver'           => !empty($req['driver']) ? $req['driver'] : NULL
                            ];
                            // dd($update_arr);
                            // dd($req);
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
    static function storeManualChallan($res){

        // $res['datetime']         = !empty($res['datetime']) ? date('Y-m-d' , strtotime($res['datetime'])) : date('Y-m-d');
        $res['created_by']       = Auth::user()->id;
        $res['manual']           = 1;
        $res['print_status']     = 1;
        
        if(!empty($res['datetime']) && !empty($res['datetimehourminute'])){
            $time = $res['datetime'].' '.$res['datetimehourminute'];
            $res['datetime'] = date('Y-m-d h:i:s' , strtotime($time));
        }
        else{
            $res['datetime'] = date('Y-m-d h:i:s');
        }
        if(!empty($res['generation_time']) && !empty($res['generation_hourminute'])){
            $time = $res['generation_time'].' '.$res['generation_hourminute'];
            $res['generation_time'] = date('Y-m-d h:i:s' , strtotime($time));
        }
        else{
            $res['generation_time'] = date('Y-m-d h:i:s');
        }
        // $res['generation_time']  = !empty($res['generation_time']) ? date('Y-m-d h:i:s' , strtotime($res['generation_time'])) : date('Y-m-d h:i:s');
        $res['is_generated']     = 1;
        $res['items_included']   = json_encode($res['items_included'] , true);
        if(!empty($res['vehicle'])){
            $vehicle_selected = VehicleMast::where('id' , $res['vehicle'])
                                            ->first();
            $res['vendor_id'] = !empty($vehicle_selected->vendor) ? $vehicle_selected->vendor : '';
            $res['excess_wt_allowance'] = !empty($vehicle_selected->excess_wt_allowance) ? $vehicle_selected->excess_wt_allowance : NULL; 
        }
        $res['print_status']  = 1;
        $res['owner_site']    = Auth::user()->site;
        $store = EntryMast::create($res);
        if(!empty($store)){
            return $store;
        }
        else{
            return false;
        }
    }
    public static function  updateManualChallan($res , $id){
        if(!empty($res['vehicle'])){
            $vehicle_selected = VehicleMast::where('id' , $res['vehicle'])
                                            ->first();
            $vendor_id = !empty($vehicle_selected->vendor) ? $vehicle_selected->vendor : '';
            $excess_wt_allowance = !empty($vehicle_selected->excess_wt_allowance) ? $vehicle_selected->excess_wt_allowance : NULL; 
        }
        $update_arr = [
            'datetime' => !empty($res['datetime']) ? date('Y-m-d' ,  strtotime($res['datetime'])) : date('Y-m-d'),
            'updated_by' => Auth::user()->id,
            'manual'   => 1,
            'updated_at' => date('Y-m-d h:i:s'),
            'print_status' => 1,
            'is_generated' => 1,        
            // 'generation_time' => !empty($res['generation_time']) ? date('Y-m-d' , strtotime($res['datetime'])) : date('Y-m-d h:i:s'),
            'items_included' => json_encode($res['items_included'] , true),
            'vehicle'    => $res['vehicle'],
            'vendor_id' => $vendor_id,
            'excess_wt_allowance' => $excess_wt_allowance,
            'owner_site' => Auth::user()->owner_site,
            'slip_no' => $res['slip_no'],
            'remarks' => !empty($res['remarks']) ? $res['remarks'] : NULL,
            'entry_weight' => $res['entry_weight'],
            'gross_weight' => $res['gross_weight'],
            'net_weight' => $res['net_weight'],
            'excess_weight' => $res['excess_weight'],
            'plant' => $res['plant'],
            'site' => $res['site'],
            'kanta_slip_no' => $res['kanta_slip_no'],
            'supervisor' => $res['supervisor'],
            'owner_site'  => !empty(Auth::user()->site) ? Auth::user()->site : NULL,
            'vehicle_pass' => $res['vehicle_pass'],
            'driver' => $res['driver'],
            'items_included' => json_encode($res['items_included'])
        ];
            if(!empty($res['generation_time']) && !empty($res['generation_hourminute'])){
                $time = $res['generation_time'].' '.$res['generation_hourminute'];
                $update_arr['generation_time'] = date('Y-m-d h:i:s' , strtotime($time));
            }
            else{
                $update_arr['generation_time'] = date('Y-m-d h:i:s');
            }
        if(!empty($res['datetime']) && !empty($res['datetimehourminute'])){
            $time = $res['datetime'].' '.$res['datetimehourminute'];
            $update_arr['datetime'] = date('Y-m-d h:i:s' , strtotime($time));
        }
        else{
            $update_arr['datetime'] = date('Y-m-d h:i:s');
        }                                

        $store = EntryMast::where('id' , $id)->update($update_arr);
        if(!empty($store)){
            return $store;
        }
        else{
            return false;
        }
    }
}
