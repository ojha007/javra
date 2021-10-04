<?php

namespace App\Repositories;

use App\Abstracts\Repository;
use App\Events\CommentWritten;
use App\Events\LessonWatched;
use App\Models\Comment;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;

class CommentRepository extends Repository
{


    /**
     * @var Comment
     */
    protected $model;

    /**
     * @param Comment $model
     */
    public function __construct(Comment $model)
    {

        $this->model = $model;
    }

    /**
     * @param Comment $comment
     */
    public function commentWritten(Comment $comment): void
    {
        $user = Auth::user();
        event(new CommentWritten($comment,$user));
    }

}
