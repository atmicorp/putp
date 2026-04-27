<?php

namespace App\Models;

use App\Models\Machine;
use App\Models\PackageBlackoutDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $fillable = [
    'machine_id',
    'pic_operator_id',
    'category_id',
    'name',
    'description',
    'image',        // ← tambahkan ini
    'base_price',
    'is_active',
    ];

    /**
     * URL untuk mengakses gambar package melalui route private.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? route('package.image', ['package' => $this->id])
            : null;
    }

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'is_active'  => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function picOperator(): BelongsTo
    {
        return $this->belongsTo(Operator::class, 'pic_operator_id');
    }

    public function category(): BelongsTo // tambahan
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function offerDetails(): HasMany
    {
        return $this->hasMany(OrderOfferDetail::class);
    }

    public function blackoutDates(): HasMany
    {
        return $this->hasMany(PackageBlackoutDate::class);
    }

    /**
     * Cek apakah package full (tidak tersedia) di tanggal tertentu.
     */
    public function isBlackoutOn(\Carbon\Carbon|string $date): bool
    {
        return $this->blackoutDates()
            ->whereDate('date', $date)
            ->exists();
    }
}