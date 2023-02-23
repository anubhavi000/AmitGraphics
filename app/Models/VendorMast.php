<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorMast extends Model
{
    use HasFactory;
    protected $table = 'vendor_mast';

    static function ReturnVendorById($id){
    	$vendor = self::where('id' , (int)$id)
    				  ->first();
    	return $vendor;
    }
    static function checknameduplicacy($name){
    	$check = self::where('v_name' , $name)
    				 ->where('status' , 1)
    				 ->first();
    	if(empty($check)){
    		return false;
    	}
    	else{
    		return true;
    	}
	}   
    public static function pluckactives(){
        return Self::where('status' , 1)
                   ->orderBy('v_name' , 'asc')
                   ->pluck('v_name' , 'id')
                   ->toArray();
    }
    static function pluckall(){
        return Self::orderBy('v_name' , 'asc')
                   ->pluck('v_name' , 'id')
                   ->toArray();
    } 
}
