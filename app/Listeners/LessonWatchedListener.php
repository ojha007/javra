<?php

namespace App\Listeners;

use App\Events\LessonWatched;
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


        $watchCount = DB::table('lesson_user')
            ->where('user_id', $event->user->id)
            ->count(DB::raw('DISTINCT lesson_id'));

        $rule = DB::table('achievements_rules')
            ->where('type', $event->type)
            ->where('rule', $watchCount)
            ->first();

        if ($rule) {
            $event
                ->user
                ->achievements()
                ->updateOrCreate(['achievement_id' => $rule->id], ['achievement_id' => $rule->id]);
        }

    }
}
