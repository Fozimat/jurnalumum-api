<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return $this->sendResponse('', 'Pendaftaran Sukses', Response::HTTP_CREATED);
    }


    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            Auth::user()->tokens()->delete();

            $token = Auth::user()->createToken('api-token')->plainTextToken;

            $user = [
                'token' => $token,
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ];

            return $this->sendResponse($user, 'Login Sukses', Response::HTTP_OK);
        }

        return $this->sendError('Email atau password salah', Response::HTTP_UNAUTHORIZED);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse('', 'Logout Sukses', Response::HTTP_OK);
    }
}
