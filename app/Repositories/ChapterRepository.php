<?php
namespace App\Repositories;

interface ChapterRepository extends BaseRepository
{
    public function getChapters();
    public function updateData($id, $data);
}
