<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinanceRecord extends Model
{
    use SoftDeletes;

    protected $table = 'finance';

    protected $fillable = ['branch_id', 'type', 'category', 'amount', 'transaction_date', 'source', 'notes', 'recorded_by'];

    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
