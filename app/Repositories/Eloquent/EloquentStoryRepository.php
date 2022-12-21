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

    public function getCategoryById($id){
        $categories = Categories::whereIn('id',json_decode( $id))->get();

        $arrData = [];
        foreach ($categories as $category){
            $arrData[] = $category->name;
        }
        return implode(', ', $arrData);
    }

    public function updateData($id, $data)
    {
        // TODO: Implement updateData() method.
        $story = $this->model->find($id);
        return $story ? $story->update($data) : FALSE;
    }

    public function getStoriesByFilter($request,$page = false, $limit = false, $count = false){
        $query = $this->model->query()->select('*')
        ->when($request->name,function ($query) use ($request){
            $key = $request->name;
            return $query->where('stories.name',"LIKE", "%{$key}%");
        });
        if($count){
            return $query->count();
        }
        if ($page && $limit) {
        $query = $query->offset(($page - 1) * $limit)->limit($limit);
    }
        return $query->get();
    }
}
