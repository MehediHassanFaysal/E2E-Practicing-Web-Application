<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInfo extends Model
{
    use HasFactory;
    // Set the primary key to member_code
    protected $primaryKey = 'member_code';
    public $incrementing = false; // Disable auto-incrementing since member_code is a string
    protected $keyType = 'string'; // Specify that the primary key is a string


    protected $fillable = [
        'member_code',
        'mobile_number',
        'nation_id_card',
        'dob',
        'occupation',
        'anual_income',
        'present_address',
        'permanent_address'
    ];

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
    public function accountInfo()
    {
        return $this->hasOne(SavingsAccountInfo::class, 'member_code', 'member_code');
    }


   // Define the inverse of the one-to-one relationship
//    public function userInfo()
//    {
//        return $this->belongsTo(User::class, 'member_code', 'member_code');

//    }

/*
   

   


*/





}
