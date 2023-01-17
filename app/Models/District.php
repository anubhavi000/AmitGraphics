<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district';
    protected $guarded = [];
    public function client(){
       return $this->belongsTo(Client::class,'id','district1');
    }
}