<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LifeGroup extends Model
{
    use SoftDeletes;

    protected $fillable = ['branch_id', 'name', 'leader_name', 'schedule', 'location', 'description', 'status'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
