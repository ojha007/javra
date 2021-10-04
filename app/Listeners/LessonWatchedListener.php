<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Models\UserAchievement;
use App\Repositories\AchievementsRepository;
use App\Repositories\UserAchievementsRepository;
use App\Services\ListenerHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class LessonWatchedListener implements ShouldQueue
{

    use InteractsWithQueue;


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {


    }

    /**
     * Handle the event.
     *
     * @param LessonWatched $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {

        $userId = $event->user->id;
        $watchCount = DB::table('lesson_user')
            ->where('user_id', $userId)
            ->count(DB::raw('DISTINCT lesson_id'));
        $rules = (new ListenerHelpers())->getRuleCollection($event, $watchCount);
        (new UserAchievementsRepository(new UserAchievement()))->createBulkAchievements($rules, $userId);
    }


}
