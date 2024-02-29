<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function comment(Request $request, $photo)
    {
        $photo = Photo::find($photo);

        Comment::create([
            'user_id' => auth()->id(),
            'photo_id' => $photo->id,
            'description' => $request->description
        ]);

        return back();
    }
}