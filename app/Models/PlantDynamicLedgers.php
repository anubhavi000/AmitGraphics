<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantDynamicLedgers extends Model
{

    protected $table = "payment";


    protected $fillable = ['entry_id', 'ledger_id', 'amount', 'dc', 'reconciliation_date'];

    public $timestamps = false;
}
