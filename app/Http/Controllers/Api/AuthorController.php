<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorSelectResource;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index()
    {
        return AuthorResource::collection(Author::get());
    }

    public function indexForSelect()
    {
        return AuthorSelectResource::collection(Author::get());
    }
}