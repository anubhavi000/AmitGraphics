<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class PharmaClient extends Model
{
    protected $table = 'pharma_client';

    protected $fillable = [
        'id',
        'company_id',
        'char_id',
        'sec_char_id',
        'sec_closing_balance',
        'business_name',
        'plant',
        'closing_balance',
        'phone_number',
        'landline',
        'contact_person_name',
        'contact_person_phone_number',
        'contact_person_email',
        'gstin',
        'enabled',
        'billing_name',
        'narration_on_bill',
        'notes',
        'agreement_start_date',
        'agreement_end_date',
        'vender_code',
        'service_start_date',
        'file_number',
        'rate_per_kg',
        'is_fixed_plan',
        'is_gst_applicable',
        'maximum_weight',
        'minimum_amount' ,
        'excess_rate',
        'is_excess_billed',
        'contact_address1',
        'contact_state',
        'contact_city',
        'contact_pincode',
        'service_address1',
        'service_address2',
        'service_state',
        'service_city',
        'service_pincode',
        'contact_district',
        'service_district',
        'status',
        'created_by',
        'updated_by',
        'po_number',
        'po_date',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            $model->created_by = $user->id;

            /**
             * Creating Ledger for accounting application
             *
             * @param  \App\Models\PharmaClient  $model
             */
            \DB::beginTransaction();
            try {
                $plant = Plant::find($model->plant);
                if ($plant) {
                    // TYPE 9 = SECURITY ACCOUNT & TYPE = 10 SUNDRY DEBTORS ACCOUNT
                    // Security One Month Advance Group Head
                    // OMA =  One Month Advance
                    // $securityGroupHead = AccountingGroup::where("code", "OMA-$plant->char_id")->first();
                    // if ($securityGroupHead) {
                    //     // Add Security One Month Advance Ledger
                    //     AccountingLedger::create(
                    //         [
                    //             'type' => 9,
                    //             'group_id' => $securityGroupHead->id,
                    //             'name' => $model->business_name . ' - SEC',
                    //             'code' => $model->client_char_id . '-SEC',
                    //             'plant_char_id' => $plant->char_id,
                    //             'op_balance' => $model->sec_closing_balance ? $model->sec_closing_balance : 0,
                    //             'notes' => $model->business_name . ' - ' . strtoupper($plant->name),
                    //         ]
                    //     );
                    // }

                    // SD = Sundry Debtors
                    $sundryGroupHead = AccountingGroup::where("code", "SD-$plant->char_id")->first();
                    if ($sundryGroupHead) {
                        // Add Sundry Debtors Ledger
                        AccountingLedger::create(
                            [
                                'type' => 10,
                                'group_id' => $sundryGroupHead->id,
                                'name' =>  $model->business_name,
                                'code' =>  $model->char_id,
                                'plant_char_id' => $plant->char_id,
                                'op_balance' => $model->closing_balance ? $model->closing_balance : 0,
                                'notes' => $model->business_name . ' - ' . strtoupper($plant->name),
                            ]
                        );
                    }
                } else {
                    \DB::rollback();
                    throw new Exception("No plant found.");
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                throw new Exception($e->getMessage());
            }
        });

        static::updating(function ($model) {
            $user = \Auth::user();
            $model->updated_by = $user->id;
        });
    }

    public function plantList()
    {
        return $this->belongsTo(Module::class,  'module_id');
    }
    public function district(){
        return $this->belongsTo(District::class,  'contact_district');
    }
}
