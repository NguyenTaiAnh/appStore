<?php

namespace App\Http\Controllers\Admin;

class UserController extends Controller
{
    public function index(){
        $data=[
            'title'=>'Users'
        ];
        return view('admin.users.index',$data);
    }
}
