<?php

namespace App\Http\Controllers;

class HallController extends Controller
{
    public function exterior()
    {
        return view('hall.exterior');
    }

    public function landing()
    {
        return view('hall.landing');
    }

    public function lobby()
    {
        return view('hall.lobby');
    }

    public function exhibit()
    {
        return view('hall.exhibit');
    }
}
