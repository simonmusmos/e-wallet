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
        'is_fraudulent',
        'other_wallet'
    ];

    public function wallet(){
        return $this->belongsTo('App\Models\Wallet');
    }

    public function otherUser(){
        return $this->hasOne('App\Models\User', 'other_user');
    }
}
