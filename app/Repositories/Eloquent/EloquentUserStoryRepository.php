<?php

namespace App\Repositories\Eloquent;

use App\Repositories\UserStoryRepository;

class EloquentUserStoryRepository extends EloquentBaseRepository implements UserStoryRepository
{
    public function getUserStoryById($id_user, $page = false, $limit = false, $count = false)
    {
        $query = $this->model->query()->select('*')->where('user_id', $id_user);
        if($count){
            return $query->count();
        }
        if ($page && $limit) {
            $query = $query->offset(($page - 1) * $limit)->limit($limit);
        }
        return $query->get();

    }
}
