<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBadge extends Model
{

    protected $with = ['badgeRules'];

    protected $table = 'user_badges';

    protected $fillable = ['user_id', 'badge_id','created_at','updated_at'];

    public function badgeRules(): BelongsTo
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

}
