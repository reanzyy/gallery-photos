<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $photos = Photo::latest()->get();

        return view('home', compact('photos'));
    }
}