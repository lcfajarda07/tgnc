<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChurchEvent extends Model
{
    use SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'branch_id',
        'ministry_id',
        'title',
        'starts_at',
        'ends_at',
        'location',
        'description',
        'capacity',
        'registration_required',
        'image_url',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'registration_required' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
