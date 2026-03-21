<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Thread extends Model
{
    use Searchable;

    protected $fillable = ['protocol_id', 'user_id', 'title', 'content', 'views', 'replies'];

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'protocol_id' => (int) $this->protocol_id,
            'title' => $this->title,
            'content' => $this->content,
            'views' => (int) $this->views,
            'replies' => (int) $this->replies,
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Protocol::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
