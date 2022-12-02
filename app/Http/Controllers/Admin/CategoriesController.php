<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesRequest;
use App\Models\Categories;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;


class CategoriesController extends Controller
{
    /**
     * @var DataTables
     */
    private $dataTable;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository, DataTables $dataTable){
        $this->categoryRepository = $categoryRepository;
        $this->dataTable = $dataTable;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    public function datatable(Request $request){
        $category = $this->categoryRepository->getCategories($request);
        return $this->dataTable->eloquent($category)
            ->editColumn('created_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->created_at));
            })
            ->editColumn('updated_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->updated_at));
            })
            ->addColumn('action',function($category){
                return '<div class="btn-group action">
                    <form action="' . route('categories.destroy', ['id' => $category->id]) . '"
                    method="POST" onsubmit="return confirm(' . "'" . 'Are You Sure' . "'" . ');"
                    style="display: inline-block;">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="submit" class="btn btn-sm btn-danger" value="' . 'Delete'. '">
                    </form>
                    <button data-toggle="modal" data-target="#myModalEdit" class="category-edit btn btn-info btn-sm" data-id="'.$category->id.'">'.'Edit'.'</button>
                </div>';
            })
            ->rawColumns(['action'])->make(TRUE);
    }

    public function store(CategoriesRequest $request)
    {
        $category = Categories::where('name', $request->name)->first();
        if($category){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        if ($this->categoryRepository->create($request->all())) {
            session()->flash('success_msg', 'Create category successfully');
        } else {
            session()->flash('error_msg', 'Create category failed');
        }

        return back();
    }

    public function show($id)
    {
        return response($this->categoryRepository->find($id), Response::HTTP_OK);
    }


    public function update(CategoriesRequest $request)
    {
        $category_id = $request->input('category_id');
        $category = Categories::where('name', $request->name)->first();
        if($category){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        if ($this->categoryRepository->updateData($category_id, $request->all())) {
            session()->flash('success_msg', 'Update category successfully');
        } else {
            session()->flash('error_msg', 'Update category failed');
        }

        return back();
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->find($id);
        if ($category && $category->delete()) {
            session()->flash('success_msg', 'Delete category successfully');
        } else {
            session()->flash('success_msg', 'Delete category failed');
        }
        return back();
    }
}
