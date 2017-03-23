<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use JWTAuth;
use Hash;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        User::create($input);
        return response()->json(['result' => true]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $customClaims = ['foo' => 'bar', 'baz' => 'bob'];
        if (!$token = JWTAuth::attempt($input, $customClaims)) {
            return response()->json(['result' => 'wrong email or password.']);
        }
        return response()->json(['result' => $token]);
    }

    public function get_user_details(Request $request)
    {
        /*$input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        return response()->json(['result' => $user]);*/

        $token  = JWTAuth::parseToken()->toUser();
        return response()->json(['result' => $token]);
    }
}
