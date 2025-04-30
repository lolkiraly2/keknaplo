<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Grouphike;
use Illuminate\Http\Request;
use App\Models\GrouphikeParticipant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class GrouphikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('grouphikes/index', [
            'grouphikes' => Grouphike::where('public', 1)->where('date', '>=', Carbon::today())->orderBy('name')->get()
        ]);
    }

    /**
     * Display user's grouphikes.
     */
    public function mygrouphikes(): Response
    {
        $uid = Auth::user()->id;
        return Inertia::render('grouphikes/mygrouphikes', [
            'grouphikes' => Auth::user()->mygrouphikes->where('date', '>=', Carbon::today()),
            'previusgrouphikes' => Auth::user()->mygrouphikes->where('date', '<', Carbon::today())
        ]);
    }

    /**
     * Display user's future grouphikes.
     */
    public function futurehikes(): Response
    {
        return Inertia::render('grouphikes/futurehikes', [
            'futurehikes' => Auth::user()->joinedhikes->where('grouphike.date', '>=', Carbon::today())
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
        $names = Auth::user()->mygrouphikes->pluck('name');
        if ($names->contains($request->name)) {
            return redirect()->back()->withErrors(['name' => 'Ilyen nevű csoportos túra már létezik!']);
        }
        if ($request->public == 0) {
            $passwords = Auth::user()->mygrouphikes->where('public', 0)->pluck('password');
            foreach ($passwords as $password) {
                if (Hash::check($request->password, $password)) {
                    return redirect()->back()->withErrors(['password' => 'Ez a jelszó már foglalt!']);
                }
            }
        }

        Grouphike::create($this->validateGrouphike());

        return to_route('grouphikes.mygrouphikes');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grouphike $grouphike)
    {
        $uid = Auth::user()->id;

        $participantsid = $grouphike->participants->pluck('user_id');
        $participants = User::find($participantsid)->pluck('name');
        $isJoined = $participantsid->contains($uid);

        if (($grouphike->public == 0 && !$isJoined) && ($grouphike->public == 0 && $grouphike->user_id != $uid)) {
            return redirect()->route('grouphikes.index');
        }

        $route = $grouphike->Customroute;
        $email = $grouphike->user->email;
        $filename = $email . "/croutes/" . $route->name . ".gpx";

        $comments = $grouphike->comments;

        return Inertia::render('grouphikes/show', [
            'gpx' => Storage::get($filename),
            'organizer' => $grouphike->user->name,
            'grouphike' => $grouphike,
            'participants' => $participants,
            'isJoined' => $isJoined,
            'comments' => $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grouphike $grouphike)
    {
        $uid = Auth::user()->id;
        if ($grouphike->user_id != $uid) {
            return redirect()->route('grouphikes.index');
        }

        return Inertia::render('grouphikes/edit', [
            'myroutes' => Auth::user()->croutes,
            'grouphike' => $grouphike
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grouphike $grouphike): RedirectResponse
    {
        $names = Auth::user()->mygrouphikes->where('id', '!=', $grouphike->id)->pluck('name');
        if ($names->contains($request->name)) {
            return redirect()->back()->withErrors(['name' => 'Ilyen nevű csoportos túra már létezik!']);
        }
        $grouphike->update($this->validateGrouphike());
        return to_route('grouphikes.mygrouphikes');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grouphike $grouphike): RedirectResponse
    {
        $grouphike->delete();
        return to_route('grouphikes.mygrouphikes');
    }

    public function join(): RedirectResponse
    {
        $grouphike = Grouphike::find(request('grouphike_id'));
        if ($grouphike->participants->count() >= $grouphike->maxparticipants) {
            return redirect()->back();
        }

        GrouphikeParticipant::create([
            'grouphike_id' => request('grouphike_id'),
            'user_id' => request('user_id')
        ]);

        return redirect()->back();
    }

    public function cancel(): RedirectResponse
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
        $grouphikes = Grouphike::select('id', 'public', 'user_id', 'password')->where('public', 0)->get();
        $i = 0;
        while ($i < count($grouphikes)) {
            $user = User::find($grouphikes[$i]->user_id);

            if (Hash::check($inputpassword, $grouphikes[$i]->password) && $user->email == $inputemail) {
                $findhike = true;
                break;
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
            throw ValidationException::withMessages([
                'join' => 'Hibás email vagy jelszó!'
            ]);
            return redirect()->back();
        }
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
