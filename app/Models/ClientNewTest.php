<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class ClientNewTest extends Model
{
    protected $table = 'clientnewtest';

    protected $fillable = [
      'id',
      'company_id',
      'closing_balance',
      'client_char_id', 
      'business_name', 
      'alias_name', 
      'debit', 
      'credit', 
      'address1', 
      'city1', 
      'district1', 
      'state1', 
      'pincode1', 
      'is_secondary_address', 
      'address2', 
      'city2', 
      'district2', 
      'state2', 
      'pincode2', 
      'file_no', 
      'plant', 
      'client_group', 
      'client_type', 
      'executive', 
      'is_govt_client', 
      'show_weights_on_bill', 
      'print_alias_name_on_bill', 
      'is_arrears_applied', 
      'secondary_address_on_bill', 
      'enabled', 
      'enabled_no_date',
      'gst_no', 
      'vender_code', 
      'phone_no', 
      'email_id', 
      'parent_group', 
      'where_to_send_bill', 
      'billing_type', 
      'billing_cycle', 
      'is_supply_applicable', 
      'show_occupancy', 
      'fixed_amount_total_beds', 
      'minimum_amount', 
      'maximum_weight', 
      'per_kg_maximum_weight', 
      'per_bed_maximum_weight', 
      'final_maximum_weight',
      'fixed_beds', 
      'fixed_amount',
      'per_bed_fixed_beds', 
      'per_bed_fixed_amount',
      'per_kg_fixed_beds', 
      'per_kg_fixed_amount',
      'maximum_weight_gst_applicable', 
      'excess_rate', 
      'fixed_excess_bill', 
      'fixed_excess_bill_gst_applicable', 
      'is_excess_billed', 
      'per_bed_total_beds', 
      'per_bed_amount', 
      'per_bed_gst_applicable', 
      'per_bed_excess_bill', 
      'per_bed_excess_bill_gst_applicable', 
      'per_kg_total_beds', 
      'per_kg_amount', 
      'per_kg_gst_applicable', 
      'per_kg_excess_bill', 
      'per_kg_excess_bill_gst_applicable', 
      'occupancy_applicable', 
      'supply_charges', 
      'is_occupancy_gst_applicable', 
      'is_supply1_applicable', 
      'supply1_charges', 
      'is_supply1_gst_applicable', 
      'supply1_charge_narration', 
      'is_supply2_applicable', 
      'supply2_charges', 
      'is_supply2_gst_applicable', 
      'supply2_charge_narration', 
      'agreement_start_date',
      'agreement_end_date',
      'service_start_date',
      'bill_calculation_date',
      'is_old_client', 
      'old_client', 
      'remark', 
      'is_rate_increment', 
      'rate_increment',
      'every', 
      'duration', 
      'amount_renewal_date',
      'print_on_agreement', 
      'constitution', 
      'is_authorized',
      'signing_authority', 
      'other_authority', 
      'registration_fee', 
      'security_deposit', 
      'advance_deposit', 
      'agreement_execution_date',
      'name_of_person', 
      'person_contact', 
      'contact_same_as_billing', 
      'person_email', 
      'email_same_as_billing', 
      'designation', 
      'client_agreement_person_list_primary_id', 
      'is_agreement_recieved', 
      'is_agreement_sent', 
      'agreement_recieved_date',
      'agreement_sent_date',
      'agreement_file', 
      'document', 
      'uploaded_document', 
      'hcf_name', 
      'hcf_address', 
      'hcf_contact_person', 
      'hcf_person_email', 
      'hcf_person_contact', 
      'hcf_landline', 
      'hcf_gst_no', 
      'pan_no', 
      'tan_no', 
      'signing_authority_pan_no', 
      'aadhar_no', 
      'pcb_authorization_no', 
      'authorization_date',
      'is_bedded', 
      'no_of_beds', 
      'bank_name', 
      'acc_no', 
      'ifsc_code', 
      'kyc_file', 
      'status', 
      'created_at',
      'created_by', 
      'updated_at',
      'updated_by', 
      'is_pharma_client', 
      'notes', 
      'payment_type', 
      'total_monthly_charges', 
      'accounting_head', 
      'client_executive', 
      'client_route_id', 
      'pharma_gst', 
      'is_discontinued', 
      'service_end_date', 
      'alternate_email', 
      'alternate_email_flag', 
      'contact_person_phone_secondary', 
      'old_soft_pk', 
      'discontinued_on', 
      'dis_continue_master_date', 
      'route_remove_notes', 
      'route_wise_executive', 
      'client_doc_approve_date', 
      'client_doc_receive_date', 
      'client_doc_send_date', 
      'advance_head', 
      'security_head', 
      'doctor_personal_email', 
      'is_rate_increment_by', 
      'increment_amount',
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
             * @param  \App\Models\Client  $client
             */
            \DB::connection('mysql3')->beginTransaction();
            try {
                $plant = Plant::find($model->plant);
                if ($plant) {
                    $accountingWzaccount = AccountingWzaccount::where('others', $plant->char_id)->first();
                    if ($accountingWzaccount) {
                        // Security Other Advance Group Head
                        $groupHeadAdvance = new AccountingGroup;
                        $groupHeadAdvance->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups_test');
                        $groupHeadAdvance->updateOrCreate(
                            [
                                'name' => "ONE MONTH ADVANCE - " . strtoupper($plant->name),
                                'parent_id' => '2'
                            ],
                            [
                                'affects_gross' => 0
                            ]
                        );

                        $dataGroupHeadAdvance = $groupHeadAdvance->where('name', "ONE MONTH ADVANCE - " . strtoupper($plant->name))
                            ->where('parent_id', 2)
                            ->first();

                        if ($dataGroupHeadAdvance) {
                            // Security Other Advance Ledger
                            $accountingLedger = new AccountingLedger();
                            $accountingLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers_test');
                            $accountingLedger->updateOrCreate(
                                [
                                    'group_id' => $dataGroupHeadAdvance->id,
                                    'name' => $model->business_name . ' - SEC',
                                    'code' => $model->client_char_id . '-SEC',
                                    'op_balance' => $model->closing_balance,
                                    'notes' => $model->business_name . ' - ' . strtoupper($plant->name),
                                ]
                            );
                        }


                        // Sundry Debtors Group Head
                        $groupHeadSundry = new AccountingGroup;
                        $groupHeadSundry->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'groups_test');
                        $groupHeadSundry->updateOrCreate(
                            [
                                'name' => 'Sundry Debtors',
                                'parent_id' => '1'
                            ],
                            [
                                'affects_gross' => 0
                            ]
                        );

                        $dataGroupHeadSundry = $groupHeadSundry->where('name', 'Sundry Debtors')
                            ->where('parent_id', 1)
                            ->first();

                        // Sundry Debtors Ledger
                        if ($dataGroupHeadSundry) {
                            $accountingSundryLedger = new AccountingLedger();
                            $accountingSundryLedger->setConnection('mysql3')->setTable($accountingWzaccount->db_prefix . 'ledgers_test');
                            $accountingSundryLedger->updateOrCreate(
                                [
                                    'group_id' => $dataGroupHeadSundry->id,
                                    'name' =>  $model->business_name,
                                    'code' =>  $model->client_char_id,
                                    'op_balance' => $model->closing_balance,
                                    'notes' => $model->business_name . ' - ' . strtoupper($plant->name),
                                ]
                            );
                        }
                    } else {
                        \DB::connection('mysql3')->rollBack();
                        throw new Exception("No accountingWzaccount found.");
                    }
                } else {
                    \DB::connection('mysql3')->rollBack();
                    throw new Exception("No plant found.");
                }
                \DB::connection('mysql3')->commit();
            } catch (\Exception $e) {
                \DB::connection('mysql3')->rollBack();
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
}
