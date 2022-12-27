<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\AuthorResource;
use App\Repositories\AuthorRepository;

class AuthorController extends ApiBaseController
{
    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    public function __construct(AuthorRepository $authorRepository)
    {
        $this->middleware('auth:api', ['except' => ['index','detail']]);
        $this->authorRepository= $authorRepository;
    }

    public function index(){
        $author = $this->authorRepository->getAuthor()->get();
        if($author){
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, AuthorResource::collection($author) );
        }else{
            return $this->respondNotFound();
        }
    }

    public function detail($id){
        $author = $this->authorRepository->find($id);
        if($author){
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new AuthorResource($author) );
        }else{
            return $this->respondNotFound();
        }
    }
}
