<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\CategoriesResource;
use App\Repositories\CategoryRepository;

class CategoriesController extends ApiBaseController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('auth:api', ['except' => ['index','detail']]);
        $this->categoryRepository= $categoryRepository;
    }

    public function index(){
        $category = $this->categoryRepository->getCategories()->get();
        if($category){
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, CategoriesResource::collection($category) );
        }else{
            return $this->respondNotFound();
        }
    }

    public function detail($id){
        $category = $this->categoryRepository->find($id);
        if($category){
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new CategoriesResource($category) );
        }else{
            return $this->respondNotFound();
        }
    }
}
