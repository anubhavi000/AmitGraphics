<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\sites;

class VendorRate extends Model
{
    use HasFactory;

    protected $table = "vendor_rate_master";
    public $timestamps = false;
    protected $fillable = [
    	'created_at',
    	'created_by',
    	'updated_at',
    	'updated_by',
    	'vendor',
    	'from_date',
    	'to_date',
    	'rate_ton',
    	'site'
    ];
    static function pluckvendorrate(){
        $date = date('Y-m-d');
        $raw = Self::where('status' , 1)->get();
        $out = [];
        foreach ($raw as $key => $value) {
            $out[$value->site][$value->vendor] = $value->rate_ton;
        }
        return $out;
    }
    static function plucksiterate(){
        return sites::pluck('rate_ton' , 'id')
                    ->toArray();
    }
}
