<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'image'=>'required',
            'status'=>'required',
            'start_date'=>'required',
            'author_id'=>'required',
            'category_id'=>'required',
            'description'=>'required'
        ];
    }
}
