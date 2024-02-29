<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($username)
    {
        $user = User::where('username', $username)->first();
        $albums = Album::where('user_id', $user->id)->latest()->get();

        return view('profile.index', compact('user', 'albums'));
    }
}