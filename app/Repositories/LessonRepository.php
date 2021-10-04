<?php

namespace App\Repositories;

use App\Abstracts\Repository;
use App\Events\LessonWatched;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class LessonRepository extends Repository
{


    protected $model;

    public function __construct(Lesson $model)
    {

        $this->model = $model;
    }

    public function lessonWatched(Lesson $lesson): void
    {
        $user = Auth::user();
        $user->lessons()
            ->attach($lesson->getAttribute('id'), ['watched' => true]);
        $this->fireLessonWatchEvent($lesson, $user);
        return;
    }


    public function findNextAndPrev($id): array
    {

        return [
            'next' => $this->getNext($id),
            'prev' => $this->getPrevious($id)
        ];
    }

    private function fireLessonWatchEvent(Lesson $lesson, $user): void
    {

        event(new LessonWatched($lesson, $user));
        return;
    }
}
