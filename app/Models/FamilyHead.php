<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyHead extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'surname',
        'birthdate',
        'mobile_no',
        'address',
        'state',
        'city',
        'pincode',
        'marital_status',
        'wedding_date',
        'photo',
    ];

    protected $casts = [
        'birthdate'   => 'date',
        'wedding_date' => 'date',
    ];

    public function hobbies(): HasMany
    {
        return $this->hasMany(Hobby::class, 'family_head_id');
    }

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class, 'family_head_id');
    }

    /**
     * Full name accessor
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->surname}";
    }
}
