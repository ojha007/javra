<?php

namespace App\Repositories;

use App\Abstracts\Repository;
use App\Models\Lesson;

class HomeRepository extends Repository
{
    public function __construct()
    {
    }

    public function index($limit)
    {
        return (new LessonRepository(new Lesson()))->paginate($limit ?: 20);

    }
}
