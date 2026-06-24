<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Auction extends Model
{
    protected $fillable = [
        'category_id', 'title', 'slug', 'description', 'image',
        'starting_price', 'current_price', 'reserve_price', 'bid_increment',
        'bid_count', 'watchers', 'status', 'featured', 'starts_at', 'ends_at',
    ];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'current_price' => 'decimal:2',
            'reserve_price' => 'decimal:2',
            'bid_increment' => 'decimal:2',
            'featured' => 'boolean',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class)->orderByDesc('amount');
    }

    public function winningBid(): ?Bid
    {
        return $this->bids()->where('is_winning', true)->first();
    }

    public function isLive(): bool
    {
        return $this->status === 'live' && $this->ends_at->isFuture();
    }

    public function isEnded(): bool
    {
        return $this->status === 'ended' || $this->ends_at->isPast();
    }

    public function timeRemaining(): string
    {
        if ($this->isEnded()) {
            return 'Ended';
        }

        $diff = now()->diff($this->ends_at);

        if ($diff->days > 0) {
            return $diff->days.'d '.$diff->h.'h '.$diff->i.'m';
        }

        if ($diff->h > 0) {
            return $diff->h.'h '.$diff->i.'m '.$diff->s.'s';
        }

        return $diff->i.'m '.$diff->s.'s';
    }

    public function minimumBid(): float
    {
        return (float) $this->current_price + (float) $this->bid_increment;
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live')->where('ends_at', '>', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeEndingSoon($query)
    {
        return $query->live()->orderBy('ends_at');
    }
}
