<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMast extends Model
{
    use HasFactory;
    protected $table = 'vehicle_mast';

    static function pluckactives(){
    	$data =  Self::where('status' , 1)
    			   ->orderBy('vehicle_no' , 'asc')
    			   ->pluck('vehicle_no' , 'id')
    			   ->toArray();
    	$data2 = natsort($data);
    	// dd($data);
    	return $data;
    }
}
