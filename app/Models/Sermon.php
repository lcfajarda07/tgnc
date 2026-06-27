<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sermon extends Model
{
    use SoftDeletes;

    protected $fillable = ['branch_id', 'title', 'speaker', 'scripture', 'preached_at', 'video_url', 'thumbnail_url', 'summary', 'status'];

    protected $casts = ['preached_at' => 'date'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
