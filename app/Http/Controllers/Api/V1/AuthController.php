<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use JWTAuth;

class AuthController extends ApiBaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $checkEmail = User::where('email', $request->email)->first();
        if (!$checkEmail){
            return $this->respondWithError(trans('Email Is Not Registered'),$this::ERR_LOGIN_EMAIL_NOT_EXISTED);
        }
        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $user = Auth::user();
        if($user){
            $token = JWTAuth::fromUser($user);
            $user->update(
                [
                    'access_token' => $token
                ]
            );
        }else{
            return $this->respondWithError(trans('Email or Password is incorrect'),$this::LOGIN_FAILED);
        }

        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new UserResource($user));


    }

    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'avatar' => asset('assets/avatar/default/avatar_default.png'),
            'code' => Str::random(10)
        ]);

        $credentials = $request->only('email', 'password');
        Auth::attempt($credentials);
        $user = Auth::user();
        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new UserResource($user));

//        return response()->json([
//            'status' => 'success',
//            'message' => 'User created successfully',
//            'data' => $user,
//        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function profile()
    {
        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new UserResource(Auth::user()));
    }

    public function changePassWord(Request $request) {
        $request->validate([
            'old_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8',
        ]);
        User::where('id', auth()->user()->id)->update(
            ['password' => bcrypt($request->new_password)]
        );
        return $this->respondWithSuccessMessageCode($this::SUCCESS_CODE, new UserResource(auth()->user()));

    }

    //forgot password, change profile, resend mail, change password
}
