<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $result = new User($request->all());
        $result->password = Hash::make($request->password);
        $result->save();
        $tokenResult = $result->createToken('token-key');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => ['access_token' => $tokenResult->accessToken, 'user' => $result]
        ]);
    }

    public function login(Request $request)
    {
        $arr = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (Auth::attempt($arr)) {
            $user = Auth::user();
            $tokenResult = $user->createToken('token-key');
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => [
                    'access_token' => $tokenResult->accessToken,
                    'user' => $user,
                ]
            ]);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->authAccessToken()->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success',
                'data' => ''
            ]);
        }
    }

    public function user_all()
    {
        $user = User::all();
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $user
        ]);
    }
}
