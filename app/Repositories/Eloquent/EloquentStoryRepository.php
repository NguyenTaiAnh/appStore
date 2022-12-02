<?php

namespace App\Repositories\Eloquent;

use App\Models\Categories;
use App\Repositories\StoryRepository;

class EloquentStoryRepository extends EloquentBaseRepository implements StoryRepository{
    public function getStories()
    {
        // TODO: Implement getStories() method.
        return $this->model->select('*');
    }

    public function getStoryById($id){
        $categories = Categories::whereIn('id',json_decode( $id));

        $arrData = [];
        foreach ($categories as $category){
            dd($category->name);
            $arrData = array_push($category->name);
        }
        return $arrData;
    }
}
