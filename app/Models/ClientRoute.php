<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientRoute extends Model
{
  protected $fillable = [
    'company_id',
    'client_address',
    'client_char_id',
    'client_name',
    'route_order',
    'client_id',
    'route_id',
    'status',
    'created_by',
    'updated_by',
  ];

  public function client()
  {
    return $this->belongsTo(Client::class,  'client_id');
  }
}
