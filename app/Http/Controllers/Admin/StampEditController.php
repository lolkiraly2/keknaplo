<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Stamp;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Stage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;

class StampEditController extends Controller
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
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):Response
    {
        $hike ='';
        if($request->query('hike') === null) {
            $hike = 'OKK';
            $stamps = Stamp::with(['stage:id,name,hike_id'])->paginate(10);
        }
        elseif($request->query('hike') == 'OKK') {
            $stamps = Stamp::with(['stage:id,name,hike_id'])->paginate(10);
            $hike = 'OKK';
        } else {
            $stamps = Stamp::with(['stage:id,name,hike_id'])->whereHas('stage', function (Builder $query) use ($request) {
                $query->where('hike_id', $this->GetHikeId($request->query('hike')));
            })->paginate(10);
            $hike = $request->query('hike');
        }
        return Inertia::render('Admin/stampsedit/index', [
            'stamps' => $stamps,
            'hike' => $hike
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/stampsedit/create',[
            'stages' => Stage::select('id','name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        Stamp::create($this->validateStamp());

        return to_route('stampsedit.index');
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
        return Inertia::render('Admin/stampsedit/edit',[
            'stages' => Stage::select('id','name')->get(),
            'stamp' => Stamp::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id): RedirectResponse
    {
        $stamp = Stamp::find($id);
        $stamp->update($this->validateStamp());

        return to_route('stampsedit.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stamp $stamp): RedirectResponse
    {
        $stamp->delete();

        return to_route('stampsedit.index');
    }

    public function validateStamp(): array
    {
        return request()->validate(
            [
                'mtsz_id' => ['required'],
                'stamp_id' => ['required'],
                'stage_id' => ['required'],
                'name' => ['required', 'max:60'],
                'location' => ['required', 'max:255'],
                'location_description' => ['required', 'max:255'],

                'address' => ['required', 'max:255'],
                'availability' => ['required'],
                'opening_hours' => ['required'],
                'lat' => ['required'],
                'lon' => ['required'],
                'stamp_url' => ['required'],
                'picture1_url' => ['required'],
                'picture2_url' => ['nullable'],
                'picture3_url' => ['nullable'],
            ],
            [

                'mtsz_id.required' => "Az mtsz azonosító nem lehet üres!",
                'stamp_id.required' => "A bélyegző azonosító nem lehet üres!",
                'stage_id.required' => "A szakasz nem lehet üres!",
                'name.required' => "A név nem lehet üres!",
                'name.max' => "A név hossza maximum 60 karakter lehet!",
                'location.required' => "A helyszín nem lehet üres!",
                'location.max' => "A helyszín hossza maximum 255 karakter lehet!",
                'location_description.required' => "A helyszín leírása nem lehet üres!",
                'location_description.max' => "A helyszín leírása hossza maximum 255 karakter lehet!",
                'address.required' => "A cím nem lehet üres!",
                'address.max' => "A cím hossza maximum 255 karakter lehet!",
                'availability.required' => "A rendelkezésre állás nem lehet üres!",
                'opening_hours.required' => "A nyitvatartás nem lehet üres!",
                'lat.required' => "A szélesség nem lehet üres!",
                'lon.required' => "A hosszúság nem lehet üres!",
                'stamp_url.required' => "A bélyegző URL nem lehet üres!",
                'picture1_url.required' => "Az első kép URL nem lehet üres!",
            ]
        );
    }
}
