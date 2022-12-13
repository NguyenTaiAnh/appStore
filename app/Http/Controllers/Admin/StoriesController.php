<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoriesRequest;
use App\Models\Author;
use App\Models\Categories;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\StoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class StoriesController extends Controller
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
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(DataTables $dataTable, StoryRepository $storyRepository, AuthorRepository $authorRepository, CategoryRepository $categoryRepository)
    {
        $this->dataTable = $dataTable;
        $this->storyRepository = $storyRepository;
        $this->categoryRepository = $categoryRepository;
        $this->authorRepository = $authorRepository;
    }

    public function index(){
        return view('admin.stories.index');
    }

    public function datatable(Request $request){
        $stories = $this->storyRepository->getStories($request);
        return $this->dataTable->eloquent($stories)
            ->editColumn('image', function ($story){
                $url = asset("/assets/images/stories/$story->image");
                return "<img src='$url' height='100px'>";
            })
            ->editColumn('status', function ($story){
                switch ($story->status){
                    case '0':
                        return "<span class='text-info'>NEW</span>";
                    case '1':
                        return "<span class='text-primary'>UPDATED</span>";
                    case '2':
                        return "<span class='text-warning'>PENDING</span>";
                    case '3':
                        return "<span class='text-success'>DONE</span>";
                    case '4':
                        return "<span class='text-secondary'>DROP</span>";
                    default:
                        return "<span class='text-danger'>ERROR</span>";
                };
            })
            ->editColumn('author',function ($story){
                $author = $this->authorRepository->find($story->author_id);
                return $author->name;
            })
            ->editColumn('category',function ($story){
                $categories = $this->storyRepository->getStoryById($story->category_id);
                return $categories;
            })
            ->editColumn('created_at', function ($story) {
                return date('Y-m-d H:i:s', strtotime($story->created_at));
            })
            ->editColumn('updated_at', function ($story) {
                return date('Y-m-d H:i:s', strtotime($story->updated_at));
            })
            ->addColumn('action',function($story){
                return '<div class="btn-group action">
                        <a style="margin-right:5px" class="btn btn-primary btn-sm"
                        href="'. route('stories.edit', $story->id).'">'. 'Edit' . '
                        </a>
                    <form action="' . route('stories.destroy', ['id' => $story->id]) . '"
                    method="POST" onsubmit="return confirm(' . "'" . 'Are You Sure' . "'" . ');"
                    style="display: inline-block;">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="submit" class="btn btn-sm btn-danger" value="' . 'Delete'. '">
                    </form>
                </div>';
            })
            ->rawColumns(['action','image','status'])->make(TRUE);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Categories::all();
        $authors = Author::all();
        return view('admin.stories.create', compact('categories', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoriesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoriesRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            // Thư mục upload
            $path = public_path() . '/assets/images/stories';

            $data['image'] = $name;
            $data['category_id']=json_encode($data['category_id'], true);
            $this->storyRepository->create($data);
            Session::flash('success_msg', 'Successfully Saved');

            // Bắt đầu chuyển file vào thư mục
            $image->move($path, $name);
        }
        return redirect()->route('stories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $story = $this->storyRepository->find($id);
        $categories = Categories::all();
        $authors = Author::all();
        return view('admin.stories.update',compact('story', 'categories', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoriesRequest $request, $id)
    {
        $story = $this->storyRepository->find($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if($data['image']->getClientOriginalName() === $story->image){
                $data['image'] = $story->image;
                $data['category_id']=json_encode($data['category_id'], true);
                $this->storyRepository->updateData($id,$data);
            }else{
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();

                $data['image'] = $name;
                $data['category_id']=json_encode($data['category_id'], true);
                $this->storyRepository->updateData($id,$data);

                // Thư mục upload
                $path = public_path() . '/assets/images/stories';
                // Bắt đầu chuyển file vào thư mục
                $image->move($path, $name);
            }
            Session::flash('success_msg', 'Successfully Saved');


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
        $story = $this->storyRepository->find($id);
        if ($story && $story->delete()) {
            session()->flash('success_msg', 'Delete story successfully');
        } else {
            session()->flash('success_msg', 'Delete story failed');
        }
        return back();
    }

    public function delImage($id){
        $story = $this->storyRepository->find($id);
        $path = public_path() . '/assets/images/stories/'. $story->image;

        if(File::exists($path)) {
            File::delete($path);
            $story->image = null;
            $story->save();
        }
    }
}
