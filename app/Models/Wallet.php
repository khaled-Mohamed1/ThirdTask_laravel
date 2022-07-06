<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'principal_amount',
        'total_amount',
        'restrictions',
        'bank_name',
        'file',
        'status',
        'shutdown_reason',
        'shutdown_date'
    ];

    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}
