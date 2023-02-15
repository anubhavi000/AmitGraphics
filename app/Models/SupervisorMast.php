<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupervisorMast extends Model
{
    use HasFactory;
    protected $table = 'supervisor_mast';
    
    static function checknameduplicacy($name){
    	$check = self::where('name' , $name)
    				 ->where('status' , 1)
    				 ->first();
    	if(empty($check)){
    		return false;
    	}
    	else{
    		return true;
    	}
	} 
    static function pluckactives(){
        return Self::where('status' , 1)
                    ->pluck('name' , 'id')
                    ->toArray();
    }    
}
