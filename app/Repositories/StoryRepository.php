<?php
namespace App\Repositories;

interface StoryRepository extends BaseRepository
{
    public function getStories();
    public function getStoryById($id);
    public function getAuthorById($id);
}
