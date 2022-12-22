<?php

namespace App\Http\Resources;

use App\Models\UserStory;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userStory = UserStory::where('user_id', $this->id)->count();
        return [
            'token' => $this->access_token,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'avatar' => $this->avatar,
            'story_id' => $this->story_id,
            'login_ip' => $this->login_ip,
            'level' => $this->level,
            'status' => $this->status,
            'referent_code' => $this->referent_code,
            'verify_otp' => $this->verify_otp,
            'is_banned' => $this->is_banned,
            'total_story_follow'=> $userStory
        ];
    }
}
