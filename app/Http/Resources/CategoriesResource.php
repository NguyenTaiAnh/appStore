<?php

namespace App\Http\Resources;

use App\Models\Stories;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $stories = Stories::where('category_id', 'like', '%' . $this->id . '%')->get(['id','name']);
        return [
          'name'=>$this->name,
          'description' => $this->description,
          'stories' => $stories
        ];
    }
}
