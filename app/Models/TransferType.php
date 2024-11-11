<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferType extends Model
{
    use HasFactory;
    public const INTERNAL_ID = 1;
    public const EXTERNAL_ID = 2;
    public const INTERNAL = 'internal';
    public const EXTERNAL = 'external';
    protected $fillable = ['type'];
}
