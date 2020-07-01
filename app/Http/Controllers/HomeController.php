<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(request()->list)
        {
            $listings = auth()->user()->listings()->paginate(10);
            return view('home', compact('listings'));
        } else 
        {
            $listings = auth()->user()->listings()->where('filled', false)->paginate(10);
            return view('home', compact('listings'));
        }
    }
}
