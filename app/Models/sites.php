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
        'series',
        'is_owner',
    	'created_at',
    	'created_by',
    	'updated_at',
    	'updated_by',
    	'status'
    ];
    static function activesitespluck(){
        return self::where('status' , 1)
                   ->pluck('name' , 'id')
                   ->toArray();
    }
}
