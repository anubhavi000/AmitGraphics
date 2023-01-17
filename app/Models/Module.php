<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
  use HasFactory;
  protected $fillable = [
    'parent_id',
    'module_name',
    'status',
    'sequence',
    'route_name',
    'icon',
    'created_by',
    'updated_by',
  ];

  public function parent()
  {
    return $this->belongsTo(self::class,  'parent_id');
  }

  public function childs()
  {
    return $this->hasMany(self::class, 'parent_id')->where('status', 'active')->orderBy('sequence', 'ASC');
  }

  public function designationModules()
  {
    return $this->hasMany(DesignationModule::class);
  }
}
