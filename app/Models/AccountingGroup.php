<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingGroup extends Model
{
    protected $table = 'SYNERGY_groups';

    protected $fillable = ['name', 'parent_id', 'code', 'affects_gross', 'is_bank_or_cash'];

    public $timestamps = false;
}
