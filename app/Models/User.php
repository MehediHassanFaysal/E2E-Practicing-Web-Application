<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'member_code',
        'name',
        'email',
        'password',
        'user_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

       // Define the one-to-one relationship with customer info
       public function customerInfo()
       {
           return $this->hasOne(CustomerInfo::class, 'member_code', 'member_code');
           
       }

    public static function generateMemberCode()
    {
        // Fetch the latest member code
        $latestMember = self::orderBy('member_code', 'desc')->first();

        if ($latestMember) {
            $latestCode = (int) $latestMember->member_code;
        } else {
            $latestCode = 1110; // Set this to one less than your starting point
        }

        // Generate the next code
        $nextCode = $latestCode + 1;

        // Ensure code is in the correct format, e.g., 3 digits
        return str_pad($nextCode, 4, '0', STR_PAD_LEFT);
    }
}
