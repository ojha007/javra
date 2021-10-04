<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;


class BadgeListener
{

//    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param    $event
     * @return void
     */
    public function handle($event)
    {

        $countAchievement = DB::table('user_achievements')
            ->where('user_id', $event->user->id)
            ->count();
        $defaultBadge = $event->user->badges()->count();
        if ($defaultBadge==0) {
            $badge = DB::table('badge_rules')
                ->where('sequence', '=', 1)
                ->first();
            $event->user->badges()->create(['badge_id' => $badge->id]);
        } else {
            $badgeRule = DB::table('badge_rules')
                ->where('rule', '=', $countAchievement)
                ->first();
            if ($badgeRule) {
                $event
                    ->user
                    ->badges()
                    ->updateOrCreate(['badge_id' => $badgeRule->id], ['badge_id' => $badgeRule->id]);
            }
        }

    }
}
