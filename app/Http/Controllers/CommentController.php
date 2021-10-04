<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Responses\ErrorResponse;
use App\Http\Responses\SuccessResponse;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\LessonRepository;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $viewPath = 'lessons.';
    /**
     * @var LessonRepository
     */
    protected $repository;

    /**
     *
     */
    public function __construct()
    {
        $this->repository = new CommentRepository(new Comment());
    }


    /**
     * @param CommentRequest $request
     * @return ErrorResponse|SuccessResponse
     */
    public function store(CommentRequest $request)
    {
        $attributes = $request->validated();
        try {
            $attributes['user_id'] = Auth::id();
            $comment = $this->repository->create($attributes);
            $this->repository->commentWritten($comment);
            return new SuccessResponse();
        } catch (\Exception $exception) {
            return new ErrorResponse($exception);
        }
    }
}
