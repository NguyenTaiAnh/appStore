<?php

namespace App\Http\Resources;

use App\Models\Stories;
use App\Repositories\StoryRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class StoryDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        switch ($this->status){
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
            'id' => $this->id,
            'name'=> $this->name,
            'description' => $this->description,
            'image' => asset("/assets/images/stories/$this->image"),
            'category'=> $this->categoryName($this->category_id),
            'author' => $this->Author->name,
            'rate' => $this->rate,
            'status' =>$status,
            'chapter'=>ChapterDetailResource::collection($this->Chapters),
            'view_follow' => $this->view_follow,
            'view_like' =>$this->view_like,
            'view_story' =>$this->view_story
        ];
    }
}
