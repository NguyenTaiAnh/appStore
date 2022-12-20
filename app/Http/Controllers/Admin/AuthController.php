<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin(){
        if(Auth::check() === true){
            \auth()->logout();
        }
        return view('admin.auth.login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $validated=auth()->attempt([
            'email'=>$request->email,
            'password'=>$request->password,
            // 'is_admin'=>1
        ],$request->password);

        if($validated){

            return redirect()->route('dashboard')->with('success','Login Successfull');
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }
    }

    public function getRegister() {
        return view('admin.auth.register');
    }
    public function postRegister(Request $request){

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'password_confirmation' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // return $validator->errors()->all();
        // dd($request);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'is_admin' => '1',
            'password' => Hash::make($request['password']),
        ]);

        if($user){
            return redirect()->route('dashboard')->with('success','Login Successfull');
        }else{
            return redirect()->back()->with('error','Invalid credentials');
        }
    }
}
