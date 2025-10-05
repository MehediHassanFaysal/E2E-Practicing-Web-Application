<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomineeInfo extends Model
{
    use HasFactory;
    // Set the primary key to member_code
    protected $primaryKey = 'member_code';
    protected $fillable = [
        'member_code',
        'nominee_code',
        'nominee_name',
        'age',
        'nominee_mobile_number',
        'nid_number',
        'birth_id',
        'percentage',
        'relation_with_member'
    ];

    // Define the inverse of the one-to-one relationship
    public function customerInfo()
    {
        return $this->belongsTo(CustomerInfo::class, 'member_code', 'member_code');
    }

    public static function generateNomineeCode()
    {
        // Fetch the latest nominee code
        $latestNominee = self::orderBy('nominee_code', 'desc')->first();

        if ($latestNominee && $latestNominee->nominee_code) {
            $latestCode = (int) $latestNominee->nominee_code;
        } else {
            $latestCode = 3100; // Set this to your starting point
        }

        // Generate the next code
        $nextCode = $latestCode + 1;

        // Ensure code is in the correct format (e.g., 4 digits)
        return str_pad($nextCode, 4, '0', STR_PAD_LEFT);
    }
}
