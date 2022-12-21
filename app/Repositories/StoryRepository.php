<?php
namespace App\Repositories;

interface StoryRepository extends BaseRepository
{
    public function getStories();
    public function getCategoryById($id);
    public function updateData($id, $data);
    public function getStoriesByFilter($request,$page = false, $limit = false, $count = false);
}
