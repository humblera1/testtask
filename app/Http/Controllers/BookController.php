<?php

namespace App\Http\Controllers;

use App\Enums\BookTypeEnum;
use App\Models\Author;
use App\Models\Book;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::paginate($perPage = 5);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => ['required', 'string', 'unique:books', 'max:255'],
            'type' => [new Enum(BookTypeEnum::class)],
            'genre' => ['required', Rule::in(Genre::pluck('name'))],
        ]);

        $fields['author_id'] = auth()->user()->id;


        $model = Book::create($fields);

        $genre = Genre::where(['name' => $fields['genre']])->first();

        $model->genres()->attach($genre->id);

        return response($model);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Book::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (auth()->user()->id === $book->author_id) {

        $fields = $request->validate([
            'title' => ['string', 'unique:books', 'max:255'],
            'type' => [new Enum(BookTypeEnum::class)],
            'genre' => [Rule::in(Genre::pluck('name'))],
        ]);

            $book->update($request->all());

            //Логика сохранения жанра книги: если передать новый жанр, которого у книги нет,
            //он будет добавлен; если передать его повторно, он будет удалён

            if ($genre = Genre::where(['name' => $fields['genre']])->first()) {
                $book->genres()->toggle($genre->id);
            }

            return $book;
        }

        return response([
            'message' => 'This book belongs to another author. You can\'t edit or delete it',
            'status' => 'failed',
        ], 403);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (auth()->user()->id === $book->author_id) {

            Book::destroy($id);

            return response([
                'message' => 'Book has been deleted',
                'status' => 'success',
            ], 200);

        }

        return response([
            'message' => 'This book belongs to another author. You can\'t edit or delete it',
            'status' => 'failed',
        ], 403);
    }
}
