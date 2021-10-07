<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'wallet_id',
        'is_incoming',
        'is_deleted',
        'is_fraudulent'
    ];

    public function wallet(){
        return $this->belongsTo('App\Models\Wallet');
    }
}
