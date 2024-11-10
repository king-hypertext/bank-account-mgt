<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    protected $hidden = [];
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }
    public function openAccounts()
    {
        return $this->hasMany(Account::class)->where('account_status_id', accountStatus::OPEN_ID);
    }
    public function closedAccounts()
    {
        return $this->hasMany(Account::class)->where('account_status_id', accountStatus::CLOSED_ID);
    }
}
