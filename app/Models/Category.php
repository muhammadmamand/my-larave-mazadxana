<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'color'];

    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    public function liveAuctions(): HasMany
    {
        return $this->hasMany(Auction::class)->where('status', 'live');
    }
}
