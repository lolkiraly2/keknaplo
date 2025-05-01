<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\Stage;
use App\Models\Cpoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $names = Auth::user()->cpoints->pluck('name');
        if ($names->contains($request->name)) {
            return redirect()->back()->withErrors(['name' => 'Ilyen nevű pont már létezik!']);
        }
        Cpoint::create($this->validatePoint());

        return to_route('custompoints.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cpoint $custompoint): Response
    {
        return Inertia::render('custompoints/show', [
            'cpoint' => $custompoint
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpoint $custompoint)
    {
        $uid = Auth::user()->id;
        if ($custompoint->user_id != $uid) {
            return redirect()->route('custompoints.index');
        }

        $stage = Stage::where('id', $custompoint->stage_id)->value('name');
        return Inertia::render('custompoints/edit', [
            'oktstages' => Stage::select('id', 'name')->where('name', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'name')->where('name', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'name')->where('name', 'like', "AK%")->get(),
            'cpoint' => $custompoint,
            'stage' => $stage
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Cpoint $custompoint): RedirectResponse
    {
        $names = Auth::user()->cpoints->pluck('name');
        if ($names->contains($custompoint->name)) {
            return redirect()->back()->withErrors(['name' => 'Ilyen nevű pont már létezik!']);
        }
        $custompoint->update($this->validatePoint());
        return to_route('custompoints.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cpoint $custompoint): RedirectResponse
    {
        $customstartpoints = Auth::user()->allbluehikes->where('isCustomStart', 1)->pluck('start_point');
        $customendpoints = Auth::user()->allbluehikes->where('isCustomEnd', 1)->pluck('end_point');

        if ($customstartpoints->contains($custompoint->id) || $customendpoints->contains($custompoint->id)) {
            return redirect()->back()->withErrors(['name' => 'A pontot nem lehet törölni, mert legalább egy szakaszhoz hozzá van rendelve!']);
        }
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
