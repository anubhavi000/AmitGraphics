<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingLedger extends Model
{
    protected $table = 'SYNERGY_ledgers';

    protected $fillable = ['group_id', 'plant_char_id', 'name', 'code', 'op_balance', 'op_balance_dc', 'type', 'reconciliation', 'notes'];

    public $timestamps = false;

    // public static function get_records($client_char_id,$type = 0 ){
    //     if(empty($client_char_id)){
    //         return false;
    //     }
    //     return self::join('SYNERGY_groups','SYNERGY_groups.id','=','SYNERGY_ledgers.group_id')
    //         ->select('SYNERGY_ledgers.name as ledger_name','SYNERGY_ledgers.code as ledger_code','SYNERGY_groups.name as group_name','SYNERGY_groups.code as group_code','SYNERGY_ledgers.id as voucher_name','SYNERGY_ledgers.notes as ledger_notes','SYNERGY_ledgers.type as ledger_type','SYNERGY_ledgers.op_balance')
    //         ->where('SYNERGY_ledgers.code',$client_char_id)
    //         ->where('SYNERGY_ledgers.type',$type)
    //         ->get();
    // }
}
