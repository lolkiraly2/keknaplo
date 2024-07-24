<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Stage;
use Illuminate\Http\Request;


class CpointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Inertia::render('custompoints/index',[
            'oktstages' => Stage::where('nev', 'like', "OKT%")->get(),
            'ddkstages' => Stage::where('nev', 'like', "DDK%")->get(),
            'akstages' => Stage::where('nev', 'like', "AK%")->get(),
        ]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //dd($selected);
        return Inertia::render('custompoints/show',[
            'se' => $request->query('selected')
        ]);
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
}
