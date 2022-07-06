<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'operation_date',
        'reason',
        'file'
    ];


    public function WalletOperation()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }
}
