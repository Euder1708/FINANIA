<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanzaTransaction extends Model
{
    use HasFactory;

    protected $table = 'finanza_transactions';
    protected $fillable = ['account_id','category_id','amount','type','description','occurred_at','created_by'];

    public function account()
    {
        return $this->belongsTo(FinanzaAccount::class, 'account_id');
    }

    public function category()
    {
        return $this->belongsTo(FinanzaCategory::class, 'category_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
