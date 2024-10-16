<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class StampController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function GetHikeId($h)
    {
        switch ($h) {
            case 'OKT':
                return 1;
                
            case 'DDK':
                return 2;
                
            case 'AK':
                return 3;      
        }
    }

    public function index($hike): Response
    {
        $number = $this->GetHikeId($hike);

        return Inertia::render('stamps/index', [
            'stamps' => Hike::find($number)->stamps->select('nev','hosszusag','szelesseg','helyszin')->unique('nev'),
            'hike' => $hike
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
}
