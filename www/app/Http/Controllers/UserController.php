<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function reg(UserRequest $request){
        $data = $request->validated();
        $user = User::create([
            'name'=>$data['name'],
            'email'=> $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            ]);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'success'=> true,
            'user'=>$user,
            'token' => $token,
        ], 201);
    }

    public function login(UserRequest $request){
        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();
        if (!$user){
            return response()->json([
                'success'=>false,
                'message'=>'Неверные данные авторизации'
            ], 401);
        }

        if(!Hash::check($data['password'], $user->password)){

            return response()->json([
                'success'=>false,
                'message'=>'Неверный пароль'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success'=> true,
            'message' => 'Выход совершен'
        ]);
    }
}
