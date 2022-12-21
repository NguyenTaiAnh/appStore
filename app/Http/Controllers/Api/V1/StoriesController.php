<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\StoriesResource;
use App\Models\Stories;
use App\Models\User;
use App\Repositories\StoryRepository;
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

    public function __construct(StoryRepository $storyRepository, PaginatorService $paginatorService)
    {
        $this->middleware('auth:api', ['except' => ['index','increaseViews']]);
        $this->storyRepository = $storyRepository;
        $this->paginatorService = $paginatorService;

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

    public function increaseViews(Request $request){
        $id = $request->story_id;
        if(!$id){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, 'Not Found');
        }
        $story = $this->storyRepository->find($id);
        if(!$story){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, trans('Not Found'));
        }
        $story->update(['view_story'=> $story->view_story + 1]);

        return response()->json([
            'message' =>'success',
            'data' => $story
        ]);
    }

    public function increaseFollow(Request $request){
//        $id_user = auth()->id();
//        $id_story = $request->story_id;
//        if(!$id_story){
//            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, 'Not Found');
//        }
//        $story = $this->storyRepository->find($id_story);
//        if(!$story){
//            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, trans('Not Found'));
//        }
//        User::where('id', auth()->user()->id)->update(
//            ['story_id' => json_encode($id_story, true)]
//        );
//        dd(json_decode(auth()->user()->story_id));
//        $story->update(['view_follow'=> $story->view_follow + 1]);
    }
}
