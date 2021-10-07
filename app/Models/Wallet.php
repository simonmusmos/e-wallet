<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'wallet_address',
        'user_id',
        'is_deleted'
    ];

    public function transactions() {
        return $this->hasMany('App\Models\Transaction');
    }

    public function getIncoming() {
        return $this->transactions()->where("is_deleted", 0)->where("is_incoming", 1)->sum();
    }
}
