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

        return back();
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
                'eszleles_datum' => ['required'],
                'allapot' => ['required'],
                'leiras' => ['min:0', 'max:250'],
                'stamp_name' => ['required'],
                'user_id' => ['required'],
            ],
            [
                'datum.required' => "A dátum nem lehet üres!",
                'name.required' => "Pecsét állapot hiányzik",
            ]
        );
    }
}
