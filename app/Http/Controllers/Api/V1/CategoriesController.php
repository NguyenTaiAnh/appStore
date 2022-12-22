<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Repositories\CategoryRepository;

class CategoriesController extends ApiBaseController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->categoryRepository= $categoryRepository;
    }

    public function index(){
        $data = $this->categoryRepository->getCategories()->get();
        return response()->json([
           'message' => 200,
           'data' =>$data
        ]);
    }
}
