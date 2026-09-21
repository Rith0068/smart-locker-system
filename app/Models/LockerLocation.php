<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LockerLocation extends Model
{
    protected $primaryKey = 'id';
    
    protected $table = 'locations';  

    protected $fillable = [
        'name_location',
        'adress',
        'img'
    ];

    public function lockers(): HasMany
    {
        return $this->hasMany(Locker::class, 'locations_id');
    }
}
