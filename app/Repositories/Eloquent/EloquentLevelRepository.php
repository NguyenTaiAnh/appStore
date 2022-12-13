<?php
namespace App\Repositories\Eloquent;

use App\Repositories\LevelRepository;

class EloquentLevelRepository extends EloquentBaseRepository implements LevelRepository
{
    public function getLevels()
    {
        // TODO: Implement getCategories() method.
        return $this->model->select('*');
    }

    public function updateData($id, $data)
    {
        // TODO: Implement updateData() method.
        $level = $this->model->find($id);
        return $level ? $level->update($data) : FALSE;
    }
}
