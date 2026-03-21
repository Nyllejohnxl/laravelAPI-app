<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Protocol extends Model
{
    use Searchable;

    protected $fillable = ['user_id', 'title', 'description', 'status', 'views'];

    public function toSearchableArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'tags' => $this->tags, // Ensure this is an array or comma-separated string
            'votes' => (int) $this->votes_count,
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }
}
