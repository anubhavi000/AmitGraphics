<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantConfiguration extends Model
{
  protected $fillable = [
    'plant_id',
    'ledger_id',
    'ledger_type_id',
    'percentage',
    'percentage_hcf',
    'created_by',
    'updated_by',
  ];

  public function plant()
  {
    return $this->belongsTo(Plant::class, 'plant_id');
  }

  public function ledgerType()
  {
    return $this->belongsTo(LedgerType::class, 'ledger_type_id');
  }
}
