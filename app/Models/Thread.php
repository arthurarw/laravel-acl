<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 *
 */
class Thread extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'body',
        'slug',
        'channel_id',
        'user_id'
    ];

    /**
     *
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Replies relationship
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class)->orderByDesc('created_at');
    }

    /**
     *
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param Builder $builder
     * @param int $perPage
     * @param string|null $channelSlug
     * @return LengthAwarePaginator
     */
    public function scopeThreadsByChannels(
        Builder $builder,
        int     $perPage = 10,
        string  $channelSlug = null
    ): LengthAwarePaginator
    {
        $query = $builder->with(['user', 'channel'])
            ->withCount('replies')
            ->orderByDesc('created_at');

        if (!empty($channelSlug)) {
            $query->whereHas('channel', fn($query) => $query->whereSlug($channelSlug));
        }

        return $query->paginate($perPage);
    }
}
