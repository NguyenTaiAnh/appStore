<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Response;


class AuthorController extends Controller
{
    /**
     * @var AuthorRepository
    */
    private $authorRepository;

    /**
     * @var DataTables
    */
    private $dataTable;



    public function __construct(AuthorRepository $authorRepository, DataTables $dataTable){
        $this->authorRepository = $authorRepository;
        $this->dataTable = $dataTable;
    }

    public function index(){
        return view('admin.author.index');
    }

    public function datatable(Request $request){
        $author = $this->authorRepository->getAuthor($request);
        return $this->dataTable->eloquent($author)
            ->editColumn('name', function ($author) {
                return $author->name;
            })
            ->editColumn('created_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->created_at));
            })
            ->editColumn('updated_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->updated_at));
            })
            ->addColumn('action',function($author){
                return '<div class="btn-group action">
                    <form action="' . route('author.destroy', ['id' => $author->id]) . '"
                    method="POST" onsubmit="return confirm(' . "'" . 'Are You Sure' . "'" . ');"
                    style="display: inline-block;">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="submit" class="btn btn-sm btn-danger" value="' . 'Delete'. '">
                    </form>
                    <button data-toggle="modal" data-target="#myModalEdit" class="author-edit btn btn-info btn-sm" data-id="'.$author->id.'">'.'Edit'.'</button>
                </div>';
            })
            ->rawColumns(['action'])->make(TRUE);
    }

    public function store(AuthorRequest $request){
        $author = Author::where('name', $request->name)->first();
        if($author){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        if ($this->authorRepository->create($request->all())) {
            session()->flash('success_msg', 'Create author successfully');
        } else {
            session()->flash('error_msg', 'Create author failed');
        }

        return back();
    }

    public function update(AuthorRequest $request) {
        $author = Author::where('name', $request->name)->first();
        if($author){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        $author_id = $request->input('author_id');
        if ($this->authorRepository->updateData($author_id, $request->all())) {
            session()->flash('success_msg', 'Update author successfully');
        } else {
            session()->flash('error_msg', 'Update author failed');
        }

        return back();
    }

    public function destroy($id) {
        $author = $this->authorRepository->find($id);
        if ($author && $author->delete()) {
            session()->flash('success_msg', 'Delete author successfully');
        } else {
            session()->flash('success_msg', 'Delete author failed');
        }
        return back();
    }

    public function show($id){
        return response($this->authorRepository->find($id), Response::HTTP_OK);
    }
}
