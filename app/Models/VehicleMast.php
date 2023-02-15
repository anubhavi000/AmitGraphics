<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleMast extends Model
{
    use HasFactory;
    protected $table = 'vehicle_mast';

    static function pluckactives(){
    	return Self::where('status' , 1)
    			   ->pluck('vehicle_no' , 'id')
    			   ->toArray();
    }
}
