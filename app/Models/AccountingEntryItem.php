<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntryItem extends Model
{
    protected $table = 'SYNERGY_entryitems';

    protected $fillable = ['entry_id', 'ledger_id', 'amount', 'dc', 'reconciliation_date','item_narration', 'morphable_id', 'morphable_type'];

    public $timestamps = false;

    public function entry(){
        return $this->belongsTo(AccountingEntry::class,'entry_id');
    }
    public function entry_ledger(){
        return $this->belongsTo(AccountingLedger::class,'ledger_id');
    }
}
