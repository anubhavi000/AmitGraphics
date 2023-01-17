<?php

namespace App\Models;

use Exception;
use DB;
use App\Helpers\ConstantHelper;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    protected $table = "payment";


    protected $fillable = [
        'company_id',
        'char_id',
        'bulk_payment_id',
        'bank_name',
        'clearing_date',
        'is_inactive',
        'client',
        'security',
        'security_amount',
        'registration',
        'registration_amount',
        'is_previous_payment',
        'is_previous_payment_amount',
        'is_on_account',
        'is_on_account_payment',
        'cheque_no',
        'date',
        'bank_cheque',
        'amount',
        'transaction_no',
        'tds_amount',
        'status',
        'created_by',
        'updated_by',
        'narration',
        'payment_type',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            $model->created_by = $user->id;
            // dd($model);
            // dd($item_narraion);
            /**
             * Creating Ledger for accounting application
             *
             * @param  \App\Models\Payment  $model
             */
            \DB::beginTransaction();
            try {
                // DD($model);
                $bankInformation = BankInformation::find($model->bank_name);
                if ($bankInformation) {
                    if($model->payment_type == 'online_pharma_payment' || $model->payment_type == 'pharma_payment'){
                        // DD('1');
                        $client = PharmaClient::select('pharma_client.*','pharma_client.char_id as client_char_id')->find($model->client);
                    }else{
                        $client = Client::select('client.*','client_char_id')->find($model->client);
                    }
                    $plant = Plant::find($client ? $client->plant : null);
                    // dd($client);
                    if($model->payment_type == 'online'  || $model->payment_type == 'online_pharma_payment'){
                    // dd($model->payment_type,$model->narration);
                        $item_narraion = !empty($model->narration)?$model->narration:' ';
                        $item_narraion_entry = $item_narraion;
                        $item_narraion_res = 'REGISTRATION FEES for '.$client->business_name.','.$item_narraion;
                        // $item_narraion_res = 'REGISTRATION FEES for $client->business_name,'.$item_narraion;
                        $item_narraion_sec = $item_narraion.' FOR SECURITY';
                    }else{
                        // $bank_name_details = DB::table('bank_information_admin')->where('id',$model->bank_cheque)->first();
                        // $bank_name = !empty($bank_name_details->name)?$bank_name_details->name:'';
                        // $item_narraion_entry = 'Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no.' AGAINST CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date;
                        // $item_narraion = 'Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no.' AGAINST CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date. 'FOR '.$client->business_name;
                        
                        // $item_narraion_res = 'Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no.' REGISTRATION FEES for '.$client->business_name.', AGAINST CHEQUE NO.: '.$model->cheque_no .'AND CHEQUE DATE:'. $model->date;

                        // $item_narraion_sec = 'Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no.' AGAINST CHEQUE NO.: '.$model->cheque_no. 'AND CHEQUE DATE:'. $model->date. 'FOR SECURITY';


                        $bank_name_details = DB::table('bank_information_admin')->where('id',$model->bank_cheque)->first();
                        $bank_name = !empty($bank_name_details->name)?$bank_name_details->name:'';
                        $item_narraion_entry = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;
                        $item_narraion = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR '.$client->business_name;
                        
                        $item_narraion_res = ' REGISTRATION FEES for '.$client->business_name.', Chno.: '.$model->cheque_no .'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;

                        $item_narraion_sec = 'Chno.: '.$model->cheque_no. 'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR SECURITY';
                    }
                    // dd($plant && $client);
                    if ($plant && $client) {
                        // Reciept Entry
                        $number = date('ymd') . random_int(100000, 999999);

                        if ($model->registration_amount > 0) {
                            $accountingEntryNarration = $item_narraion_res;
                        } else {
                            $accountingEntryNarration = $item_narraion_entry;
                        }

                        $accountingEntry = AccountingEntry::create(
                            [
                                'entrytype_id' => 1, // Receipt (Received in Bank account or Cash account)
                                'is_locked' => 1,
                                'number' => $model->char_id,
                                'date' => $model->clearing_date,
                                'plant_char_id' => $plant->char_id,
                                'dr_total' => ($model->amount + $model->tds_amount),
                                'cr_total' => ($model->amount + $model->tds_amount),
                                'narration' => $accountingEntryNarration,
                            ]
                        );
                        // dd($accountingEntry);
                        if ($accountingEntry && $model->amount > 0) {
                            // Bank Account Debit
                            $accountingEntryItem = AccountingEntryItem::create(
                                [
                                    'entry_id' => $accountingEntry->id,
                                    'ledger_id' => $bankInformation->ledger_id,
                                    'dc' => 'D',
                                    'amount' => $model->amount,
                                    'morphable_id' => $model->id,
                                    'morphable_type' => 'Payment',
                                    'item_narration' => $item_narraion,
                                ]
                            );


                            // GET TDS (Receivable) LEDGER
                            $tdsAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::TDS_RECEIVABLE);
                                })->first();

                            if ($tdsAccountingLedger && $model->tds_amount > 0) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $tdsAccountingLedger->ledger_id,
                                        'dc' => 'D',
                                        'amount' => $model->tds_amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion,
                                    ]
                                );
                            }

                            // GET REGISTRATION FEES LEDGER
                            $registrationAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                ->whereHas('ledgerType', function ($q) {
                                    $q->where('name', ConstantHelper::REGISTRATION_FEE);
                                })->first();

                            if ($registrationAccountingLedger && $model->registration_amount > 0) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $registrationAccountingLedger->ledger_id,
                                        'dc' => 'C',
                                        'amount' => $model->registration_amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion_res,
                                    ]
                                );
                            }

                            // GET CLIENT SUNDRY DEBTORS LEDGER
                            $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
                            // dd($sundryAccountingLedger);

                            // PREVIOUS PAYMENT
                            if ($sundryAccountingLedger && $model->is_previous_payment_amount > 0) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $sundryAccountingLedger->id,
                                        'dc' => 'C',
                                        'amount' => $model->is_previous_payment_amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion,
                                    ]
                                );
                            }

                            // ON ACCOUNT
                            if ($sundryAccountingLedger && $model->is_on_account_payment > 0) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $sundryAccountingLedger->id,
                                        'dc' => 'C',
                                        'amount' => $model->is_on_account_payment,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion,
                                    ]
                                );
                            }

                            // BILL ADJUSTMENT TO CLINET SUNDRY DEBTORS LEDGER
                            $getAllBillAmount = AllBill::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                            $getAllBillAmount_final = ClientWiseBillPayment::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                            // dd($getAllBillAmount);
                            if ($getAllBillAmount > 0 && $sundryAccountingLedger) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $sundryAccountingLedger->id,
                                        'dc' => 'C',
                                        'amount' => $getAllBillAmount_final,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion,
                                    ]
                                );
                            }

                            // GET CLIENT SECURITY ACCOUNT LEDGER (ONE MONTH ADVANCE)
                            $securityAccountingLedger = AccountingLedger::where('code', $client->client_char_id . '-SEC')->first();

                            if ($securityAccountingLedger && $model->security_amount > 0) {
                                $accountingEntryItem->insert(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $securityAccountingLedger->id,
                                        'dc' => 'C',
                                        'amount' => $model->security_amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion_sec,
                                    ]
                                );
                            }
                            // dd($accountingEntryItem);
                        }
                    }
                }
                // dd('1');
                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new Exception($e->getMessage());
            }
        });

        static::updating(function ($model) {
            // dd($model);
            $user = \Auth::user();
            $model->updated_by = $user->id;

            \DB::beginTransaction();
            try {
                $accountingEntryDetails = AccountingEntry::where('number',$model->char_id)->pluck('id');
                // dd($accountingEntryDetails,$model->char_id);
                // $accountingEntryDetails = AccountingEntry::where('number',$model->char_id)->first();
                if(!empty($accountingEntryDetails)){
                    $deleteFromaccountingEntryDetails = AccountingEntryItem::whereIn('entry_id',$accountingEntryDetails)->delete();
                    $accountingEntry = AccountingEntry::where('number',$model->char_id)->delete();
    
                    if($accountingEntry && $deleteFromaccountingEntryDetails){
                        $bankInformation = BankInformation::find($model->bank_name);
                        if ($bankInformation) {
                            if($model->payment_type == 'online_pharma_payment' || $model->payment_type == 'pharma_payment'){
                                // DD('1');
                                $client = PharmaClient::select('pharma_client.*','pharma_client.char_id as client_char_id')->find($model->client);
                            }else{
                                $client = Client::select('client.*','client_char_id')->find($model->client);
                            }
                            $plant = Plant::find($client ? $client->plant : null);
                            // dd($client);
                            if($model->payment_type == 'online'  || $model->payment_type == 'online_pharma_payment'){
                            // dd($model->payment_type,$model->narration);
                                $item_narraion = !empty($model->narration)?$model->narration:' ';
                                $item_narraion_entry = $item_narraion;
                                $item_narraion_res = 'REGISTRATION FEES for '.$client->business_name.','.$item_narraion;
                                // $item_narraion_res = 'REGISTRATION FEES for $client->business_name,'.$item_narraion;
                                $item_narraion_sec = $item_narraion.' FOR SECURITY';
                            }else{
                                // $bank_name_details = DB::table('bank_information_admin')->where('id',$model->bank_cheque)->first();
                                // $bank_name = !empty($bank_name_details->name)?$bank_name_details->name:'';
                                // $item_narraion_entry = '  CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date.' Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no;
                                // $item_narraion = '  CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date. 'FOR '.$client->business_name.' Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no;
                                
                                // $item_narraion_res = 'REGISTRATION FEES for '.$client->business_name.',  CHEQUE NO.: '.$model->cheque_no .'AND CHEQUE DATE:'. $model->date.' Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no;

                                // $item_narraion_sec = 'FOR SECURITY CHEQUE NO.: '.$model->cheque_no. 'AND CHEQUE DATE:'. $model->date.' Bank Name:'.$bank_name.' Transaction No:'.$model->transaction_no;

                                $bank_name_details = DB::table('bank_information_admin')->where('id',$model->bank_cheque)->first();
                                $bank_name = !empty($bank_name_details->name)?$bank_name_details->name:'';
                                $item_narraion_entry = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;
                                $item_narraion = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR '.$client->business_name;
                                
                                $item_narraion_res = ' REGISTRATION FEES for '.$client->business_name.', Chno.: '.$model->cheque_no .'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;

                                $item_narraion_sec = 'Chno.: '.$model->cheque_no. 'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR SECURITY';
                            }
                            // dd($plant && $client);
                            if ($plant && $client) {
                                // Reciept Entry
                                $number = date('ymd') . random_int(100000, 999999);

                                if ($model->registration_amount > 0) {
                                    $accountingEntryNarration = $item_narraion_res;
                                } else {
                                    $accountingEntryNarration = $item_narraion_entry;
                                }

                                $accountingEntry = AccountingEntry::create(
                                    [
                                        'entrytype_id' => 1, // Receipt (Received in Bank account or Cash account)
                                        'is_locked' => 1,
                                        'number' => $model->char_id,
                                        'date' => $model->clearing_date,
                                        'plant_char_id' => $plant->char_id,
                                        'dr_total' => ($model->amount + $model->tds_amount),
                                        'cr_total' => ($model->amount + $model->tds_amount),
                                        'narration' => $accountingEntryNarration,
                                    ]
                                );
                                // dd($accountingEntry);
                                if ($accountingEntry && $model->amount > 0) {
                                    // Bank Account Debit
                                    $accountingEntryItem = AccountingEntryItem::create(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $bankInformation->ledger_id,
                                            'dc' => 'D',
                                            'amount' => $model->amount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion,
                                        ]
                                    );


                                    // GET TDS (Receivable) LEDGER
                                    $tdsAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::TDS_RECEIVABLE);
                                        })->first();

                                    if ($tdsAccountingLedger && $model->tds_amount > 0) {
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $tdsAccountingLedger->ledger_id,
                                                'dc' => 'D',
                                                'amount' => $model->tds_amount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion,
                                            ]
                                        );
                                    }

                                    // GET REGISTRATION FEES LEDGER
                                    $registrationAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                        ->whereHas('ledgerType', function ($q) {
                                            $q->where('name', ConstantHelper::REGISTRATION_FEE);
                                        })->first();

                                    if ($registrationAccountingLedger && $model->registration_amount > 0) {
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $registrationAccountingLedger->ledger_id,
                                                'dc' => 'C',
                                                'amount' => $model->registration_amount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion_res,
                                            ]
                                        );
                                    }

                                    // GET CLIENT SUNDRY DEBTORS LEDGER
                                    $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
                                    // dd($sundryAccountingLedger);

                                    // PREVIOUS PAYMENT
                                    if ($sundryAccountingLedger && $model->is_previous_payment_amount > 0) {
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $sundryAccountingLedger->id,
                                                'dc' => 'C',
                                                'amount' => $model->is_previous_payment_amount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion,
                                            ]
                                        );
                                    }

                                    // ON ACCOUNT
                                    if ($sundryAccountingLedger && $model->is_on_account_payment > 0) {
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $sundryAccountingLedger->id,
                                                'dc' => 'C',
                                                'amount' => $model->is_on_account_payment,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion,
                                            ]
                                        );
                                    }

                                    // BILL ADJUSTMENT TO CLINET SUNDRY DEBTORS LEDGER
                                    $getAllBillAmount = AllBill::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                                    $getAllBillAmount_final = ClientWiseBillPayment::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                                    // dd($getAllBillAmount);
                                    if ($getAllBillAmount_final > 0 && $sundryAccountingLedger) {
                                    // dd($getAllBillAmount_final,$client->client_char_id,$model->bulk_payment_id,$sundryAccountingLedger);
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $sundryAccountingLedger->id,
                                                'dc' => 'C',
                                                'amount' => $getAllBillAmount_final,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion,
                                            ]
                                        );
                                    }

                                    // GET CLIENT SECURITY ACCOUNT LEDGER (ONE MONTH ADVANCE)
                                    $securityAccountingLedger = AccountingLedger::where('code', $client->client_char_id . '-SEC')->first();

                                    if ($securityAccountingLedger && $model->security_amount > 0) {
                                        $accountingEntryItem->insert(
                                            [
                                                'entry_id' => $accountingEntry->id,
                                                'ledger_id' => $securityAccountingLedger->id,
                                                'dc' => 'C',
                                                'amount' => $model->security_amount,
                                                'morphable_id' => $model->id,
                                                'morphable_type' => 'Payment',
                                                'item_narration' => $item_narraion_sec,
                                            ]
                                        );
                                    }
                                    // dd($accountingEntryItem);
                                }
                            }
                        }
                                
                                
                       
                        \DB::commit();
                    }
                }else{
                    $bankInformation = BankInformation::find($model->bank_name);
                    if ($bankInformation) {
                        if($model->payment_type == 'online_pharma_payment' || $model->payment_type == 'pharma_payment'){
                            // DD('1');
                            $client = PharmaClient::select('pharma_client.*','pharma_client.char_id as client_char_id')->find($model->client);
                        }else{
                            $client = Client::select('client.*','client_char_id')->find($model->client);
                        }
                        $plant = Plant::find($client ? $client->plant : null);
                        // dd($client);
                        if($model->payment_type == 'online'  || $model->payment_type == 'online_pharma_payment'){
                        // dd($model->payment_type,$model->narration);
                            $item_narraion = !empty($model->narration)?$model->narration:' ';
                            $item_narraion_entry = $item_narraion;
                            $item_narraion_res = 'REGISTRATION FEES for '.$client->business_name.','.$item_narraion;
                            // $item_narraion_res = 'REGISTRATION FEES for $client->business_name,'.$item_narraion;
                            $item_narraion_sec = $item_narraion.' FOR SECURITY';
                        }else{
                            // $item_narraion_entry = 'AGAINST CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date;
                            // $item_narraion = 'AGAINST CHEQUE NO.: '.$model->cheque_no.' AND CHEQUE DATE:'. $model->date. 'FOR '.$client->business_name;
                            
                            // $item_narraion_res = 'REGISTRATION FEES for '.$client->business_name.', AGAINST CHEQUE NO.: '.$model->cheque_no .'AND CHEQUE DATE:'. $model->date;

                            // $item_narraion_sec = 'AGAINST CHEQUE NO.: '.$model->cheque_no. 'AND CHEQUE DATE:'. $model->date. 'FOR SECURITY';

                            $bank_name_details = DB::table('bank_information_admin')->where('id',$model->bank_cheque)->first();
                            $bank_name = !empty($bank_name_details->name)?$bank_name_details->name:'';
                            $item_narraion_entry = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;
                            $item_narraion = ' Chno.: '.$model->cheque_no.' AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR '.$client->business_name;
                            
                            $item_narraion_res = ' REGISTRATION FEES for '.$client->business_name.', Chno.: '.$model->cheque_no .'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no;

                            $item_narraion_sec = 'Chno.: '.$model->cheque_no. 'AND ch dt:'. $model->date.' '.$bank_name.' '.$model->transaction_no. 'FOR SECURITY';
                        }
                        // dd($plant && $client);
                        if ($plant && $client) {
                            // Reciept Entry
                            $number = date('ymd') . random_int(100000, 999999);

                            if ($model->registration_amount > 0) {
                                $accountingEntryNarration = $item_narraion_res;
                            } else {
                                $accountingEntryNarration = $item_narraion_entry;
                            }

                            $accountingEntry = AccountingEntry::create(
                                [
                                    'entrytype_id' => 1, // Receipt (Received in Bank account or Cash account)
                                    'is_locked' => 1,
                                    'number' => $model->char_id,
                                    'date' => $model->clearing_date,
                                    'plant_char_id' => $plant->char_id,
                                    'dr_total' => ($model->amount + $model->tds_amount),
                                    'cr_total' => ($model->amount + $model->tds_amount),
                                    'narration' => $accountingEntryNarration,
                                ]
                            );
                            // dd($accountingEntry);
                            if ($accountingEntry && $model->amount > 0) {
                                // Bank Account Debit
                                $accountingEntryItem = AccountingEntryItem::create(
                                    [
                                        'entry_id' => $accountingEntry->id,
                                        'ledger_id' => $bankInformation->ledger_id,
                                        'dc' => 'D',
                                        'amount' => $model->amount,
                                        'morphable_id' => $model->id,
                                        'morphable_type' => 'Payment',
                                        'item_narration' => $item_narraion,
                                    ]
                                );


                                // GET TDS (Receivable) LEDGER
                                $tdsAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::TDS_RECEIVABLE);
                                    })->first();

                                if ($tdsAccountingLedger && $model->tds_amount > 0) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $tdsAccountingLedger->ledger_id,
                                            'dc' => 'D',
                                            'amount' => $model->tds_amount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion,
                                        ]
                                    );
                                }

                                // GET REGISTRATION FEES LEDGER
                                $registrationAccountingLedger = PlantConfiguration::where('plant_id', $plant->id)
                                    ->whereHas('ledgerType', function ($q) {
                                        $q->where('name', ConstantHelper::REGISTRATION_FEE);
                                    })->first();

                                if ($registrationAccountingLedger && $model->registration_amount > 0) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $registrationAccountingLedger->ledger_id,
                                            'dc' => 'C',
                                            'amount' => $model->registration_amount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion_res,
                                        ]
                                    );
                                }

                                // GET CLIENT SUNDRY DEBTORS LEDGER
                                $sundryAccountingLedger = AccountingLedger::where('code', $client->client_char_id)->first();
                                // dd($sundryAccountingLedger);

                                // PREVIOUS PAYMENT
                                if ($sundryAccountingLedger && $model->is_previous_payment_amount > 0) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $sundryAccountingLedger->id,
                                            'dc' => 'C',
                                            'amount' => $model->is_previous_payment_amount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion,
                                        ]
                                    );
                                }

                                // ON ACCOUNT
                                if ($sundryAccountingLedger && $model->is_on_account_payment > 0) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $sundryAccountingLedger->id,
                                            'dc' => 'C',
                                            'amount' => $model->is_on_account_payment,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion,
                                        ]
                                    );
                                }

                                // BILL ADJUSTMENT TO CLINET SUNDRY DEBTORS LEDGER
                                $getAllBillAmount = AllBill::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                                $getAllBillAmount_final = ClientWiseBillPayment::where('payment_char_id', $model->bulk_payment_id)->where('client_char_id',$client->client_char_id)->sum('paid_amount');
                                // dd($getAllBillAmount);
                                if ($getAllBillAmount > 0 && $sundryAccountingLedger) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $sundryAccountingLedger->id,
                                            'dc' => 'C',
                                            'amount' => $getAllBillAmount_final,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion,
                                        ]
                                    );
                                }

                                // GET CLIENT SECURITY ACCOUNT LEDGER (ONE MONTH ADVANCE)
                                $securityAccountingLedger = AccountingLedger::where('code', $client->client_char_id . '-SEC')->first();

                                if ($securityAccountingLedger && $model->security_amount > 0) {
                                    $accountingEntryItem->insert(
                                        [
                                            'entry_id' => $accountingEntry->id,
                                            'ledger_id' => $securityAccountingLedger->id,
                                            'dc' => 'C',
                                            'amount' => $model->security_amount,
                                            'morphable_id' => $model->id,
                                            'morphable_type' => 'Payment',
                                            'item_narration' => $item_narraion_sec,
                                        ]
                                    );
                                }
                                // dd($accountingEntryItem);
                            }
                        }
                    }
                        \DB::commit();
                    
                }
               
            } catch (\Exception $e) {
                \DB::rollBack();
                throw new Exception($e->getMessage());
            }

        });
    }
}
