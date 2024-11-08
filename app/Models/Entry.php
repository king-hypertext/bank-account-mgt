<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_id',
        'entry_type_id',
        'transaction_type_id',
        'amount',
        'description',
        'reference_number',
        'status',
        'date'
    ];
    public function account()
    {
        return $this->belongsTo(Account::class);  // Assuming Account Model has a foreign key 'account_id'
    }
    public function entryType()
    {
        return $this->belongsTo(EntryType::class);
    }
    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);  // Assuming Transaction Model has a foreign key 'entry_id'
    }
    public function scopeBelongsToAccounts($query, $accountIds)
    {
        return $query->whereIn('account_id', $accountIds)->orderBy('created_at','desc')->get();
    }
}
