<?php
namespace App\Repositories;

interface UserStoryRepository extends BaseRepository
{
    public function getUserStoryById($id_user, $page = false, $limit = false, $count = false);
}
