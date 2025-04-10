<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Grouphike;
use App\Models\CustomRoute;
use Illuminate\Http\Request;
use App\Models\GrouphikeParticipant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

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

    public function futurehikes(): Response
    {
        $uid = Auth::user()->id;
        $hikeids = Auth::user()->joinedhikes->pluck('grouphike_id');
        $grouphikes = Grouphike::find($hikeids)->pluck('name');

        return Inertia::render('grouphikes/futurehikes', [
            'hikeids' => $hikeids,
            'futurehikes' => $grouphikes
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

        return to_route('grouphikes.mygrouphikes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grouphike $grouphike)
    {
        $uid = Auth::user()->id;

        $participantsid = Grouphike::find($grouphike->id)->participants->pluck('user_id');
        $participants = User::find($participantsid)->pluck('name');
        $isJoined = $participantsid->contains($uid);
       
        if (( $grouphike->public == 0 && !$isJoined ) && ( $grouphike->public == 0 && $grouphike->user_id != $uid )){
            return redirect()->route('grouphikes.index');
        }

        $route = CustomRoute::find($grouphike->customroute_id);
        $email = User::find($grouphike->user_id)->email;
        $filename = $email . "/croutes/" . $route->name . ".gpx";

        return Inertia::render('grouphikes/show', [
            'gpx' => Storage::get($filename),
            'organizer' => User::find($grouphike->user_id)->name,
            'grouphike' => $grouphike,
            'participants' => $participants,
            'isJoined' => $isJoined
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grouphike $grouphike)
    {
        $uid = Auth::user()->id;
        if ($grouphike->public == 0 && $grouphike->user_id != $uid ){
            return redirect()->route('grouphikes.index');
        }

        return Inertia::render('grouphikes/edit', [
            'myroutes' => User::find($uid)->croutes,
            'grouphike' => $grouphike
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Grouphike $grouphike): RedirectResponse
    {
        $grouphike->update($this->validateGrouphike());
        return to_route('grouphikes.mygrouphikes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function join(Request $request): RedirectResponse
    {
        GrouphikeParticipant::create([
            'grouphike_id' => request('grouphike_id'),
            'user_id' => request('user_id')
        ]);

        return redirect()->back();
    }

    public function cancel(Request $request): RedirectResponse
    {
        $uid = Auth::user()->id;
        $gid = request('grouphike_id');
        $participant = GrouphikeParticipant::where('grouphike_id', $gid)->where('user_id', $uid)->first();
        $participant->delete();

        return redirect()->back();
    }

    public function join_private_hike(): Response
    {
        return Inertia::render('grouphikes/joinprivatehike');
    }

    public function join_private_hike_store()
    {
        $findhike = false;
        $inputemail = request('email');
        $inputpassword = request('password');
        $grouphikes = Grouphike::select('id','public','user_id','password')->get();
        $i = 0;
        while ($i < count($grouphikes)) {
            $user = User::find($grouphikes[$i]->user_id);

            if ($grouphikes[$i]->public == 0 && Hash::check($inputpassword,$grouphikes[$i]->password) && $user->email == $inputemail) {
                $findhike = true;
                break;
                dd($findhike, $grouphikes, $inputemail, $inputpassword);
            }
            $i++;
        }

        if ($findhike) {
            $uid = Auth::user()->id;
            GrouphikeParticipant::create([
                'grouphike_id' => $grouphikes[$i]->id,
                'user_id' => $uid
            ]);
            return redirect()->route('grouphikes.futurehikes');
        } else {
            return redirect()->back();
        }

        dd($grouphikes);
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
                'description' => ['required', 'max:500'],
                'customroute_id' => ['required'],
                'user_id' => ['required'],
                'password' => ['min:0'],
                'maxparticipants' => ['required', 'min:1', 'max:100']
            ],
            [
                'name.required' => "A név nem lehet üres!",
                'name.max' => "Túl hosszú név! (Maximum: :max karakter)",
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
                'description.max' => "Leírás túl hosszú! (Maximum: :max karakter)",
                'maxparticipants.required' => 'A túra létszáma nem lehet üres!',
                'maxparticipants.min' => 'A túra létszáma legalább 1!',
                'maxparticipants.max' => 'A túra létszáma maximum 100!',
                'public.required' => 'A túra nyilvános vagy privát?'
            ]
        );
    }
}
