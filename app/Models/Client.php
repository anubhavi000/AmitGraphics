<?php

namespace App\Models;
use DB;
use App\Models\AllBill;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';

    protected $fillable = [
        'id',
        'company_id',
        'closing_balance',
        'sec_closing_balance',
        'client_char_id',
        'client_sec_char_id',
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
        'discontinue_date',
        'is_gst_applicable',
        'lat',
        'lng',
        'track_addr',
    ];


    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            // dd($model);
            $model->created_by = $user->id;
            $model->client_sec_char_id = $model->client_char_id . '-SEC';
            /**
             * Creating Ledger for accounting application
             *
             * @param  \App\Models\Client  $client
             */
            \DB::beginTransaction();
            try {
                $plant = Plant::find($model->plant);
                if ($plant) {
                    // TYPE 9 = SECURITY ACCOUNT & TYPE = 10 SUNDRY DEBTORS ACCOUNT
                    // Security One Month Advance Group Head
                    // OMA =  One Month Advance
                    $securityGroupHead = AccountingGroup::where("code", "OMA-$plant->char_id")->first();
                    if ($securityGroupHead) {
                        // Add Security One Month Advance Ledger
                        AccountingLedger::create(
                            [
                                'type' => 9,
                                'group_id' => $securityGroupHead->id,
                                'name' => $model->business_name . ' - SEC',
                                'code' => $model->client_char_id . '-SEC',
                                'plant_char_id' => $plant->char_id,
                                'op_balance' => $model->sec_closing_balance ? $model->sec_closing_balance : 0,
                                'notes' => $model->business_name . ' - ' . strtoupper($plant->name),
                            ]
                        );
                    }

                        // dd($model->client_char_id);
                    // SD = Sundry Debtors
                    $sundryGroupHead = AccountingGroup::where("code", "SD-$plant->char_id")->first();
                    if ($sundryGroupHead) {
                        // Add Sundry Debtors Ledger
                        AccountingLedger::create(
                            [
                                'type' => 10,
                                'group_id' => $sundryGroupHead->id,
                                'name' =>  $model->business_name,
                                'code' =>  $model->client_char_id,
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
            $model->updated_by = !empty($user->id)?$user->id:'33';
        });
    }

    public function plantList()
    {
        return $this->belongsTo(Module::class,  'module_id');
    }
    public function clientDistrict()
    {
        return $this->belongsTo(District::class,  'district1');
    }
    public static function  partyCurrentOutstanding($client_char_id,$type){
        $final_outstanding = 0;
        $get_dc_amount = 0;
        $get_cr_amount = 0;
        if($type == 'sec' || $type == 'SEC'){
            $client_char_id = $client_char_id.'-SEC';
        }
        $get_op_val = AccountingLedger::where('code',$client_char_id)->first();
        // dd($get_op_val);
        if(isset($get_op_val) && !empty($get_op_val->id)){
            $get_dc_amount = AccountingEntryItem::where('ledger_id',$get_op_val->id)->where('dc','D')->sum("amount");
            $get_cr_amount = AccountingEntryItem::where('ledger_id',$get_op_val->id)->where('dc','C')->sum("amount");
            // dd($get_cr_amount,$get_dc_amount,$get_op_val->op_balance,$get_op_val->op_balance_dc);
            if($get_op_val->op_balance_dc == 'C'){
                $final_closing_balance = (($get_op_val->op_balance+$get_cr_amount)-$get_dc_amount)*(-1);
            }else{
                $final_closing_balance = ($get_op_val->op_balance+$get_dc_amount)-$get_cr_amount;
            }
            // dd($final_closing_balance);
            if($final_closing_balance >= 0){
                $final_outstanding = $final_closing_balance.'DR';
            }else{
                $final_outstanding = ($final_closing_balance)*(-1).'CR';
            }
        }
        // dd($final_outstanding);
        return $final_outstanding;
    }


    public static function  partyopeningdetails($client_char_id,$type){
        $final_outstanding = 0;
        $get_dc_amount = 0;
        $get_cr_amount = 0;
        if($type == 'sec' || $type == 'SEC'){
            $client_char_id = $client_char_id.'-SEC';
        }
        $get_op_val = AccountingLedger::where('code',$client_char_id)->first();
        // dd($get_op_val);
        if(isset($get_op_val) && !empty($get_op_val->id)){
            // $get_dc_amount = AccountingEntryItem::where('ledger_id',$get_op_val->id)->where('dc','D')->sum("amount");
            // $get_cr_amount = AccountingEntryItem::where('ledger_id',$get_op_val->id)->where('dc','C')->sum("amount");
            $get_cr_amount = 0;
            $get_dc_amount = 0;
            // dd($get_cr_amount,$get_dc_amount,$get_op_val->op_balance,$get_op_val->op_balance_dc);
            if($get_op_val->op_balance_dc == 'C'){
                $final_closing_balance = (($get_op_val->op_balance+$get_cr_amount)-$get_dc_amount)*(-1);
            }else{
                $final_closing_balance = ($get_op_val->op_balance+$get_dc_amount)-$get_cr_amount;
            }
            // dd($final_closing_balance);
            if($final_closing_balance >= 0){
                $final_outstanding = $final_closing_balance.'DR';
            }else{
                $final_outstanding = ($final_closing_balance)*(-1).'CR';
            }
        }
        // dd($final_outstanding);
        return $final_outstanding;
    }

    public static function closingbalancedetails($client_char_id,$date,$type){
        $final_outstanding = 0;
        $get_dc_amount = 0;
        $get_cr_amount = 0;
        if($type == 'sec' || $type == 'SEC'){
            $client_char_id = $client_char_id.'-SEC';
        }
        $get_op_val = AccountingLedger::where('code',$client_char_id)->first();
        // dd($get_op_val);
        if(isset($get_op_val) && !empty($get_op_val->id)){
            $get_dc_amount = AccountingEntryItem::join('SYNERGY_entries','SYNERGY_entries.id','=','SYNERGY_entryitems.entry_id')
                            ->where('SYNERGY_entryitems.ledger_id',$get_op_val->id)
                            ->whereRaw("DATE_FORMAT(SYNERGY_entries.date,'%Y-%m-%d')< $date")
                            ->where('SYNERGY_entryitems.dc','D')
                            ->sum("SYNERGY_entryitems.amount");

            $get_cr_amount = AccountingEntryItem::join('SYNERGY_entries','SYNERGY_entries.id','=','SYNERGY_entryitems.entry_id')
                            ->where('SYNERGY_entryitems.ledger_id',$get_op_val->id)
                            ->whereRaw("DATE_FORMAT(SYNERGY_entries.date,'%Y-%m-%d')< $date")
                            ->where('SYNERGY_entryitems.dc','C')
                            ->sum("SYNERGY_entryitems.amount");

            if($get_op_val->op_balance_dc == 'C'){
                $final_closing_balance = (($get_op_val->op_balance+$get_cr_amount)-$get_dc_amount)*(-1);
            }else{
                $final_closing_balance = ($get_op_val->op_balance+$get_dc_amount)-$get_cr_amount;
            }
            // dd($final_closing_balance);
            if($final_closing_balance >= 0){
                $final_outstanding = $final_closing_balance.'DR';
            }else{
                $final_outstanding = ($final_closing_balance)*(-1).'CR';
            }
        }
        // dd($final_outstanding);
        return $final_outstanding;
    }
    public static function clientdebtorlistcal($client_char_id,$date,$balance){
        $balance = (int)($balance);
        if($balance <= 0){
            // dd($balance);
            return 0;
        }
        $change_date = date('Y-m',strtotime($date));
        $bill_value = AllBill::select('all_bills.*',DB::raw("SUM(amount+after_gst_amount) as amount"))
                    // ->whereRaw("DATE_FORMAT(billing_date,'%Y-%m')='$change_date'")
                    ->where('month',$change_date)
                    ->where('client_char_id',$client_char_id)
                    ->where("is_pharma_bill",'!=',1)
                    ->first();
        $bill_value = !empty($bill_value->amount)?round($bill_value->amount):'0';
        // dd($bill_value,$change_date,$date);
        if($bill_value >= $balance){
            return $balance;
        }else{
            // if()
            return !empty($bill_value)?$bill_value:0;
        }
    }
    public static function pharmaclientdebtorlistcal($client_char_id,$date,$balance){
        $balance = (int)($balance);
        if($balance <= 0){
            return 0;
        }
        $change_date = date('Y-m',strtotime($date));
        $bill_value = AllBill::select('all_bills.*',DB::raw("SUM(amount+after_gst_amount) as amount"))
                    ->whereRaw("DATE_FORMAT(billing_date,'%Y-%m')='$change_date'")
                    // ->where('month',$change_date)
                    ->where('client_char_id',$client_char_id)
                    ->where("is_pharma_bill",'=',1)
                    ->first();
        // dd($bill_value,$change_date,$balance);
        $bill_value = !empty($bill_value->amount)?$bill_value->amount:'0';

        if($bill_value >= $balance){
            return !empty($balance)?$balance:0;
        }else{
            // if()
            return !empty($bill_value)?$bill_value:0;
        }
    }
    public static function clientdebtorlistmonthcal($date){
        
        if($date == 'old'){
            return true;
        }
        $change_date = date('Y-m',strtotime($date));
        $bill_value = AllBill::select('all_bills.*',DB::raw("SUM(amount+after_gst_amount) as amount"))
                    // ->whereRaw("DATE_FORMAT(billing_date,'%Y-%m')='$change_date'")
                    ->where('month',$change_date)
                    ->where("is_pharma_bill",'!=',1)
                    ->first();
        // $bill_value = !empty($bill_value->id)?$bill_value->amount:'0';
        // if()
        if(!empty($bill_value->id)){
            return true;
        }else{
            return false;
        }
      
    }
    public static function pharmaclientdebtorlistmonthcal($date){
        
        if($date == 'old'){
            return true;
        }
        $change_date = date('Y-m',strtotime($date));
        $bill_value = AllBill::select('all_bills.*',DB::raw("SUM(amount+after_gst_amount) as amount"))
                    ->whereRaw("DATE_FORMAT(billing_date,'%Y-%m')='$change_date'")
                    // ->where('month',$change_date)
                    ->where("is_pharma_bill",1)
                    ->first();
        // $bill_value = !empty($bill_value->id)?$bill_value->amount:'0';
        // if()
        if(!empty($bill_value->id)){
            return true;
        }else{
            return false;
        }
      
    }
    public static function  check_arrear($client_char_id,$type,$date){
        $final_outstanding = 0;
        $get_dc_amount = 0;
        $get_cr_amount = 0;
        $final_closing_balance = 0;
        if($type == 'sec' || $type == 'SEC'){
            $client_char_id = $client_char_id.'-SEC';
        }
        $get_op_val = AccountingLedger::where('code',$client_char_id)->first();
        // dd($get_op_val);
        if(isset($get_op_val) && !empty($get_op_val->id)){
            $get_dc_amount = AccountingEntryItem::join('SYNERGY_entries','SYNERGY_entries.id','=','SYNERGY_entryitems.entry_id')
                            ->where('SYNERGY_entryitems.ledger_id',$get_op_val->id)
                            ->whereRaw("DATE_FORMAT(date,'%Y-%m-%d')<'$date'")
                            ->where('SYNERGY_entryitems.dc','D')
                            ->sum("SYNERGY_entryitems.amount");

            $get_cr_amount = AccountingEntryItem::join('SYNERGY_entries','SYNERGY_entries.id','=','SYNERGY_entryitems.entry_id')
                            ->where('SYNERGY_entryitems.ledger_id',$get_op_val->id)
                            ->whereRaw("DATE_FORMAT(date,'%Y-%m-%d')<'$date'")
                            ->where('SYNERGY_entryitems.dc','C')
                            ->sum("SYNERGY_entryitems.amount");
            // dd($get_cr_amount,$get_dc_amount,$get_op_val->op_balance,$get_op_val->op_balance_dc);
            if($get_op_val->op_balance_dc == 'C'){
                $final_closing_balance = (($get_op_val->op_balance+$get_cr_amount)-$get_dc_amount)*(-1);
            }else{
                $final_closing_balance = ($get_op_val->op_balance+$get_dc_amount)-$get_cr_amount;
            }
            // dd($final_closing_balance);
            // if($final_closing_balance >= 0){
            //     $final_outstanding = $final_closing_balance;
            // }else{
            //     $final_outstanding = ($final_closing_balance)*(-1);
            // }
        }
        // dd($final_outstanding);
        return $final_closing_balance;
    }
    public function client_renewal_re(){
        return $this->belongsTo(ClientRenew::class,'id','client_id');
    } 
}
