<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Locker extends Model
{
    use HasFactory;

    const ROLE_USER = 1;
    const ROLE_STAFF = 2;

    protected $fillable = [
        'locker_title',
        'user_id',
        'role',
        'start',
        'releave',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class, 'lockers_id');
    }

    public function currentMaintenance()
    {
        return $this->hasOne(Maintenance::class, 'lockers_id')->latestOfMany();
    }
    public function location()
{
    return $this->belongsTo(LockerLocation::class, 'locations_id');
}
}