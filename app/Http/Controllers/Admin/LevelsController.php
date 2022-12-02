<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LevelsRequest;
use App\Models\Levels;
use App\Repositories\LevelRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;

class LevelsController extends Controller
{
    /**
     * @var DataTables
     */
    private $dataTable;

    /**
     * @var LevelRepository
     */
    private $levelRepository;

    public function __construct(DataTables $dataTable, LevelRepository $levelRepository)
    {
        $this->dataTable = $dataTable;
        $this->levelRepository = $levelRepository;
    }

    public function index(){
        return view('admin.levels.index');
    }

    public function datatable(Request $request){
        $level = $this->levelRepository->getLevels($request);
        return $this->dataTable->eloquent($level)
            ->editColumn('created_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->created_at));
            })
            ->editColumn('updated_at', function ($user) {
                return date('Y-m-d H:i:s', strtotime($user->updated_at));
            })
            ->addColumn('action',function($level){
                return '<div class="btn-group action">
                    <form action="' . route('levels.destroy', ['id' => $level->id]) . '"
                    method="POST" onsubmit="return confirm(' . "'" . 'Are You Sure' . "'" . ');"
                    style="display: inline-block;">
                        <input type="hidden" name="_method" value="POST">
                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                        <input type="submit" class="btn btn-sm btn-danger" value="' . 'Delete'. '">
                    </form>
                    <button data-toggle="modal" data-target="#myModalEdit" class="level-edit btn btn-info btn-sm" data-id="'.$level->id.'">'.'Edit'.'</button>
                </div>';
            })
            ->rawColumns(['action'])->make(TRUE);
    }

    public function store(LevelsRequest $request)
    {
        $level = Levels::where('name', $request->name)->first();
        if($level){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        if ($this->levelRepository->create($request->all())) {
            session()->flash('success_msg', 'Create level successfully');
        } else {
            session()->flash('error_msg', 'Create level failed');
        }

        return back();
    }

    public function show($id)
    {
        return response($this->levelRepository->find($id), Response::HTTP_OK);
    }


    public function update(LevelsRequest $request)
    {
        $level_id = $request->input('level_id');
        $level = Levels::where('name', $request->name)->first();
        if($level){
            session()->flash('error_msg', 'Already exist');
            return back();
        }
        if ($this->levelRepository->updateData($level_id, $request->all())) {
            session()->flash('success_msg', 'Update level successfully');
        } else {
            session()->flash('error_msg', 'Update level failed');
        }

        return back();
    }

    public function destroy($id)
    {
        $level = $this->levelRepository->find($id);
        if ($level && $level->delete()) {
            session()->flash('success_msg', 'Delete level successfully');
        } else {
            session()->flash('success_msg', 'Delete level failed');
        }
        return back();
    }
}
