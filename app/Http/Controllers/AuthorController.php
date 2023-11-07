<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        LogActivity::makeLog("request to show all authors", $request);
        return Author::paginate($perPage = 5);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $author = Author::find($id);

        LogActivity::makeLog("request to show author with id {$id}", $request);

        if (!empty($author)) {
            return [
                'data' => $author,
                'books' => $author->books,
            ];
        }

        return response([
            'message' => 'Author Not Found',
        ], 404);

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

            LogActivity::makeLog("updating author with id {$id}", $request);

            return response([
                'message' => 'Your data has been updated',
                'status' => 'success',
                'data' => $author,
            ], 200);
        }

        LogActivity::makeLog("attempt to update author with id {$id}", $request);

        return response([
            'message' => 'You can\'t edit or delete another author',
            'status' => 'failed',
        ], 403);
    }

    public function destroy(Request $request, string $id)
    {
        if ($id == auth()->user()->id){

            Author::destroy($id);

            LogActivity::makeLog("author with id {$id} has left us", $request);

            return response([
                'message' => 'Goodbye Forever',
                'status' => 'success',
            ], 200);
        }

        LogActivity::makeLog("attempt to delete author with id {$id}", $request);

        return response([
            'message' => 'You can\'t edit or delete another author',
            'status' => 'failed',
        ], 403);
    }
}
