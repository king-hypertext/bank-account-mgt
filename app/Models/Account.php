<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'account_number',
        'bank_name',
        'name',
        'balance',
        'account_address',
        'initial_amount',
        'account_description',
        'account_location_id',
        'currency',
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
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }
    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }
}
