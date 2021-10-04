<?php

namespace App\Repositories;

use App\Abstracts\Repository;
use App\Models\UserBadge;

class UserBadgeRepository extends Repository
{

    protected $model;

    public function __construct(UserBadge $model)
    {
        $this->model = $model;
    }
}
