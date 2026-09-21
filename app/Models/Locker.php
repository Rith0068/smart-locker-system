<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Locker extends Model
{
    const ROLE_USER = 1;

    const ROLE_STAFF = 2;

    protected $fillable = [
        'locker_title',
        'user_id',
        'locations_id',
        'start',
        'releave',
        'img',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LockerLocation::class, 'locations_id');
    }

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class, 'lockers_id');
    }

    public function currentMaintenance(): HasOne
    {
        return $this->hasOne(Maintenance::class, 'lockers_id')->latestOfMany();
    }
    public function location()
{
    return $this->belongsTo(LockerLocation::class, 'locations_id');
}
}
}
