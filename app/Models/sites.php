<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sites extends Model
{
    use HasFactory;
    protected $table = 'site_mast';
    protected $fillable = [
    	'name',
    	'address',
    	'latitude',
    	'longitude',
    	'created_at',
    	'created_by',
    	'updated_at',
    	'updated_by',
    	'status'
    ];
}
