<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingEntry extends Model
{
    protected $table = 'SYNERGY_entries';

    protected $fillable = ['tag_id', 'is_locked', 'plant_char_id', 'entrytype_id', 'number', 'date', 'dr_total', 'cr_total', 'narration'];

    public $timestamps = false;
}
