<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanzaAccount extends Model
{
    use HasFactory;

    protected $table = 'finanza_accounts';
    protected $fillable = ['name','type','currency','balance','description'];

    public function transactions()
    {
        return $this->hasMany(FinanzaTransaction::class, 'account_id');
    }
}
