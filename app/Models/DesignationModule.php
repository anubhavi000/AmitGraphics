<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DesignationModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation_id',
        'module_id',
        'add',
        'view',
        'delete',
        'edit',
        'download',
        'upload',
        'created_by',
        'updated_by',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class,  'designation_id');
    }

    public function modules()
    {
        return $this->belongsTo(Module::class,  'module_id');
    }
}
