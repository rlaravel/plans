<?php

namespace MorenoRafael\Plans\Models\Traits;

use Ramsey\Uuid\Uuid;

/**
 * Trait CreatingUuidModel
 * @package App\Models
 * @property-read string $uuid
 * @method static \Illuminate\Database\Eloquent\Builder whereUuid($uuid)
 */
trait CreatingUuidModel
{
    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     *
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $query->uuid = Uuid::uuid4();
        });
    }
}
