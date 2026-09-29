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

    const STATUS_AVAILABLE = 'available';

    const STATUS_IN_USE = 'in_use';

    const STATUS_IN_MAINTENANCE = 'in_maintenance';

    protected $fillable = [
        'locker_title',
        'size',
        'description',
        'user_id',
        'locations_id',
        'start',
        'releave',
        'password',
        'img',
        'status',
    ];

    public static function statuses(): array
    {
        return [
            self::STATUS_AVAILABLE,
            self::STATUS_IN_USE,
            self::STATUS_IN_MAINTENANCE,
        ];
    }

    public function isAvailable(): bool
    {
        return $this->status === self::STATUS_AVAILABLE;
    }

    public function isInUse(): bool
    {
        return $this->status === self::STATUS_IN_USE;
    }

    public function isInMaintenance(): bool
    {
        return $this->status === self::STATUS_IN_MAINTENANCE;
    }

    public function isUsedBy(?int $userId): bool
    {
        return $this->isInUse() && $this->user_id === $userId;
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_IN_USE => 'In Use',
            self::STATUS_IN_MAINTENANCE => 'In Maintenance',
            default => 'Unknown',
        };
    }

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
