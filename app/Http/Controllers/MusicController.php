<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Music;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class MusicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        $music = new Music();
        $music->user_id = Auth::id();
        $music->genre = $request->input('genre');
        $music->artist = $request->input('artist');
        $music->songtitle = $request->input('songtitle');
        $music->audio = $request->file('audio')->store('music', 'public');

        $music->image = $request->file('image')->store('covers', 'public');

        $image = Image::make(public_path("storage/{$music->image}"))->fit(1200, 1200);

        $image->save();
        $music->save();

        return redirect('/profile/' . auth()->user()->id)->with('message', 'Music has been added!');
    }

    public function show(Music $music)
    {
        return view('showmusic', compact('music'));
    }

    public function discover()
    {

        $musicId = $this->getRandomLikedMusicId();
        if (Auth::user()->likes()->whereNotNull('music_id')->count() > 0) {
            $musics = $this->getMusicsBySameGenre(Music::where('id', $musicId)->first());
        } else {
            $musics = Music::all();
        }
        $all_music = Music::all();
        $all_user = User::where('id', '!=', Auth::id())->get();

        return view('discover', [
            'musics' => $musics,
            'all_user' => $all_user,
            'all_music' => $all_music,
        ]);
    }


    public function getRandomLikedMusicId()
    {
        $likedIDs = DB::table('likes')->whereNotNull('music_id')->pluck('music_id')->toArray();
        if (Auth::user()->likes()->whereNotNull('music_id')->count() > 0) {
            return $likedIDs[rand(0, sizeof($likedIDs) - 1)];
        }
    }

    public function getMusicsBySameGenre(Music $music)
    {
        return Music::where('genre', $music->genre)->whereNotNull('id', '!=', $music->id)->get();
    }

    public function musicDestroy(Music $music, Request $request)
    {

        Music::whereId($music->id)->delete();
        Like::where('music_id', $music->id)->delete();
        Comment::where('music_id', $music->id)->delete();
        return back();
    }
}
