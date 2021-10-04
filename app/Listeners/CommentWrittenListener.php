<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Models\UserAchievement;
use App\Repositories\UserAchievementsRepository;
use App\Services\ListenerHelpers;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CommentWrittenListener implements ShouldQueue
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
     * @param CommentWritten $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        $userId = $event->user->id;
        try {
            $commentCount = DB::table('lesson_comments')
                ->where('user_id', $event->user->id)
                ->count(DB::raw('DISTINCT lesson_id'));
            $rules = (new ListenerHelpers())->getRuleCollection($event, $commentCount);

            (new UserAchievementsRepository(new UserAchievement()))->createBulkAchievements($rules, $userId);
        } catch (\Exception $exception) {
            dd($exception);
        }


    }

}
