<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'wallet_id',
        'is_usable',
        'token'
    ];

    public function wallet() {
        return $this->belongsTo('App\Models\Wallet');
    }
}
