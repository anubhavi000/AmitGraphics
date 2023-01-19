<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
