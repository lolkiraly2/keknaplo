<?php

namespace App\Http\Controllers;

use App\Models\Hike;
use App\Models\Stamp;
use Inertia\Inertia;
use Inertia\Response;
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
    public function index($hike): Response
    {
        $number = $this->GetHikeId($hike);

        return Inertia::render('stamps/index', [
            'stamps' => Hike::find($number)->stamps->select('mtsz_id', 'nev', 'hosszusag', 'szelesseg', 'helyszin', 'stage_id'),
            'hike' => $hike,
            'stages' => Hike::find($number)->stages->select('id', 'nev')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($stamp): Response
    {
        return Inertia::render('stamps/show', [
            'stamp' => Stamp::where('mtsz_id', $stamp)->get()->first()
        ]);
    }
}