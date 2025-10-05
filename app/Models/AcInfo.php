<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcInfo extends Model
{
    use HasFactory;
    protected $fillable = ['ac_no', 'branch_code', 'remarks'];

    // Optionally define a relationship with BranchInfo
    public function branch()
    {
        return $this->belongsTo(BranchInfo::class, 'branch_code', 'branch_code');
    }
}
