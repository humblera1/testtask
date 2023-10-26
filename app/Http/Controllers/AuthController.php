<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
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
            'password' => ['required', 'confirmed', 'string'],
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

        LogActivity::makeLog("registration of a new author with id {$author->id}", $request);

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

            LogActivity::makeLog("author login", $request);

            return response([
                'token' => $token,
                'message' => 'You are successfully login',
                'status' => 'success',
            ], 200);
        }

        LogActivity::makeLog("attempt to login with bad creds", $request);

        return response([
            'message' => 'Provided credentials are incorrect',
            'status' => 'failed',
        ], 401);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        LogActivity::makeLog("author logout", $request);

        return response([
            'message' => 'You are successfully logout',
            'status' => 'success',
        ], 200);
    }

    public function me()
    {
        return auth()->user();
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed'],
        ]);

        $author = auth()->user();
        $author->password = Hash::make($request->password);
        $author->save();

        LogActivity::makeLog("author {$author->username} changed password", $request);

        return response([
            'message' => 'Your password has been changed successfully',
            'status' => 'success',
        ], 200);
    }
}
