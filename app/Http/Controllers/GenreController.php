<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Genre::paginate($perPage = 5);
    }

    public function show(string $id)
    {
        return Genre::find($id);
    }
}
