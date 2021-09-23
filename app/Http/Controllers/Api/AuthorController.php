<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
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

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function store(StoreAuthorRequest $request)
    {
        $author = Author::create($request->validated());

        return response()->json(['author' => new AuthorResource($author)], 201);
    }

    public function update(UpdateAuthorRequest $request, Author $author)
    {
        $author->update($request->validated());

        return response()->json(['author' => new AuthorResource($author)], 201);
    }
}