<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'bank_name',
        'ref',
        'account_name',
        'account_address',
        'initial_amount',
        'account_description',
        'account_location_id',
        'account_type_id',
        'account_status_id',
    ];
    public function accountLocation()
    {
        return $this->belongsTo(AccountLocation::class);
    }
    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
    public function accountStatus()
    {
        return $this->belongsTo(AccountStatus::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
