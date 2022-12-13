<?php

namespace App\Repositories\Eloquent;

use App\Repositories\ChapterRepository;

class EloquentChapterRepository extends EloquentBaseRepository implements ChapterRepository
{
    public function getChapters()
    {
        // TODO: Implement getStories() method.
        return $this->model->select('*');
    }

    public function updateData($id, $data)
    {
        // TODO: Implement updateData() method.
        $chapter = $this->model->find($id);
        return $chapter ? $chapter->update($data) : FALSE;
    }
}
