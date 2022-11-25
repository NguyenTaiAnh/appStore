<?php
namespace App\Repositories\Eloquent;

use App\Repositories\AuthorRepository;

class EloquentAuthorRepository extends EloquentBaseRepository implements AuthorRepository
{
    public function getAuthor()
    {
        // TODO: Implement getAuthor() method.
        return $this->model->select('*');
    }

    public function updateData($id, $data)
    {
        // TODO: Implement updateData() method.
        $author = $this->model->find($id);
        return $author ? $author->update($data) : FALSE;
    }
}
