<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Models\Categories;

class StoriesController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index(){
        $cate = Categories::all();
        return response()->json([
           'data' => $cate
        ]);
    }
}
