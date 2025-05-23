<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use Inertia\Inertia;
use App\Models\Stage;
use App\Models\Stamp;
use Inertia\Response;
use App\Models\StampComment;
use Illuminate\Http\Request;

class StampController extends Controller
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
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index($hike, Request $request): Response
    {
        $number = $this->GetHikeId($hike);
        $stage_id = $request->query('stage');

        return Inertia::render('stamps/index', [
            'stamps' => Hike::find($number)->stamps->unique('mtsz_id')->select('mtsz_id', 'name', 'lon', 'lat', 'location', 'stage_id'),

            'stagestamps' => fn () => Stamp::where('stage_id',$stage_id)->get(),
            'hike' => $hike,
            'stages' => Hike::find($number)->stages->select('id', 'name'),
            'stage' => Stage::select("name")->find($stage_id),
            'url' => asset('storage') . '/',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($stamp): Response
    {
        $comments = StampComment::where('stamp_mtsz_id', $stamp)->with(['user:id,name'])->orderByDesc('id')->get();

        return Inertia::render('stamps/show', [
            'stamp' => Stamp::where('mtsz_id', $stamp)->get()->first(),
            'comments' => $comments
        ]);
    }
}