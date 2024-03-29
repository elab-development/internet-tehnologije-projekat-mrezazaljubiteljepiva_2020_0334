<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            //'password'=>'required|string|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/',
            'nickname'=>'required|string|max:20'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'username'=> $request->username,
            'email'=> $request->email,
            'password'=>Hash::make($request->password),
            'nickname'=>$request->nickname,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['data'=> $user, 'access_token'=> $token, 'token_type'=> 'Bearer']);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=> 'Unauthorised'], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['message'=>'Zdravo '.$user->username.', dobrodosao nazad','access_token'=>$token, 'token_type'=>'Bearer']);
    } 
    
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Izlogovao si se']);
    }
}
