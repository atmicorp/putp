<?php

namespace App\Models;

use App\Models\OrderOffer;
use App\Models\Company;
use App\Models\Contact;
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
        'company_id',
        'contact_id',
        'status',
        'sent_at',
        'pic_id',
        'created_by',
        'tujuan_pengujian',    
        'waktu_diharapkan',    
        'keterangan_tambahan', 
        'waktu_pelaksanaan',  
        'lokasi_pelaksanaan',  
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'waktu_diharapkan' => 'date',
            'waktu_pelaksanaan' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS CONSTANTS
    |--------------------------------------------------------------------------
    */

    public const STATUS_DRAFT        = 'draft';
    public const STATUS_SUBMIT       = 'submit';
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
                $order->access_token = Str::random(6);
            }

            if (blank($order->order_code)) {
                do {
                    $order->order_code =
                        'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
                } while (self::where('order_code', $order->order_code)->exists());
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function getGrandTotalAttribute()
    {
        if (!$this->offer) return 0;

        return $this->offer->details->sum(function ($d) {
            return $d->qty * $d->price;
        });
    }

    public function pic(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_id');
    }
}