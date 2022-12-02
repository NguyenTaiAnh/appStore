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
        $author = $this->model->find($id);
        return $author ? $author->update($data) : FALSE;
    }
}
