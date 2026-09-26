<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $fillable = ['description', 'lockers_id', 'status'];

    const STATUS_AVAILABLE = 1;
    const STATUS_MAINTENANCE = 2;
    const STATUS_IN_USE = 3;

    public function locker()
    {
        return $this->belongsTo(Locker::class, 'lockers_id');
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            self::STATUS_AVAILABLE => 'Available',
            self::STATUS_MAINTENANCE => 'Maintenance',
            self::STATUS_IN_USE => 'In Use',
            default => 'Unknown',
        };
    }
}