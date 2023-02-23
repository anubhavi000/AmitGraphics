<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
