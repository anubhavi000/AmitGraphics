<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EntryLogs;
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
    					'created_at',
    					'created_by',
    					'updated_by'
    					];

    static function store_slip($req){
    	$req['created_at'] = date('Y-m-d h:i:s');
    	$req['created_by'] =  Auth::user()->id;
    	$req['datetime']   =  date('Y-m-d h:i:s');
 
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
                                'acess_weight_quantity' => $req['acess_weight_quantity'],
                                'items_included'        => json_encode($req['items_included'] , true)
                          ]);
            // inserting in the log table
            $arr = [
                'updated_by' => Auth::user()->id,
                'updated_at' => date('Y-m-d h:i:s'),
                'entry_slip_no'
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
