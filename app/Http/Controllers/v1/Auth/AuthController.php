<?php

namespace App\Http\Controllers\v1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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
            return response()->json([
                'code' => 422,
                'success' => false,
                'messages' => 'Pendaftaran Gagal',
                'errors' => $validator->errors(),
            ]);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return response()->json([
            'code' => 201,
            'success' => true,
            'messages' => 'Pendaftaran Sukses',
            'data' => $user,
        ]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'code' => 422,
                'success' => false,
                'messages' => 'Login Gagal',
                'errors' => $validator->errors(),
            ]);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = Auth::user()->createToken('api-token')->plainTextToken;
            return response()->json([
                'code' => 200,
                'success' => true,
                'messages' => 'Login Sukses',
                'token' => $token,
            ]);
        }

        return response()->json([
            'code' => 401,
            'success' => false,
            'messages' => 'Email atau password salah',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'code' => 200,
            'success' => true,
            'messages' => 'Berhasil Logout',
        ]);
    }
}
