<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\ChapterDetailResource;
use App\Http\Resources\ChaptersResource;
use App\Repositories\ChapterRepository;
use App\Services\PaginatorService;
use Illuminate\Http\Request;

class ChapterController extends ApiBaseController
{
    /**
     * @var PaginatorService
     */
    private $paginatorService;
    /**
     * @var ChapterRepository
     */
    private $chapterRepository;

    public function __construct(ChapterRepository $chapterRepository, PaginatorService $paginatorService)
    {
        $this->middleware('auth:api', ['except' => ['index','detail']]);
        $this->chapterRepository = $chapterRepository;
        $this->paginatorService = $paginatorService;
    }

    public function index(Request $request){
        try {
            $page = $request->page ?? 1;
            $limit = $request->limit ?? false;
            $count = $this->chapterRepository->getChaptersByFilter($request, $page, $limit,true);
            $chapters = $this->chapterRepository->getChaptersByFilter($request, $page,$limit);
            $paginator = $this->paginatorService->getCustomPaginator($count, $page, $limit);
            return $this->respondWithPagination($this::SUCCESS_CODE, $paginator, ChaptersResource::collection($chapters));
        }catch (\Exception $e){
            return $e;
        }
    }

    public function detail(Request $request){
        $id = $request->id ?? '';

        if(!$id){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, 'Not Found');
        }
        $chapter = $this->chapterRepository->find($id);
        if(!$chapter){
            return $this->respondWithErrorMessageCode($this::ERR_ITEM_NOT_FOUND, trans('Not Found'));
        }
        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new ChapterDetailResource($chapter));
    }
}
