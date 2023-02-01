<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantMast extends Model
{
    use HasFactory;
    protected $table = 'plant_mast';

    static function pluckactives(){
    	return self::where('status' , 1)
    			   ->pluck('name' , 'id')
    			   ->toArray();
    }
}
