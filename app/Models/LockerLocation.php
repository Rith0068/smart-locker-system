<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LockerLocation extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'locations';

    protected $fillable = [
        'name_location',
        'adress',
        'img',
    ];

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $query) use ($term) {
            $query->where('name_location', 'like', "%{$term}%")
                ->orWhere('adress', 'like', "%{$term}%");
        });
    }

    public function lockers(): HasMany
    {
        return $this->hasMany(Locker::class, 'locations_id');
    }
}
