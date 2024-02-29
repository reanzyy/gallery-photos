<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function index(Request $request, $username, $album)
    {
        $user = User::where('username', $username)->first();
        $album = Album::find($album);
        $photos = Photo::where('album_id', $album->id)->latest()->get();

        return view('photo.index', compact('user', 'album', 'photos'));
    }

    public function store(Request $request, $username, $album)
    {
        $user = User::where('username', $username)->first();
        $album = Album::find($album);

        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'required|max:5048|mimes:png,jpg,png',
            'description' => 'required|string|max:255'
        ]);

        $path = time() . '.' . $request->path->extension();
        $request->path->move(public_path("images"), $path);

        $photo = new Photo;
        $photo->name = $request->name;
        $photo->description = $request->description;
        $photo->user_id = $user->id;
        $photo->album_id = $album->id;
        $photo->path = $path;
        $photo->save();

        return back();
    }

    public function update(Request $request, $username, $photo)
    {
        $user = User::where('username', $username)->first();
        $photo = Photo::find($photo);

        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|max:5048',
            'description' => 'required|string|max:255'
        ]);

        if ($request->path) {
            $path = time() . '.' . $request->path->extension();
            $request->path->move(public_path("images"), $path);
            $photo->path = $path;
        }

        $photo->name = $request->name;
        $photo->description = $request->description;
        $photo->save();

        return back();
    }

    public function detail($username, $photo)
    {
        $user = User::where('username', $username)->first();
        $photo = Photo::find($photo);

        return view('photo.detail', compact('user', 'photo'));
    }

    public function delete($username, $photo)
    {
        $user = User::where('username', $username)->first();
        $photo = Photo::find($photo);

        $photo->delete();

        return back();
    }
}