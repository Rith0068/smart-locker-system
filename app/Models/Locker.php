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
        'password',
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

    protected static function booted(): void
    {
        static::created(function (Locker $locker) {
            if ($locker->user_id) {
                History::create([
                    'user_id' => $locker->user_id,
                    'locker_id' => $locker->id,
                    'action' => 'use',
                ]);
            }
        });

        static::updating(function (Locker $locker) {
            if (! $locker->isDirty('user_id')) {
                return;
            }

            $old = $locker->getOriginal('user_id');
            $new = $locker->user_id;

            if (! is_null($old) && is_null($new)) {
                History::create([
                    'user_id' => $old,
                    'locker_id' => $locker->id,
                    'action' => 'release',
                ]);
            } elseif (! is_null($new)) {
                History::create([
                    'user_id' => $new,
                    'locker_id' => $locker->id,
                    'action' => 'use',
                ]);
            }
        });
    }
}

