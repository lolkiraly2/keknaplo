<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\StampComment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class StampCommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        StampComment::create($this->validateComment());

        return redirect()->back();
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
                'detection' => ['required'],
                'state' => ['required'],
                'comment' => ['min:0', 'max:250'],
                'stamp_mtsz_id' => ['required'],
                'user_id' => ['required'],
            ],
            [
                'detection.required' => "A dátum nem lehet üres!",
                'state.required' => "Pecsét állapot nem lett megadva!",
                'comment.min' => "A megjegyzés nem lehet kevesebb mint 0 karakter!",
                'comment.max' => "A megjegyzés nem lehet több mint 250 karakter!",
            ]
        );
    }
}
