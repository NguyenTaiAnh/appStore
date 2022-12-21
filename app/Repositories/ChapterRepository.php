<?php
namespace App\Repositories;

interface ChapterRepository extends BaseRepository
{
    public function getChapters();
    public function updateData($id, $data);
    public function getChaptersByFilter($request,$page = false, $limit = false, $count = false);
}
