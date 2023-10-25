<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Author::paginate($perPage = 5);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::find($id);

        return [
            'data' => $author,
            'books' => $author->books,
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($id == auth()->user()->id){

            $author = Author::find($id);

            $fields = $request->validate([
                'username' => ['unique:authors,username', 'string', 'max:255'],
                'email' => ['email'],
            ]);

            $author->update($fields);

            return response([
                'message' => 'your data has been updated',
                'status' => 'success',
                'data' => $author,
            ], 200);
        }

        return response([
            'message' => 'oops bad creds',
            'status' => 'failed',
        ], 403);
    }
}
