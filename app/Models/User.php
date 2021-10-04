<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $with = ['achievements', 'badges'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The comments that belong to the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'lesson_user')
            ->withTimestamps();
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->wherePivot('watched', true);
    }

    public function achievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }

    public function achievement()
    {
        return $this->achievements()
            ->orderByDesc('created_at')
            ->first();
    }

    public function badges(): HasMany
    {
        return $this->hasMany(UserBadge::class);
    }

    public function currentBadge()
    {

        return $this->badges()
            ->orderByDesc('created_at')
            ->first();
    }

}
