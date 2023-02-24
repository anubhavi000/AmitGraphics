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
      'rate_ton',
    	'status'
    ];
    static function activesitespluck(){
        return self::where('status' , 1)
                   ->orderBy('name' , 'asc')
                   ->pluck('name' , 'id')
                   ->toArray();
    }
    static function pluckall(){
      return self::orderBy('name' , 'asc')
                 ->pluck('name' , 'id')
                 ->toArray();
    }
    static function dealersitespluck(){
        return self::where('status' , 1)
                   ->where('is_owner' , 0)
                   ->orderBy('name' , 'asc')
                   ->pluck('name' , 'id')
                   ->toArray();
    }    
    static function alldelaertsite(){
      return self::where('is_owner' , 0)
                 ->orderBy('name' , 'asc')
                 ->pluck('name' , 'id')
                 ->toArray();
    }
}
