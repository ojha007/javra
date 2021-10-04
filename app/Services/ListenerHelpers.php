<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ListenerHelpers
{

    public function getRuleCollection($event, $count): Collection
    {
        $userId = $event->user->id;
        return DB::table('achievements_rules as ar')
            ->select('ar.id as achievement_id', 'ar.title')
            ->leftJoin('user_achievements as ua', function ($q) use ($userId) {
                $q->on('ar.id', '=', 'ua.achievement_id')
                    ->where('ua.user_id', $userId);
            })
            ->where('ar.rule', '<=', $count)
            ->where('type', $event->type)
            ->whereNull('ua.id')
            ->orderBy('ar.rule')
            ->get();
    }


}

