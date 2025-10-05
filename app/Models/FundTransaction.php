<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundTransaction extends Model
{
    use HasFactory;
        // Set the primary key to id
        protected $primaryKey = 'id';
        protected $fillable = [
            'sender_account_number',
            'receiver_account_number',
            'amount'
        ];

    public function savingsAccount()
    {
        return $this->belongsTo(SavingsAccountInfo::class, 'account_number');
    }
}
