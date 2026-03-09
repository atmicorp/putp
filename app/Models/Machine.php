<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function operators(): BelongsToMany
    {
        return $this->belongsToMany(Operator::class, 'machine_operator')
            ->withTimestamps();
    }

    public function packages(): HasMany
    {
        return $this->hasMany(Package::class);
    }
    
}