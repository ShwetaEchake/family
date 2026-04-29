<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'family_head_id',
        'name',
        'birthdate',
        'marital_status',
        'wedding_date',
        'education',
        'photo',
    ];

    protected $casts = [
        'birthdate'    => 'date',
        'wedding_date' => 'date',
    ];

    public function familyHead(): BelongsTo
    {
        return $this->belongsTo(FamilyHead::class, 'family_head_id');
    }
}
