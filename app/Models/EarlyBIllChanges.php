<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EarlyBIllChanges extends Model
{
    use HasFactory;
    protected $table= "early_bill_client_changes";
    protected $fillable = [
        'plant_id',
        'client_id',
        'client_address',
        'route_id',
        'executive_id',
        'file_no',
        'fixed_amount',
        'balance',
        'security',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'service_start_date',
        'billing_date',
        'month_year',
        'remarks',
    ];
}
