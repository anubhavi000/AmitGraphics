<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientWiseBillPayment extends Model
{
    protected $fillable = [
        'bill_no',
        'client_char_id',
        'payment_char_id',
        'paid_amount',
        'created_by',
        'updated_by',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $user = \Auth::user();
            $model->created_by = $user->id;

            /**
             * Creating Ledger for accounting application
             *
             * @param  \App\Models\Client  $client
             */
        });

        static::updating(function ($model) {
            $user = \Auth::user();
            $model->updated_by = $user->id;
        });
    }
}
