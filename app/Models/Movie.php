<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'original_title',
        'original:language',
        'overview',
        'popularity',
        'release_date',
        'revenue',
        'runtime',
        'budget',
        'vote_average',
        'vote_count',
        'json_response',
        'external_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'popularity' => 'decimal:3',
        'release_date' => 'date',
        'revenue' => 'decimal:3',
        'vote_average' => 'decimal:3',
        'json_response' => 'array',
        'external_id' => 'integer',
    ];

    /**
     * @return BelongsTo<User, Movie>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasMany<Image>
     */
    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
