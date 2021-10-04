<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class UserAchievement extends Model
{
    protected $with = ['achievementRules'];
    protected $fillable = ['user_id', 'achievement_id', 'created_at', 'updated_at'];

    public function achievementRules(): BelongsTo
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }
}
