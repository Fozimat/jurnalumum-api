<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:64',
            'email' => 'required|string|email|unique:users|max:64',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->sendResponse('', 'Pendaftaran Sukses', Response::HTTP_CREATED);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->sendError($validator->errors()->all(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

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
