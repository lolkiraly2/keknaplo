<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Stage;
use Inertia\Response;
use App\Models\BlueHike;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlueHikeController extends Controller
{
    public function GetHikeId($h)
    {
        switch ($h) {
            case 'OKT':
                return 1;
            case 'DDK':
                return 2;
            case 'AK':
                return 3;
            case 'OKK':
                return 4;
        }
    }

    public function GetBluehikeRouteName($h)
    {
        switch ($h) {
            case 'OKT':
                return "okt_teljes.gpx";
            case 'DDK':
                return "ddk_teljes.gpx";
            case 'AK':
                return "ak_teljes.gpx";
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('bluehikes/index', [
            'bluehikes' => Auth::user()->bluehikes
        ]);
    }

    public function plannedhikes(): Response
    {
        return Inertia::render('bluehikes/plannedhikes', [
            'plannedhikes' => Auth::user()->plannedbluehikes
        ]);
    }

    /**
     * Set hike as completed
     */

    public function completehike(Request $request): RedirectResponse
    {
        $bluehike = BlueHike::find($request->id);
        $bluehike->completed = 1;
        $bluehike->date = Carbon::today()->format('Y-m-d');
        $bluehike->save();
        return to_route('bluehikes.index');
    }


    /**
     * Show bluehike progress on map
     */
    public function progress($hike): Response
    {
        $hikeid = $this->GetHikeId($hike);
        $bluehikes =  Auth::user()->bluehikes;
        $progress = [];
        $hikeurls = [];
        $distancesum = 0;
        if ($hike != "OKK") {
            array_push($hikeurls, asset(Storage::url($this->GetBluehikeRouteName($hike))));
            foreach ($bluehikes as $bluehike) {
                if ($bluehike->hike_id == $hikeid) {
                    $filename = Auth::user()->email . "/blueroutes/" . $bluehike->name . ".gpx";
                    array_push($progress, Storage::get($filename));
                    $distancesum += $bluehike->distance;
                }
            }
        } else {
            array_push($hikeurls, asset(Storage::url("okt_teljes.gpx")));
            array_push($hikeurls, asset(Storage::url("ddk_teljes.gpx")));
            array_push($hikeurls, asset(Storage::url("ak_teljes.gpx")));
            foreach ($bluehikes as $bluehike) {
                $filename = Auth::user()->email . "/blueroutes/" . $bluehike->name . ".gpx";
                array_push($progress, Storage::get($filename));
                $distancesum += $bluehike->distance;
            }
        }

        return Inertia::render('bluehikes/progress', [
            'bluestages' => $progress,
            'hikeUrls' => $hikeurls,
            'emptypicture' => asset(Storage::url("empty.png")),
            'distancesum' => $distancesum,
            'hike' => $hike,
            'totalDistance' => Hike::find($hikeid)->distance,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($hike, Request $request): Response
    {
        $hikeid = $this->GetHikeId($hike);
        $stages = Hike::find($hikeid)->stages;
        // $startstage_id = $request->query('startstage');

        return Inertia::render('bluehikes/create', [
            'stages' => $stages,
            'startpoints' => Inertia::lazy(fn() => Stage::find($request->query('startstage'))->stamps->select('id', 'mtsz_id', 'name', 'lat', 'lon')),
            'endpoints' => Inertia::lazy(fn() => Stage::find($request->query('endstage'))->stamps->select('id', 'mtsz_id', 'name', 'lat', 'lon')),
            'customstartpoints' => Inertia::lazy(fn() => User::find(Auth::user()->id)->cpoints->where('stage_id', $request->query('startstage'))->values()->toArray()),
            'customendpoints' => Inertia::lazy(fn() => User::find(Auth::user()->id)->cpoints->where('stage_id', $request->query('endstage'))->values()->toArray()),
            'hike_id' => $hikeid,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $names = Auth::user()->bluehikes->pluck('name');
        if ($names->contains($request->name)) {
            return redirect()->back()->withErrors(['name' => 'Ilyen nevű szakasz már létezik!']);
        }

        $email = Auth::user()->email;
        $filename = $email . "/blueroutes/" . $request->name . ".gpx";
        BlueHike::create($this->validate());

        Storage::disk('local')->put($filename, $request->gpx);

        if ($request->completed) {
            return to_route('bluehikes.index');
        } else {
            return to_route('bluehikes.plannedhikes');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(BlueHike $bluehike)
    {
        if ($bluehike->user_id != Auth::user()->id) {
            return redirect()->route('bluehikes.index');
        }

        $email = Auth::user()->email;
        $filename = $email . "/blueroutes/" . $bluehike->name . ".gpx";
        return Inertia::render('bluehikes/show', [
            'gpx' => Storage::get($filename),
            'bluehike' => $bluehike
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
     * Save diary
     */
    public function savediary()
    {
        $bluehike = BlueHike::find(request()->bluehike_id);
        $bluehike->diary = request()->diary;

        $bluehike->save();
        return to_route('bluehikes.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlueHike $bluehike): RedirectResponse
    {
        // dd($bluehike);
        // $bluehike->update($this->validate());

        return to_route('bluehikes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlueHike $bluehike)
    {
        $filename = Auth::user()->email . "/blueroutes/" . $bluehike->name . ".gpx";
        Storage::delete($filename);
        $bluehike->delete();
        return to_route('bluehikes.index');
    }

    public function validate(): array
    {
        return request()->validate(
            [
                'name' => ['required', 'max:64'],
                'user_id' => ['required'],
                'hike_id' => ['required'],
                'isCustomStart' => ['required'],
                'start_point' => ['required'],
                'isCustomEnd' => ['required'],
                'end_point' => ['required'],
                'date' => ['required'],
                'completed' => ['required'],
                'distance' => ['required'],
                'diary' => ['min:0'],
            ],
            [
                'name.required' => "A név nem lehet üres!",
                'name.max' => "Túl hosszú név! (Maximum: :max karakter)!",
                'distance.required' => "Hiba történt! Kattints újra a tervezés gombra és próbálja újra!",
            ]
        );
    }
}
