<?php

namespace App\Models;

use Exception;
use DB;
use App\Helpers\ConstantHelper;
use Illuminate\Database\Eloquent\Model;

class AllBill extends Model
{
    protected $fillable = [
        'company_id',
        'char_id',
        'client_id',
        'client_name',
        'client_address',
        'client_char_id',
        'plant_id',
        'route_id',
        'billing_type',
        'total_collection',
        'month',
        'amount',
        'pending_amount',
        'billing_date',
        'is_custom_bill',
        'is_pharma_bill',
        'print_arrear_on_bill',
        'pharma_waste_id',
        'from_date',
        'to_date',
        'narration',
        'status',
        'created_at',
        'updated_at',   
        'created_by',
        'updated_by',
        'payment_char_id',
        'paid_amount',
        'payment_date',
        'bill_no',
        'bill_series',
        'igst',
        'weight_limit',
        'rate',
        'excess_rate',
        'total_bed',
        'cgst',
        'sgst',
        'sgst_perc',
        'cgst_perc',
        'igst_perc',
        'after_gst_amount',
        'bill_pdf_name',
        'bill_fixed_amount',
        'arrear_value',
        'bulk_pdf_name',
        'bulk_char_id',
        'is_bulk_bill',
        'is_gst_json_generated',
        'gst_file_name',
        'irn_no' ,
        'updated_by',
        'updated_at',
        'mail_send_status',
        'mail_send_date_time',
        'whatsapp_send_status',
        'whatsapp_send_date_time',
        'whatspp_response',

    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            $model->created_by = $user->id;
            // dd($model);

            /**
             * Creating Ledger for accounting application
             *
             * @param  \App\Models\AllBill $model
             */

            \DB::beginTransaction();
            try {
                $plant = Plant::find($model->plant_id);
                // dd($model);
                if($model->is_pharma_bill == '1'){
                    $client = PharmaClient::select('is_gst_applicable as maximum_weight_gst_applicable','char_id as client_char_id','contact_state as state1')->find($model->client_id);
                }else{
                    $client = Client::select('is_gst_applicable as maximum_weight_gst_applicable','client_char_id','state1','cgst','sgst','igst')->find($model->client_id);
                }
                // dd($client);

                $SGSTtaxableAmount = 0;
                $CGSTtaxableAmount = 0;
                $IGSTtaxableAmount = 0;
                $totalTaxAmt = 0;

                if ($plant && $client) {
                    // Journal Entry || 'entrytype_id' => 4 = Journal (Transaction that does not involve a Bank account or Cash account)
                    $number = date('ymd') . random_int(100000, 999999);
                    $accountingEntry = AccountingEntry::create(
                        [
                            'entrytype_id' => 4,
                            'is_locked' => 1,
                            'number' => $model->char_id,
                            'plant_char_id' => $plant->char_id,
                            'date' => $model->billing_date,
                            'dr_total' => $model->amount,
                            'cr_total' => $model->amount,
                            'narration' => "AGAINST BILL NO.:".$model->bill_no,
                        ]
                    );

                    if ($accountingEntry) {
                        // Bank Account Debit
                        if ($client->maximum_weight_gst_applicable == 1) {
                            // If client->state1 == plant->state then CGST(9%) & SGST(9%) will be applied.
                            // Else IGST(18%) will be applied.
                            // dd($client->state1 , $plant->state);
                            if ($client->state1 == $plant->state) {
                                if(!empty($client->igst)){
                                    $IGSTpercentage = 0;
                                    if($model->is_pharma_bill == '1'){

                                        $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::IGST);
                                        })->first();

                                        $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                        $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                        $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                    }else{
                                      
                                        $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*','percentage_hcf as percentage')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::IGST);
                                        })->first();

                                        if(!empty($client->igst)){
                                            if($client->igst != 0){
                                                $IGSTpercentage = $client->igst;
                                            }
                                        }else{
                                            $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                        }
                                        $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                        $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                    }
                                    



                                    if ($IGSTAccountingLedger && $IGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $IGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $IGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR IGST",
                                            ]
                                        );
                                    }
                                }else{

                                    // FIND CGST LEDGER in DUTIES & TAXES GROUP
                                    if($model->is_pharma_bill == '1'){
                                        // $client = PharmaClient::select('is_gst_applicable as maximum_weight_gst_applicable','char_id as client_char_id','contact_state as state1')->find($model->client_id);
                                        $CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                            ->select('plant_configurations.*')
                                            ->whereHas('ledgerType', function ($q) {
                                                $q->where('name', ConstantHelper::CGST);
                                            })->first();

                                        $CGSTpercentage = $CGSTAccountingLedger ? $CGSTAccountingLedger->percentage : 9;
                                        $CGSTtotalAmount = $model->amount * ((100 - $CGSTpercentage) / 100);
                                        $CGSTtaxableAmount = ($model->amount - $CGSTtotalAmount);

                                    }else{
                                        // $client = Client::select('is_gst_applicable as maximum_weight_gst_applicable','client_char_id','state1')->find($model->client_id);
                                        $CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                            ->select('plant_configurations.*','percentage_hcf as percentage')
                                            ->whereHas('ledgerType', function ($q) {
                                                $q->where('name', ConstantHelper::CGST);
                                            })->first();

                                        if(!empty($client->cgst)){
                                            if($client->cgst != 0){
                                                $CGSTpercentage = $client->cgst;
                                            }
                                        }elsE{

                                            $CGSTpercentage = $CGSTAccountingLedger ? $CGSTAccountingLedger->percentage : 9;
                                        }
                                        $CGSTtotalAmount = $model->amount * ((100 - $CGSTpercentage) / 100);
                                        $CGSTtaxableAmount = ($model->amount - $CGSTtotalAmount);
                                    }


                                    // dd($CGSTpercentage);
                                    if ($CGSTAccountingLedger && $CGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $CGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $CGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR CGST",
                                            ]
                                        );
                                    }

                                    // FIND SGST LEDGER in DUTIES & TAXES GROUP

                                    if($model->is_pharma_bill == '1'){

                                        $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::SGST);
                                        })->first();

                                        $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        $SGSTtotalAmount = $model->amount * ((100 - $SGSTpercentage) / 100);
                                        $SGSTtaxableAmount = ($model->amount - $SGSTtotalAmount);

                                    }else{
                                      
                                        $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*','percentage_hcf as percentage')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::SGST);
                                        })->first();


                                        if(!empty($client->sgst)){
                                            if($client->sgst != 0){
                                                $SGSTpercentage = $client->sgst;
                                            }
                                        }elsE{

                                            $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        }
                                        // $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        $SGSTtotalAmount = $model->amount * ((100 - $SGSTpercentage) / 100);
                                        $SGSTtaxableAmount = ($model->amount - $SGSTtotalAmount);
                                    }
                                    

                                    

                                    if ($SGSTAccountingLedger && $SGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $SGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $SGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR SGST",
                                            ]
                                        );
                                    }
                                }
                            } else {

                                // FIND IGST LEDGER in DUTIES & TAXES GROUP

                                if($model->is_pharma_bill == '1'){

                                    $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->select('plant_configurations.*')
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::IGST);
                                    })->first();

                                    $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                    $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                    $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                }else{
                                  
                                    $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->select('plant_configurations.*','percentage_hcf as percentage')
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::IGST);
                                    })->first();

                                    if(!empty($client->igst)){
                                        if($client->igst != 0){
                                            $IGSTpercentage = $client->igst;
                                        }
                                    }else{
                                        $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                    }
                                    $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                    $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                }
                                



                                if ($IGSTAccountingLedger && $IGSTtaxableAmount > 0) {
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $IGSTAccountingLedger->ledger_id,
                                            'dc' => 'C',
                                            'amount' => $IGSTtaxableAmount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR IGST",
                                        ]
                                    );
                                }
                            }

                            // GET Waste Treatment Charges Lucknow (Taxable) LEDGER
                            $wasteTreatmentAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::INCOME_ACCOUNT_TAXABLE_SERVICE);
                                })->first();

                            $totalAmount = ($SGSTtaxableAmount + $CGSTtaxableAmount + $IGSTtaxableAmount);
                            $totalTaxAmt = (round($SGSTtaxableAmount,2) + round($CGSTtaxableAmount,2) + round($IGSTtaxableAmount,2));
                            if ($wasteTreatmentAccountingLedger && $totalAmount > 0) {
                                AccountingEntryItem::create(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $wasteTreatmentAccountingLedger->ledger_id,
                                        'dc' => 'C',
                                        'amount' => $model->amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'AllBill',
                                        'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                    ]
                                );
                            }
                        } else {
                            $totalAmount = $model->amount;
                            // GET Waste Treatment Charges Lucknow (Exempt) LEDGER
                            $wasteExemptAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::INCOME_ACCOUNT_NON_TAXABLE_SERVICE);
                                })->first();

                            if ($wasteExemptAccountingLedger && $totalAmount > 0) {
                                AccountingEntryItem::create(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $wasteExemptAccountingLedger->ledger_id,
                                        'dc' => 'C',
                                        'amount' => $totalAmount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'AllBill',
                                        'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                    ]
                                );
                            }
                        }

                        // GET CLIENT SUNDRY DEBTORS LEDGER
                        $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
                        
                        $total_final_amout_step1 = explode('.',$model->amount+$totalTaxAmt);
                        

                        if ($sundryAccountingLedger && $model->amount > 0) {
                            
                            if(COUNT($total_final_amout_step1) == 2){
                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                if($point_val_cond>=0.5){
                                    $acc_finalAmoutn = ($total_final_amout_step1[0])+1;
                                }else{
                                    $acc_finalAmoutn = $total_final_amout_step1[0];
                                }
                            }else{
                                $acc_finalAmoutn = $model->amount+$totalTaxAmt;
                            }
                            AccountingEntryItem::create(
                                [
                                    'entry_id' => $accountingEntry->id,
                                    'ledger_id' => $sundryAccountingLedger->id,
                                    'dc' => 'D',
                                    'amount' => $acc_finalAmoutn,
                                    'morphable_id' => $model->id,
                                    'morphable_type' => 'AllBill',
                                    'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                ]
                            );

                            // dd($total_final_amout_step1);
                            if(COUNT($total_final_amout_step1) == 2){

                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                // dd($total_final_amout_step1);
                                $roundOffLedgerDetail = PlantConfiguration::where('plant_id', $plant->id)
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::ROUND_OFF);
                                    })->first();

                                if($point_val_cond>=0.5){
                                // dd($point_val_cond);

                                    
                                    $round_value = '0.'.$total_final_amout_step1[1];
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $roundOffLedgerDetail->ledger_id,
                                            'dc' => 'C',
                                            'amount' => 1-$round_value,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                        ]
                                    );
                                   

                                    $total_final_amout = $total_final_amout_step1[0]+1;
                                }else{
                                    // dd($total_final_amout_step1);
                                    
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $roundOffLedgerDetail->ledger_id,
                                            'dc' => 'D',
                                            'amount' => '0.'.$total_final_amout_step1[1],
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                        ]
                                    );
                                    

                                    // $total_final_amout = $total_final_amout_step1[0];
                                }
                            }else{
                                // $total_final_amout = $model->amount+$totalTaxAmt;
                            }


                            if(COUNT($total_final_amout_step1) == 2){
                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                if($point_val_cond>=0.5){
                                    $final_debit_total = ($total_final_amout_step1[0])+1;
                                    $credit_round = 1-$round_value;
                                    $debit_value = 0;
                                }else{
                                    $final_debit_total = $total_final_amout_step1[0];
                                    $debit_value = $point_val_cond;
                                    $credit_round = 0;
                                }
                            }else{
                                $final_debit_total = $model->amount+$totalTaxAmt;
                                $credit_round = 0;
                                $debit_value = 0;
                            }

                            AccountingEntry::where('id',$accountingEntry->id)->update([
                                'dr_total' => $final_debit_total+$debit_value,
                                'cr_total' => $model->amount+$totalTaxAmt+$credit_round,
                            ]);
                            $char_id_cus = $model->char_id;
                            $total_amount_with_gst_amount= $model->amount+$totalTaxAmt;
                            $model->igst = !empty($IGSTtaxableAmount)?round($IGSTtaxableAmount,2):'0';
                            $model->cgst = !empty($CGSTtaxableAmount)?round($CGSTtaxableAmount,2):'0';
                            $model->sgst = !empty($SGSTtaxableAmount)?round($SGSTtaxableAmount,2):'0';
                            $model->igst_perc = !empty($IGSTpercentage)?$IGSTpercentage:'0';
                            $model->cgst_perc = !empty($CGSTpercentage)?$CGSTpercentage:'0';
                            $model->sgst_perc = !empty($SGSTpercentage)?$SGSTpercentage:'0';
                            $model->after_gst_amount = $totalTaxAmt;
                            $model->pending_amount = $total_amount_with_gst_amount;
                            // $model->save();

                            // dd($details_update,$model->char_id,$IGSTtaxableAmount,$CGSTtaxableAmount,$SGSTtaxableAmount,$IGSTpercentage,$totalTaxAmt);
                            // dd($details_update);
                        }
                    }
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new Exception($e->getMessage());
            }
        });

        static::updating(function ($model) {
            $user = \Auth::user();
            $model->updated_by = $user->id;

            \DB::beginTransaction();
            try {
                $accountingEntryDetails = AccountingEntry::where('number',$model->char_id)->pluck('id')->toArray();
                $deleteFromaccountingEntryDetails = AccountingEntryItem::whereIn('entry_id',$accountingEntryDetails)->delete();
                $accountingEntry_delete = AccountingEntry::where('number',$model->char_id)->delete();

                $plant = Plant::find($model->plant_id);
                // dd($model);
                if($model->is_pharma_bill == '1'){
                    $client = PharmaClient::select('is_gst_applicable as maximum_weight_gst_applicable','char_id as client_char_id','contact_state as state1')->find($model->client_id);
                }else{
                    $client = Client::select('is_gst_applicable as maximum_weight_gst_applicable','client_char_id','state1','cgst','sgst','igst')->find($model->client_id);
                }
                // dd($client);

                $SGSTtaxableAmount = 0;
                $CGSTtaxableAmount = 0;
                $IGSTtaxableAmount = 0;
                $totalTaxAmt = 0;

                if ($plant && $client) {
                    // Journal Entry || 'entrytype_id' => 4 = Journal (Transaction that does not involve a Bank account or Cash account)
                    $number = date('ymd') . random_int(100000, 999999);
                    $accountingEntry = AccountingEntry::create(
                        [
                            'entrytype_id' => 4,
                            'is_locked' => 1,
                            'number' => $model->char_id,
                            'plant_char_id' => $plant->char_id,
                            'date' => $model->billing_date,
                            'dr_total' => $model->amount,
                            'cr_total' => $model->amount,
                            'narration' => "AGAINST BILL NO.:".$model->bill_no,
                        ]
                    );

                    if ($accountingEntry) {
                        // Bank Account Debit
                        if ($client->maximum_weight_gst_applicable == 1) {
                            // If client->state1 == plant->state then CGST(9%) & SGST(9%) will be applied.
                            // Else IGST(18%) will be applied.
                            // dd($client->state1 , $plant->state);
                            if ($client->state1 == $plant->state) {
                                if(!empty($client->igst)){
                                    $IGSTpercentage = 0;
                                    if($model->is_pharma_bill == '1'){

                                        $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::IGST);
                                        })->first();

                                        $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                        $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                        $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                    }else{
                                      
                                        $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*','percentage_hcf as percentage')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::IGST);
                                        })->first();

                                        if(!empty($client->igst)){
                                            if($client->igst != 0){
                                                $IGSTpercentage = $client->igst;
                                            }
                                        }else{
                                            $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                        }
                                        $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                        $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                    }
                                    



                                    if ($IGSTAccountingLedger && $IGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $IGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $IGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR IGST",
                                            ]
                                        );
                                    }
                                }else{

                                    // FIND CGST LEDGER in DUTIES & TAXES GROUP
                                    if($model->is_pharma_bill == '1'){
                                        // $client = PharmaClient::select('is_gst_applicable as maximum_weight_gst_applicable','char_id as client_char_id','contact_state as state1')->find($model->client_id);
                                        $CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                            ->select('plant_configurations.*')
                                            ->whereHas('ledgerType', function ($q) {
                                                $q->where('name', ConstantHelper::CGST);
                                            })->first();

                                        $CGSTpercentage = $CGSTAccountingLedger ? $CGSTAccountingLedger->percentage : 9;
                                        $CGSTtotalAmount = $model->amount * ((100 - $CGSTpercentage) / 100);
                                        $CGSTtaxableAmount = ($model->amount - $CGSTtotalAmount);

                                    }else{
                                        // $client = Client::select('is_gst_applicable as maximum_weight_gst_applicable','client_char_id','state1')->find($model->client_id);
                                        $CGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                            ->select('plant_configurations.*','percentage_hcf as percentage')
                                            ->whereHas('ledgerType', function ($q) {
                                                $q->where('name', ConstantHelper::CGST);
                                            })->first();

                                        if(!empty($client->cgst)){
                                            if($client->cgst != 0){
                                                $CGSTpercentage = $client->cgst;
                                            }
                                        }elsE{

                                            $CGSTpercentage = $CGSTAccountingLedger ? $CGSTAccountingLedger->percentage : 9;
                                        }
                                        $CGSTtotalAmount = $model->amount * ((100 - $CGSTpercentage) / 100);
                                        $CGSTtaxableAmount = ($model->amount - $CGSTtotalAmount);
                                    }


                                    // dd($CGSTpercentage);
                                    if ($CGSTAccountingLedger && $CGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $CGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $CGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR CGST",
                                            ]
                                        );
                                    }

                                    // FIND SGST LEDGER in DUTIES & TAXES GROUP

                                    if($model->is_pharma_bill == '1'){

                                        $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::SGST);
                                        })->first();

                                        $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        $SGSTtotalAmount = $model->amount * ((100 - $SGSTpercentage) / 100);
                                        $SGSTtaxableAmount = ($model->amount - $SGSTtotalAmount);

                                    }else{
                                      
                                        $SGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->select('plant_configurations.*','percentage_hcf as percentage')
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::SGST);
                                        })->first();


                                        if(!empty($client->sgst)){
                                            if($client->sgst != 0){
                                                $SGSTpercentage = $client->sgst;
                                            }
                                        }elsE{

                                            $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        }
                                        // $SGSTpercentage = $SGSTAccountingLedger ? $SGSTAccountingLedger->percentage : 9;
                                        $SGSTtotalAmount = $model->amount * ((100 - $SGSTpercentage) / 100);
                                        $SGSTtaxableAmount = ($model->amount - $SGSTtotalAmount);
                                    }
                                    

                                    

                                    if ($SGSTAccountingLedger && $SGSTtaxableAmount > 0) {
                                        AccountingEntryItem::create(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $SGSTAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $SGSTtaxableAmount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'AllBill',
                                                'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR SGST",
                                            ]
                                        );
                                    }
                                }
                            } else {

                                // FIND IGST LEDGER in DUTIES & TAXES GROUP

                                if($model->is_pharma_bill == '1'){

                                    $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->select('plant_configurations.*')
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::IGST);
                                    })->first();

                                    $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                    $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                    $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                }else{
                                  
                                    $IGSTAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->select('plant_configurations.*','percentage_hcf as percentage')
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::IGST);
                                    })->first();

                                    if(!empty($client->igst)){
                                        if($client->igst != 0){
                                            $IGSTpercentage = $client->igst;
                                        }
                                    }else{
                                        $IGSTpercentage = $IGSTAccountingLedger ? $IGSTAccountingLedger->percentage : 18;
                                    }
                                    $IGSTtotalAmount = $model->amount * ((100 - $IGSTpercentage) / 100);
                                    $IGSTtaxableAmount = ($model->amount - $IGSTtotalAmount);
                                }
                                



                                if ($IGSTAccountingLedger && $IGSTtaxableAmount > 0) {
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $IGSTAccountingLedger->ledger_id,
                                            'dc' => 'C',
                                            'amount' => $IGSTtaxableAmount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date FOR IGST",
                                        ]
                                    );
                                }
                            }

                            // GET Waste Treatment Charges Lucknow (Taxable) LEDGER
                            $wasteTreatmentAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::INCOME_ACCOUNT_TAXABLE_SERVICE);
                                })->first();

                            $totalAmount = ($SGSTtaxableAmount + $CGSTtaxableAmount + $IGSTtaxableAmount);
                            $totalTaxAmt = (round($SGSTtaxableAmount,2) + round($CGSTtaxableAmount,2) + round($IGSTtaxableAmount,2));
                            if ($wasteTreatmentAccountingLedger && $totalAmount > 0) {
                                AccountingEntryItem::create(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $wasteTreatmentAccountingLedger->ledger_id,
                                        'dc' => 'C',
                                        'amount' => $model->amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'AllBill',
                                        'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                    ]
                                );
                            }
                        } else {
                            $totalAmount = $model->amount;
                            // GET Waste Treatment Charges Lucknow (Exempt) LEDGER
                            $wasteExemptAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::INCOME_ACCOUNT_NON_TAXABLE_SERVICE);
                                })->first();

                            if ($wasteExemptAccountingLedger && $totalAmount > 0) {
                                AccountingEntryItem::create(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $wasteExemptAccountingLedger->ledger_id,
                                        'dc' => 'C',
                                        'amount' => $totalAmount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'AllBill',
                                        'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                    ]
                                );
                            }
                        }

                        // GET CLIENT SUNDRY DEBTORS LEDGER
                        $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
                        
                        $total_final_amout_step1 = explode('.',$model->amount+$totalTaxAmt);
                        

                        if ($sundryAccountingLedger && $model->amount > 0) {
                            
                            if(COUNT($total_final_amout_step1) == 2){
                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                if($point_val_cond>=0.5){
                                    $acc_finalAmoutn = ($total_final_amout_step1[0])+1;
                                }else{
                                    $acc_finalAmoutn = $total_final_amout_step1[0];
                                }
                            }else{
                                $acc_finalAmoutn = $model->amount+$totalTaxAmt;
                            }
                            AccountingEntryItem::create(
                                [
                                    'entry_id' => $accountingEntry->id,
                                    'ledger_id' => $sundryAccountingLedger->id,
                                    'dc' => 'D',
                                    'amount' => $acc_finalAmoutn,
                                    'morphable_id' => $model->id,
                                    'morphable_type' => 'AllBill',
                                    'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                ]
                            );

                            // dd($total_final_amout_step1);
                            if(COUNT($total_final_amout_step1) == 2){

                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                // dd($total_final_amout_step1);
                                $roundOffLedgerDetail = PlantConfiguration::where('plant_id', $plant->id)
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::ROUND_OFF);
                                    })->first();

                                if($point_val_cond>=0.5){
                                // dd($point_val_cond);

                                    
                                    $round_value = '0.'.$total_final_amout_step1[1];
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $roundOffLedgerDetail->ledger_id,
                                            'dc' => 'C',
                                            'amount' => 1-$round_value,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                        ]
                                    );
                                   

                                    $total_final_amout = $total_final_amout_step1[0]+1;
                                }else{
                                    // dd($total_final_amout_step1);
                                    
                                    AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $roundOffLedgerDetail->ledger_id,
                                            'dc' => 'D',
                                            'amount' => '0.'.$total_final_amout_step1[1],
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'AllBill',
                                            'item_narration' => "AGAINST BILL NO.: $model->bill_no AND BILL DATE: $model->billing_date ",
                                        ]
                                    );
                                    

                                    // $total_final_amout = $total_final_amout_step1[0];
                                }
                            }else{
                                // $total_final_amout = $model->amount+$totalTaxAmt;
                            }


                            if(COUNT($total_final_amout_step1) == 2){
                                $point_val_cond = '0.'.$total_final_amout_step1[1];
                                if($point_val_cond>=0.5){
                                    $final_debit_total = ($total_final_amout_step1[0])+1;
                                    $credit_round = 1-$round_value;
                                    $debit_value = 0;
                                }else{
                                    $final_debit_total = $total_final_amout_step1[0];
                                    $debit_value = $point_val_cond;
                                    $credit_round = 0;
                                }
                            }else{
                                $final_debit_total = $model->amount+$totalTaxAmt;
                                $credit_round = 0;
                                $debit_value = 0;
                            }

                            AccountingEntry::where('id',$accountingEntry->id)->update([
                                'dr_total' => $final_debit_total+$debit_value,
                                'cr_total' => $model->amount+$totalTaxAmt+$credit_round,
                            ]);
                            $char_id_cus = $model->char_id;
                            $total_amount_with_gst_amount= $model->amount+$totalTaxAmt;
                            $model->igst = !empty($IGSTtaxableAmount)?round($IGSTtaxableAmount,2):'0';
                            $model->cgst = !empty($CGSTtaxableAmount)?round($CGSTtaxableAmount,2):'0';
                            $model->sgst = !empty($SGSTtaxableAmount)?round($SGSTtaxableAmount,2):'0';
                            $model->igst_perc = !empty($IGSTpercentage)?$IGSTpercentage:'0';
                            $model->cgst_perc = !empty($CGSTpercentage)?$CGSTpercentage:'0';
                            $model->sgst_perc = !empty($SGSTpercentage)?$SGSTpercentage:'0';
                            $model->after_gst_amount = $totalTaxAmt;
                            $model->pending_amount = $total_amount_with_gst_amount;
                            // $model->save();

                            // dd($details_update,$model->char_id,$IGSTtaxableAmount,$CGSTtaxableAmount,$SGSTtaxableAmount,$IGSTpercentage,$totalTaxAmt);
                            // dd($details_update);
                        }
                    }
                }
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new Exception($e->getMessage());
            }
        });
    }
    public function route_rel(){
        $this->belongsTo(Route::class,'id','route_id');
    }
}
