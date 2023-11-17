<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Termwind\Components\Hr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Membuat Fitur Register
    public function register(Request $request)
    {
        // Menangkap inputan
        $input = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => hash::make($request->password)
        ];

        // Membuat user baru ke table user
        $user = User::Create($input);

        $data = [
            'message' => 'user is created successfully'
        ];

        // mengirim response
        return response()->json($data, 200);
    }

    // Membuat Fitur Login
    public function login(Request $request)
    {
        // Menangkap inputan
        $input = [
            'email' => $request->email,
            'password' => $request->password
        ];

        // Mencocokan inputan dengan data di database
        if (Auth::attempt($input)) {
            $token = Auth::user()->createToken('auth_token');

            $data = [
                'message' => 'Login Successfully',
                'token' => $token->plainTextToken
            ];

            // mengirim response
            return response()->json($data, 200);
        } else {
            $data = [
                'message' => 'Login Failed'
            ];

            // mengirim response
            return response()->json($data, 401);
        }
    }
}