<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryItem extends Model
{
    use SoftDeletes;

    protected $table = 'gallery';

    protected $fillable = ['branch_id', 'title', 'category', 'image_url', 'description', 'taken_at', 'status'];

    protected $casts = ['taken_at' => 'date'];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
