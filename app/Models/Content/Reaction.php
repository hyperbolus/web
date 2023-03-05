<?php

namespace App\Models\Content;

use App\Models\System\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @mixin IdeHelperReaction
 */
class Reaction extends Model
{
    use HasFactory;

    public function reacter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reacter_id')->select(['id', 'name']);
    }

    public function reactable(): MorphTo
    {
        return $this->morphTo();
    }
}
