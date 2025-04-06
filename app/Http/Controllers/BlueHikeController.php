<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Stage;
use Inertia\Response;
use App\Models\BlueHike;
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
            'bluehikes' => BlueHike::where('user_id', Auth::user()->id)->get()
        ]);
    }

    /**
     * Show bluehike progress on map
     */
    public function progress($hike): Response
    {
        $hikeid = $this->GetHikeId($hike);
        $bluehikes = BlueHike::where('user_id', Auth::user()->id)->get();
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
    public function store(Request $request)
    {
        $email = Auth::user()->email;
        $filename = $email . "/blueroutes/" . $request->name . ".gpx";
        BlueHike::create([
            'name' => $request['name'],
            'user_id' => $request['user_id'],
            'hike_id' => $request['hike_id'],
            'isCustomStart' => $request['isCustomStart'],
            'start_point' => $request['start_point'],
            'isCustomEnd' => $request['isCustomEnd'],
            'end_point' => $request['end_point'],
            'completed' => $request['completed'],
            'distance' => $request['distance']
        ]);

        Storage::disk('local')->put($filename, $request->gpx);
        return to_route('bluehikes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlueHike $bluehike)
    {
        $uid = Auth::user()->id;
        if ($bluehike->user_id != $uid) {
            return redirect()->route('bluehikes.index');
        }

        $route = BlueHike::find($bluehike->id);
        $email = Auth::user()->email;
        $filename = $email . "/blueroutes/" . $route->name . ".gpx";
        return Inertia::render('bluehikes/show', [
            'gpx' => Storage::get($filename),
            'name' => $route->name
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
