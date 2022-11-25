<?php

namespace App\Http\Controllers\Admin;

class ProfileController extends Controller
{
    public function dashboard(){
        $data=[
            'title'=>'Dashboard'
        ];
        return view('admin.dashboard',$data);
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('getLogin')->with('success','You have been successfully logged out');
    }
}
