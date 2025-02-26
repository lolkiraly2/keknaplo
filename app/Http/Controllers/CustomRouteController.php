<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use App\Models\CustomRoute;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomRouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $uid = Auth::user()->id;
        return Inertia::render('customroutes/index', [
            'customroutes' => CustomRoute::where('user_id', $uid)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('customroutes/customroute');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $email = Auth::user()->email;
        $filename = $email . "/croutes/" . $request->name . ".gpx";
        CustomRoute::create([
            'name' => $request['name'],
            'user_id' => $request['user_id']
        ]);
        
        Storage::disk('local')->put($filename, $request->gpx);
        return to_route('customroutes.index');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        $route = CustomRoute::find($id);
        $email = Auth::user()->email;
        $filename = $email . "/croutes/" . $route->name . ".gpx";
        return Inertia::render('customroutes/show',[
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
    public function destroy(string $id): RedirectResponse
    {
        $route = CustomRoute::find($id);
        $email = Auth::user()->email;
        $filename = $email . "/croutes/" . $route->name . ".gpx";

        $route->delete();
        Storage::delete($filename);
        return to_route('customroutes.index');
    }
}
