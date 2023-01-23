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
}
