<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrayerRequest extends Model
{
    use SoftDeletes;

    protected $fillable = ['branch_id', 'name', 'email', 'phone', 'request', 'visibility', 'status', 'prayed_at'];

    protected $casts = ['prayed_at' => 'datetime'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
