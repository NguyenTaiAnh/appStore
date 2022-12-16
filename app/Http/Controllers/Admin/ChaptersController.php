<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChaptersRequest;
use App\Repositories\ChapterRepository;
use App\Repositories\StoryRepository;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;


class ChaptersController extends Controller
{
    /**
     * @var DataTables
     */
    private $dataTable;

    /**
     * @var StoryRepository
     */
    private $storyRepository;

    /**
     * @var ChapterRepository
     */
    private $chapterRepository;

    public function __construct(DataTables $dataTables, StoryRepository $storyRepository, ChapterRepository $chapterRepository){
        $this->dataTable = $dataTables;
        $this->chapterRepository = $chapterRepository;
        $this->storyRepository= $storyRepository;
    }

    public function index(){
        return view('admin.chapters.index');
    }

    public function datatable(Request $request){
        $chapters = $this->chapterRepository->getChapters();
        return $this->dataTable->eloquent($chapters)
            ->editColumn('created_at', function ($chapter) {
                return date('Y-m-d H:i:s', strtotime($chapter->created_at));
            })
            ->editColumn('updated_at', function ($chapter) {
                return date('Y-m-d H:i:s', strtotime($chapter->updated_at));
            })
            ->addColumn('action',function($chapter){
                return '<div class="btn-group action">
                        <a style="margin-right:5px" class="btn btn-primary btn-sm"
                        href="'. route('chapters.edit', $chapter->id).'">'. 'Edit' . '
                        </a>
                        <a style="margin-right:5px" class="btn btn-success btn-sm"
                        href="'. route('chapters.show', $chapter->id).'">'. 'View' . '
                        </a>
                    <form action="' . route('chapters.destroy', ['id' => $chapter->id]) . '"
                    method="POST" onsubmit="return confirm(' . "'" . 'Are You Sure' . "'" . ');"
                    style="display: inline-block;">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="submit" class="btn btn-sm btn-danger" value="' . 'Delete'. '">
                    </form>
                </div>';
            })
            ->rawColumns(['action'])->make(TRUE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stories = $this->storyRepository->getStories()->get();
        return  view('admin.chapters.create', compact('stories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ChaptersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChaptersRequest $request)
    {
        if ($this->chapterRepository->create($request->all())) {
            session()->flash('success_msg', 'Create chapter successfully');
        } else {
            session()->flash('error_msg', 'Create chapter failed');
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chapter = $this->chapterRepository->find($id);
        $stories = $this->storyRepository->getStories()->get();
        return  view('admin.chapters.view', compact('stories','chapter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chapter = $this->chapterRepository->find($id);
        $stories = $this->storyRepository->getStories()->get();
        return  view('admin.chapters.edit', compact('stories','chapter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ChaptersRequest $request, $id)
    {
        if ($this->chapterRepository->updateData($id, $request->all())) {
            session()->flash('success_msg', 'Update chapter successfully');
        } else {
            session()->flash('error_msg', 'Update chapter failed');
        }

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chapter = $this->chapterRepository->find($id);
        if ($chapter && $chapter->delete()) {
            session()->flash('success_msg', 'Delete chapter successfully');
        } else {
            session()->flash('success_msg', 'Delete chapter failed');
        }
        return back();
    }

}
