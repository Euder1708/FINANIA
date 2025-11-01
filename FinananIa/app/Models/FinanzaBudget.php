<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanzaBudget extends Model
{
    use HasFactory;

    protected $table = 'finanza_budgets';
    protected $fillable = ['category_id','amount','start_date','end_date','notes'];

    public function category()
    {
        return $this->belongsTo(FinanzaCategory::class, 'category_id');
    }
}
