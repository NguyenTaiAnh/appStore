<?php

namespace App\Repositories\Eloquent;

use App\Models\Author;
use App\Models\Categories;
use App\Repositories\StoryRepository;

class EloquentStoryRepository extends EloquentBaseRepository implements StoryRepository{
    public function getStories()
    {
        // TODO: Implement getStories() method.
        return $this->model->select('*');
    }

    public function getStoryById($id){
        $categories = Categories::whereIn('id',json_decode( $id))->get();

        $arrData = [];
        foreach ($categories as $category){
            $arrData[] = $category->name;
        }
        return implode(', ', $arrData);
    }

    public function getAuthorById($id){
        $categories = Author::whereIn('id',json_decode( $id))->get();

        $arrData = [];
        foreach ($categories as $category){
            $arrData[] = $category->name;
        }
        return implode(', ', $arrData);
    }
}
