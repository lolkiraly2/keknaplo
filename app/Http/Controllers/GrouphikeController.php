<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Grouphike;
use App\Models\CustomRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class GrouphikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('grouphikes/index', [
            'grouphikes' => Grouphike::where('public', 1)->get()
        ]);
    }

    public function mygrouphikes(): Response
    {
        $uid = Auth::user()->id;
        return Inertia::render('grouphikes/mygrouphikes', [
            'grouphikes' => Grouphike::where('user_id', $uid)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $uid = Auth::user()->id;
        return Inertia::render('grouphikes/create', [
            'myroutes' => User::find($uid)->croutes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Grouphike::create($this->validateGrouphike());

        return to_route('grouphikes.index');
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

    public function validateGrouphike(): array
    {
        return request()->validate(
            [
                'name' => ['required', 'max:64'],
                'start_point_name' => ['required', 'max:50'],
                'end_point_name' => ['required', 'max:50'],
                'location' => ['required', 'max:50'],
                'date' => ['required'],
                'gatheringtime' => ['required'],
                'starttime' => ['required'],
                'public' => ['required'],
                'description' => ['required','max:500'],
                'customroute_id' => ['required'],
                'user_id' => ['required'],
                'password' => ['min:0']
            ],
            [
                'name.required' => "A név nem lehet üres!",
                'name.max' => "Túl hosszú név! (Maximum: :max karakter)!",
                'start_point_name.required' => "Kiindulópont neve nem lehet üres!",
                'start_point_name.max' => "Kiindulópont neve túl hosszú! (Maximum: :max karakter)",
                'end_point_name.required' => "Végppontpont neve nem lehet üres!",
                'end_point_name.max' => "Végpont neve túl hosszú! (Maximum: :max karakter)",
                'location.required' => "Helyszín neve nem lehet üres!",
                'location.max' => "Helyszín neve túl hosszú! (Maximum: :max karakter)",
                'date.required' => "Dátum neve nem lehet üres!",
                'gatheringtime.required' => "Gyülekező időpontja nem lehet üres!",
                'starttime.required' => "Indulás időpntja nem lehet üres!",
                'customroute_id.required' => "Válasszon útvonalat a megtervezett túrái közül!",
                'starttime.required' => "Indulás időpntja nem lehet üres!",
                'description.required' => "Leírás nem lehet üres!",
                'description.max' => "Leírás túl hosszú! (Maximum: :max karakter)"
            ]
        );
    }
}
