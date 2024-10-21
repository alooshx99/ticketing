<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $attributes['email'])->first();


        if (Auth::attempt($request->only('email','password'))){
            $user = Auth::user();
           // $token = $user->createToken('auth_token')->plainTextToken;
            $token = $user->createToken('API Token')->plainTextToken;


            return response()->json(['token' => $token]);

        }

        return Response::json(['message' => 'Wrong Information']);
    }
}
