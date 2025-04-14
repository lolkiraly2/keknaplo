<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Stage;
use App\Models\Cpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;


class CpointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('custompoints/index', [
            'points' => Auth::user()->cpoints
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('custompoints/create', [
            'oktstages' => Stage::select('id', 'name')->where('name', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'name')->where('name', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'name')->where('name', 'like', "AK%")->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Cpoint::create($this->validatePoint());

        return to_route('custompoints.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cpoint $custompoint): Response
    {
        dd($custompoint);
        return Inertia::render('custompoints/show', [
            'cpoint' => [
                'id' => $custompoin->id,
                'name' => $custompoin->name,
                'stage_id' => $custompoin->stage_id,
                'lat' => $custompoin->lat,
                'lon' => $custompoin->lon,
                'description' => $custompoin->description,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpoint $custompoint)
    {
        $uid = Auth::user()->id;
        if ($custompoint->user_id != $uid){
            return redirect()->route('custompoints.index');
        }

        $stage = Stage::where('id', $custompoint->stage_id)->value('name');
        return Inertia::render('custompoints/edit', [
            'oktstages' => Stage::select('id', 'name')->where('name', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'name')->where('name', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'name')->where('name', 'like', "AK%")->get(),
            'cpoint' => [
                'id' => $custompoint->id,
                'name' => $custompoint->name,
                'stage_id' => $custompoint->stage_id,
                'lat' => $custompoint->lat,
                'lon' => $custompoint->lon,
                'description' => $custompoint->description,
            ],
            'stage' => $stage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cpoint $custompoint): RedirectResponse
    {
        $custompoint->update($this->validatePoint());
        return to_route('custompoints.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cpoint $custompoint): RedirectResponse
    {
        $custompoint->delete();
        return to_route('custompoints.index');
    }

    public function validatePoint(): array
    {
        return request()->validate(
            [
                'name' => ['required', 'max:64'],
                'lat' => ['required'],
                'lon' => ['required'],
                'description' => ['min:0', 'max:255'],
                'stage_id' => ['required'],
                'user_id' => ['required'],
            ],
            [
                'name.required' => "A név nem lehet üres!",
                'name.max' => "Túl hosszú név! (Maximum: :max karakter)!",
                'stage_id.required' => "Válassz szakaszt!",
            ]
        );
    }
}
