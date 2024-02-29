<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        Album::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function update(Request $request, $album)
    {
        $album = Album::find($album);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $album->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return back();
    }

    public function delete(Request $request, $album)
    {
        $album = Album::find($album);

        if ($album->photos()->exists()) {
            return back();
        }

        $album->delete();

        return back();
    }
}