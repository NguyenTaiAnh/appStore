<?php
namespace App\Repositories;

interface LevelRepository extends BaseRepository
{
    public function getLevels();
    public function updateData($id, $data);
}
