<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\StoriesResource;
use App\Http\Resources\UserStoryResource;
use App\Models\Stories;
use App\Models\User;
use App\Models\UserStory;
use App\Repositories\StoryRepository;
use App\Repositories\UserStoryRepository;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class StoriesController extends ApiBaseController
{
    /**
     * @var StoryRepository
     */
    private $storyRepository;
    /**
     * @var PaginatorService
     */
    private $paginatorService;
    /**
     * @var UserStoryRepository
     */
    private $userStoryRepository;

    public function __construct(StoryRepository $storyRepository, PaginatorService $paginatorService, UserStoryRepository $userStoryRepository)
    {
        $this->middleware('auth:api', ['except' => ['index','increaseViews','detail']]);
        $this->storyRepository = $storyRepository;
        $this->paginatorService = $paginatorService;
        $this->userStoryRepository = $userStoryRepository;

    }

    public function index(Request $request){
        try {
            $page = $request->page ?? 1;
            $limit = $request->limit ?? false;
            $count = $this->storyRepository->getStoriesByFilter($request, $page, $limit,true);
            $stories = $this->storyRepository->getStoriesByFilter($request, $page,$limit);
            $paginator = $this->paginatorService->getCustomPaginator($count, $page, $limit);
            return $this->respondWithPagination($this::SUCCESS_CODE, $paginator, StoriesResource::collection($stories));
        }catch (\Exception $e){
            return $e;
        }
    }

    public function detail($id){
        $story = $this->storyRepository->find($id);
        if($story){
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE,$story );
        }else{
            return $this->respondNotFound();
        }
    }

    public function increaseViews(Request $request){
        $id = $request->story_id;
        $checkReadStory = $request->chapter_id;
        if($checkReadStory){
            if(!$id){
                return $this->respondNotFound();
            }
            $story = $this->storyRepository->find($id);
            if(!$story){
                return $this->respondNotFound();
            }
            $story->update(['view_story'=> $story->view_story + 1]);
            return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new StoriesResource($story));
        }else{
            return $this->respondNotFound();
        }

    }

    public function increaseFollow(Request $request){
        $id_story = $request->story_id;
        $check = UserStory::where("user_id",auth()->user()->id)->where('story_id', $request->story_id)->first();

        if(!$id_story){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, 'Not Found');
        }
        $story = $this->storyRepository->find($id_story);
        if(!$story){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, trans('Not Found'));
        }
        if (!isset($check)){
            $add = new UserStory();
            $add->user_id = auth()->user()->id;
            $add->story_id = $request['story_id'];
            $add->save();
            $story->update(['view_follow'=> $story->view_follow + 1]);
        }
        $page = $request->page ?? 1;
        $limit = $request->limit ?? false;
        $count = $this->userStoryRepository->getUserStoryById(auth()->user()->id, $page, $limit,true);
        $userStory = $this->userStoryRepository->getUserStoryById(auth()->user()->id, $page,$limit);
        $paginator = $this->paginatorService->getCustomPaginator($count, $page, $limit);
        return $this->respondWithPagination($this::SUCCESS_CODE, $paginator, UserStoryResource::collection($userStory));
    }

    public function increaseLike(Request $request){
        $id = $request->story_id;
        if(!$id){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, 'Not Found');
        }
        $story = $this->storyRepository->find($id);
        if(!$story){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, trans('Not Found'));
        }
        $story->update(['view_like'=> $story->view_like + 1]);

        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new StoriesResource($story));
    }
}
