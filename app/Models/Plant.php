<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class Plant extends Model
{
    protected $table = "plant";

    // protected $fillable = [
    //     'user_id',
    //     'plant_id',
    //     'created_by',
    //     'updated_by',
    // ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            $model->created_by = $user->id;
        });
        static::updating(function ($model) {
            $user = Auth::user();
            $model->updated_by = $user->id;
        });
    }



    public function createdBy()
    {
        return $this->belongsTo(User::class);
    }

    public function userPlants()
    {
        return $this->hasMany(UserPlant::class);
    }
}
