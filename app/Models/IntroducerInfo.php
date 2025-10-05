<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntroducerInfo extends Model
{
    use HasFactory;
     // Set the primary key to id
     protected $primaryKey = 'id';
     protected $fillable = [
         'member_code',
         'introducer_account',
         'introducer_name',
         'introducer_nid',
         'introducer_mobile_number',
         'remaks'
     ];
 
     // Define the inverse of the one-to-one relationship
     public function customerInfo()
     {
         return $this->belongsTo(CustomerInfo::class, 'member_code', 'member_code');
     }

    
}
