<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($photo)
    {
        $user = auth()->user();
        $photo = Photo::find($photo);
        $like = Like::where('user_id', $user->id)
            ->where('photo_id', $photo->id)
            ->first();

        if (!$like) {
            Like::create([
                'user_id' => $user->id,
                'photo_id' => $photo->id,
            ]);
        } else {
            $like->delete();
        }

        return response()->json(['likes' => $photo->likes()->count()]);
    }
}