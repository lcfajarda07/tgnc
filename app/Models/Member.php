<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'branch_id',
        'photo_url',
        'first_name',
        'last_name',
        'birthday',
        'gender',
        'civil_status',
        'occupation',
        'phone',
        'email',
        'address',
        'emergency_contact',
        'membership_status',
        'water_baptism',
        'holy_spirit_baptism',
        'ministry',
        'life_group',
    ];

    protected $casts = [
        'birthday' => 'date',
        'water_baptism' => 'boolean',
        'holy_spirit_baptism' => 'boolean',
    ];

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name);
    }
}
