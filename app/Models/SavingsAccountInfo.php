<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavingsAccountInfo extends Model
{
    use HasFactory;
    // Set the primary key to id
    protected $primaryKey = 'id';
    protected $fillable = [
        'member_code',
        'account_number',
        'account_type',
        'amount'
    ];

    // Define the inverse of the one-to-one relationship
    public function customerInfo()
    {
        return $this->belongsTo(CustomerInfo::class, 'member_code', 'member_code');
    }

    public function transactionHistoryInfo()
    {
        return $this->hasMany(TransactionHistory::class, 'account_number', 'account_number');
    }

    public function fundTransaction()
    {
        return $this->hasMany(FundTransaction::class, 'sender_account_number');
    }


         // Define the one-to-one relationship with NomineeInfo
         public function nomineeInfo()
         {
             return $this->hasOne(NomineeInfo::class, 'member_code', 'member_code');
         }
        // Define the one-to-one relationship with IntroducerInfo
        public function introducerInfo()
        {
            return $this->hasOne(IntroducerInfo::class, 'member_code', 'member_code');
        }

    public static function generateSavingAccount()
     {
         // Fetch the latest account number
         $latestSavingAccNo = self::orderBy('account_number', 'desc')->first();
 
         if ($latestSavingAccNo && $latestSavingAccNo->account_number) {
             $latestAccCode = (int) $latestSavingAccNo->account_number;
         } else {
             $latestAccCode = 50011100000; // Set this to your starting point
         }
 
         // Generate the next account number
         $nextCode = $latestAccCode + 1;
 
         // Ensure the account number is in the correct format (e.g., 11 digits)
         return str_pad($nextCode, 11, '0', STR_PAD_LEFT);
     }

}
