<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryLogs extends Model
{
    use HasFactory;
    protected $table = 'entry_logs';
    public $timestamps = false;
    protected $fillable = [
    			'entry_slip_no',
    			'updated_at',
    			'updated_by'
    			];
}
