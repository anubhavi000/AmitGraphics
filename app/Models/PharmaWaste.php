<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class PharmaWaste extends Model
{
    protected $table = 'pharma_waste';

    protected $fillable = [
        'id',
        'company_id',
        'char_id',
        'pharma_client',
        'plant',
        'date',
        'number_of_bags',
        'transporter_name',
        'gr_number',
        'lr_number',
        'gross_weight',
        'tare_weight',
        'net_weight',
        'less_weight_type',
        'less_weight',
        'challan_type_key',
        'challan_type_document_number',
        'billing_name',
        'action_taken',
        'narration',
        'waste_type',
        'address1',
        'address2',
        'state',
        'district',
        'city',
        'pincode',
        'document_recieved',
        'cfa_details',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'is_bill_generated', 
        'service_address',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $user = \Auth::user();
    //         $model->created_by = $user->id;
    //         dd($model)

    //         /**
    //          * Creating Ledger for accounting application
    //          *
    //          * @param  \App\Models\PharmaClient  $model
    //          */
    //         \DB::beginTransaction();
    //         try {
    //             $plant = Plant::find($model->plant);
    //             if ($plant) {
                    
    //             } else {
    //                 \DB::rollback();
    //                 throw new Exception("No plant found.");
    //             }
    //             \DB::commit();
    //         } catch (\Exception $e) {
    //             \DB::rollback();
    //             throw new Exception($e->getMessage());
    //         }
    //     });

    //     static::updating(function ($model) {
    //         $user = \Auth::user();
    //         $model->updated_by = $user->id;
    //     });
    // }

}
