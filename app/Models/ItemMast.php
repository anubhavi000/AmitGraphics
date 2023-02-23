<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMast extends Model
{
    use HasFactory;
    protected $table = "item_mast";

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
                       ->orderBy('name' , 'asc')
                       ->pluck('name' , 'id')
                       ->toArray();
        }
        static function pluckall(){
            return Self::orderBy('name' , 'asc')
                       ->pluck('name' , 'id')
                       ->toArray();
        }
    }    
