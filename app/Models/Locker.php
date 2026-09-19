<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locker extends Model
{
    use HasFactory;

    protected $fillable = [
        'locker_title',
        'user_id',
        'locations_id',
        'start',
        'releave',
        'img',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(LockerLocation::class, 'locations_id');
    }
}