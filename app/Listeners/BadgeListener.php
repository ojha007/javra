<?php

namespace App\Listeners;

use App\Models\UserBadge;
use App\Repositories\UserBadgeRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;


class BadgeListener implements ShouldQueue
{

    use InteractsWithQueue;

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

        $userId = $event->user->id;
        $countAchievement = DB::table('user_achievements')
            ->where('user_id', $userId)
            ->count();

        $rules = DB::table('badge_rules as br')
            ->select('br.id as badge_id', 'br.title')
            ->leftJoin('user_badges as ub', function ($q) use ($userId) {
                $q->on('ub.badge_id', '=', 'br.id')
                    ->where('ub.user_id', $userId);
            })
            ->where('br.rule', '<=', $countAchievement)
            ->whereNull('ub.id')
            ->orderBy('rule')
            ->get();
        if ($rules) {
            $toSave = [];
            foreach ($rules as $key => $rule) {
                $toSave [$key] = [
                    'badge_id' => $rule->badge_id,
                    'user_id' => $userId
                ];
            }
            (new UserBadgeRepository(new UserBadge()))->bulkCreate($toSave);
        }

    }
}
