<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserStoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $image = $this->story->image;
        switch ($this->story->status){
            case '0':
                $status = 'New';
                break;
            case '1':
                $status = 'Update';
                break;
            case '2':
                $status = 'Pending';
                break;
            case '3':
                $status = 'Done';
                break;
            case '4':
                $status = 'Drop';
                break;
            default:
                $status ='';
        }
        return [
            'name' => $this->story->name,
            'image' => asset("/assets/images/stories/$image"),
            'category'=> $this->story->categoryName($this->story->category_id),
            'author_id' => $this->story->Author,
            'rate' => $this->story->rate,
            'status' =>$status,
            'chapter'=>NameStoryResource::collection($this->story->Chapters),
            'view_follow' => $this->story->view_follow,
            'view_like' =>$this->story->view_like,
            'view_story' =>$this->story->view_story
        ];
    }
}
