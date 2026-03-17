<?php

namespace App\Models;

use App\Models\Machine;
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
        'base_price',
        'is_active',
    ];

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
}