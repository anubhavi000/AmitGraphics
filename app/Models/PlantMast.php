<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantMast extends Model
{
    use HasFactory;
    protected $table = 'plant_mast';

    static function pluckactives(){
    	$data =  self::where('status' , 1)
    			   ->orderBy('name' , 'asc')
    			   ->pluck('name' , 'id')
    			   ->toArray();
    	$data2 = natsort($data);
    	return $data;
    }
    static function pluckall(){
        $data = self::orderBy('name' , 'asc')
                    ->pluck('name' , 'id')
                    ->toArray();
        $data2 = natsort($data);
        return $data;
    }
}
