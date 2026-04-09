<?php

namespace App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
    ];

    protected static function booted(): void
    {
        static::creating(function ($company) {
            if (blank($company->slug)) {
                $company->slug = Str::slug($company->name);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}