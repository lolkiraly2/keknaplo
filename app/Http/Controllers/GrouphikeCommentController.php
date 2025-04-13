<?php

namespace App\Http\Controllers;

use App\Models\GrouphikeComment;
use Inertia\Inertia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GrouphikeCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        GrouphikeComment::create($this->validateComment());

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function validateComment(): array
    {
        return request()->validate(
            [
                'comment' => ['min:0', 'max:500'],
                'grouphike_id' => ['required'],
                'user_id' => ['required'],
            ],
            [
                'comment.min' => "A hozzászólás nem lehet kevesebb mint :min karakter!",
                'comment.max' => "A hozzászólás nem lehet több mint :max karakter!",
            ]
        );
    }
}
