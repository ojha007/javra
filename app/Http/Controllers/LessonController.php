<?php

namespace App\Http\Controllers;

use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Lesson;
use App\Repositories\LessonRepository;

class LessonController extends Controller
{
    protected $viewPath = 'lessons.';
    /**
     * @var LessonRepository
     */
    protected $repository;

    public function __construct()
    {
        $this->repository = new LessonRepository(new Lesson());
    }

    public function show(Lesson $lesson)
    {
        try {
            $this->repository->lessonWatched($lesson);
            $others = $this->repository->findNextAndPrev($lesson->id);
            $data = array_merge(['lesson' => $lesson], $others);
            return new SuccessResponse($this->viewPath . 'show', $data);
        } catch (\Exception $exception) {
            return new ErrorResponse($exception);
        }

    }
}
