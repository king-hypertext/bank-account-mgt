<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillale = [
        'to_account_id',
        'from_account_id',
        'amount',
        'notes',
        'transaction_type_id',
    ];
    public function scopeBelongsToAccounts($query, $accountIds)
    {
        return $query->whereIn('to_account_id', $accountIds)->whereIn('from_account_id', $accountIds)->orderBy('created_at', 'desc')->get();
    }
    public function fromAccount(){
        return $this->belongsTo(Account::class, 'from_account_id');
    }
    public function toAccount(){
        return $this->belongsTo(Account::class, 'to_account_id');
    }
    public function transactionType(){
        return $this->belongsTo(TransactionType::class);
    }

}
