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
                'nev' => $custompoin->nev,
                'stage_id' => $custompoin->stage_id,
                'szelesseg' => $custompoin->szelesseg,
                'hosszusag' => $custompoin->hosszusag,
                'leiras' => $custompoin->leiras,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cpoint $custompoint): Response
    {
        $stage = Stage::where('id', $custompoint->stage_id)->value('nev');
        return Inertia::render('custompoints/edit', [
            'oktstages' => Stage::select('id', 'nev')->where('nev', 'like', "OKT%")->get(),
            'ddkstages' => Stage::select('id', 'nev')->where('nev', 'like', "DDK%")->get(),
            'akstages' => Stage::select('id', 'nev')->where('nev', 'like', "AK%")->get(),
            'cpoint' => [
                'id' => $custompoint->id,
                'nev' => $custompoint->nev,
                'stage_id' => $custompoint->stage_id,
                'szelesseg' => $custompoint->szelesseg,
                'hosszusag' => $custompoint->hosszusag,
                'leiras' => $custompoint->leiras,
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
                'nev' => ['required', 'max:50'],
                'szelesseg' => ['required', 'max:50'],
                'hosszusag' => ['required', 'max:50'],
                'leiras' => ['min:0', 'max:50'],
                'stage_id' => ['required'],
                'user_id' => ['required'],
            ],
            [
                'name.required' => "A név nem lehet üres!",
                'name.max' => "Túl hosszú név! (Maximum: :max karakter)!",
                'postcode.required' => "Az irányítószám nem lehet üres!",
                'postcode.integer' => "Az irányítószám csak szám lehet!",
                'postcode.between' => "Irányítószámnak :min és :max közötti számot adjon meg!",
                'city.required' => "A város nem lehet üres!",
                'city.max' => "Túl hosszú városnév (Maximum: :max karakter)!",
                'street.required' => "Az utca nem lehet üres!",
                'number.required' => "A házszám nem lehet üres!",
                'number.integer' => "Házszám csak szám lehet!",
                'contact.required' => "Az email nem lehet üres!",
                'contact.email' => "Hibás formátum!"
            ]
        );
    }
}
