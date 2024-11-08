<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;
    public function account(){
        return $this->belongsTo(Account::class);  // Assuming Account Model has a foreign key 'account_id'
    }

}
