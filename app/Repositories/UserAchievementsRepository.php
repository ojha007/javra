<?php

namespace App\Repositories;

use App\Abstracts\Repository;
use App\Models\UserAchievement;

class UserAchievementsRepository extends Repository
{

    protected $model;

    public function __construct(UserAchievement $model)
    {
        $this->model = $model;
    }

    public function createBulkAchievements($attributes, $userId)
    {
        $toSave = [];
        foreach ($attributes as $key => $attribute) {
            $toSave[$key] = [
                'user_id' => $userId,
                'achievement_id' => $attribute->achievement_id
            ];
        }
        return $this->bulkCreate($toSave);
    }

}
