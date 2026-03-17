<?php

namespace App\Models;

use App\Models\OrderOffer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_code',
        'access_token',
        'customer_name',
        'customer_slug',
        'customer_email',
        'status',
        'sent_at',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT        = 'draft';
    public const STATUS_SUBMIT        = 'submit';
    public const STATUS_OFFERED      = 'offered';
    public const STATUS_REJECTED     = 'rejected';
    public const STATUS_FORM_REQUIRED = 'form_required';
    public const STATUS_APPROVED     = 'approved';
    public const STATUS_PROCESSING   = 'processing';
    public const STATUS_DONE         = 'done';

    /*
    |--------------------------------------------------------------------------
    | BOOT
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (self $order) {

            if (blank($order->access_token)) {
                $order->access_token = Str::random(64);
            }

            if (blank($order->order_code)) {
                do {
                    $order->order_code =
                        'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
                } while (self::where('order_code', $order->order_code)->exists());
            }

            if (blank($order->customer_slug) && filled($order->customer_name)) {
                $order->customer_slug = Str::slug($order->customer_name);
            }

            if (blank($order->status)) {
                $order->status = self::STATUS_DRAFT;
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function offer(): HasOne
    {
        return $this->hasOne(OrderOffer::class);
    }
    
}