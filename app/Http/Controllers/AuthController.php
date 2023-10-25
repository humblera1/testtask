<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'username' => ['required', 'string', 'unique:authors', 'max:255'],
            'email' => ['required', 'string', 'unique:authors,email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $author = Author::create([
            'username' => $fields['username'],
            'email' => $fields['email'],
            'password' =>bcrypt( $fields['password']),
        ]);

        $token = $author->createToken('trial')->plainTextToken;

        $response = [
            'user' => $author,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $author = Author::where('email', $fields['email'])->first();

        if ($author || Hash::check($fields['password'], $author->password)) {

            $token = $author->createToken('trial')->plainTextToken;

            return response([
                'token' => $token,
                'message' => 'login success',
                'status' => 'success',
            ], 200);
        }

        return response([
            'message' => 'u have a bad creds :(',
            'status' => 'failed',
        ], 401);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'logout success',
            'status' => 'success',
        ], 200);
    }

    public function logged_user()
    {
        $loggedUser = auth()->user();
    }

    public function test(Request $request)
    {
        return $request->all();
    }
}
