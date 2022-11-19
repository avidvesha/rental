<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $validation = \Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validation->fails()) {
            return response()->json([
                'error' => $validation->errors()
            ], 422);
        }

        if(Auth::guard('admin')->attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ])) {
            $user = Auth::guard('admin')->user();

            $token =  $user->createToken('MyApp', ['admin'])->plainTextToken;

            return response()->json(['token' => $token]);
        }
    }

    public function userDetails(Request $request)
    {
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
