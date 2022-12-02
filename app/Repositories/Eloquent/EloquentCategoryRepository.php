<?php
namespace App\Repositories\Eloquent;

use App\Repositories\CategoryRepository;

class EloquentCategoryRepository extends EloquentBaseRepository implements CategoryRepository
{
    public function getCategories()
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
