<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Stage;
use App\Models\Cpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CpointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $uid = Auth::user()->id;
        return Inertia::render('custompoints/index', [
            'points' => Cpoint::where('user_id', $uid)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('custompoints/create', [
            'oktstages' => Stage::select('id', 'nev')->where('nev', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'nev')->where('nev', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'nev')->where('nev', 'like', "AK%")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cpoint::create($$request->validate([
            'nev' => ['required', 'max:50'],
            'szelesseg' => ['required', 'max:50'],
            'hosszusag' => ['required', 'max:50'],
            'leiras' => ['required', 'max:50'],
            'stage_id' => ['required'],
            'user_id' => ['required']
        ]));

        return to_route('custompoints.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //dd($selected);
        return Inertia::render('custompoints/show', [
            'se' => $request->query('selected')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpoint $cpoint)
    {
        return Inertia::render('custompoints/edit', [
            'oktstages' => Stage::select('id', 'nev')->where('nev', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'nev')->where('nev', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'nev')->where('nev', 'like', "AK%")->get(),
            'cpoint' => $cpoint
        ]);
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
