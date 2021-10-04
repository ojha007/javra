<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use Illuminate\Support\Facades\DB;

class CommentWrittenListener
{

//    use InteractsWithQueue;


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

        $commentCount = DB::table('lesson_comments')
            ->where('user_id', $event->user->id)
            ->count(DB::raw('DISTINCT lesson_id'));


        $rule = DB::table('achievements_rules')
            ->select('id')
            ->where('type', $event->type)
            ->where('rule', $commentCount)
            ->first();

        if ($rule) {
            $event
                ->user
                ->achievements()
                ->updateOrCreate(['achievement_id' => $rule->id], ['achievement_id' => $rule->id]);
        }

    }
}
