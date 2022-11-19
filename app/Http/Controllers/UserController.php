<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FrontUser;
use Auth;

class UserController extends Controller
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

        if(Auth::guard('frontuser')->attempt([
            'email' => $input['email'],
            'password' => $input['password'],
        ])) {
            $user = Auth::guard('frontuser')->user();

            $token =  $user->createToken('MyApp', ['frontuser'])->plainTextToken;

            return response()->json(['token' => $token]);
        }
    }

    public function userDetails(Request $request)
    {
        $user = Auth::user();
        return response()->json(['data' => $user]);
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|unique:front_users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);

        $user = FrontUser::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('tokenku')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
        // return response()->json([
        //     'message' => 'Load Data Success!',
        //     'data' => $response
        // ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
