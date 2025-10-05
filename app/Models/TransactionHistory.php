<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHistory extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = [
        'account_number',
        'amount',
        'transaction_type',
        'transaction_code',
        'remarks',
    ];
    public function savingAccountInfo()
    {
        return $this->belongsTo(SavingsAccountInfo::class, 'account_number', 'account_number');
    }

    public static function generateTransactionCode()
    {
        // Fetch the latest transaction code
        $latestTransaction = self::orderBy('transaction_code', 'desc')->first();
    
        if ($latestTransaction && $latestTransaction->transaction_code) {
            // Extract the numeric part of the latest transaction code and convert it to an integer
            $latestCode = (int) substr($latestTransaction->transaction_code, 1); // Remove the 'T' prefix
        } else {
            // Set the starting point if no previous code exists (starting with T0000001)
            $latestCode = 0; // Start from 0000001
        }
    
        // Generate the next code
        $nextCode = $latestCode + 1;
    
        // Ensure the numeric part is 7 digits long
        $formattedCode = str_pad($nextCode, 7, '0', STR_PAD_LEFT);
    
        // Return the full code with 'T' prefix
        return 'T' . $formattedCode;
    }    
}
