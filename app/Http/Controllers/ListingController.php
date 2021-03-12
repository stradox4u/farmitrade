<?php

namespace App\Http\Controllers;

use App\User;
use App\Listing;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Events\ListingCreated;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all of the logged in user's listings produce
        $userListingsProduce = auth()->user()->listings()->where('filled', false)->pluck('produce')->toArray();
        // dd($userListingsProduce);

        // Get opposing listings that match
        if(auth()->user()->user_type == 'farmer')
        {
            $listings = collect([]);
            foreach($userListingsProduce as $produce)
            {
                $relevant = Listing::where([
                    ['produce', 'like', '%' . $produce . '%'],
                    ['buy_sell', 'buy'],
                    ['filled', false],
                    ['user_id', '!=',  auth()->id()],
                ])->get();
                $listings = $listings->concat($relevant);
            }
        }

        if(auth()->user()->user_type == 'buyer')
        {
            $listings = collect([]);
            foreach($userListingsProduce as $produce)
            {
                $relevant = Listing::where([
                    ['produce', 'like', '%' . $produce . '%'],
                    ['buy_sell', 'sell'],
                    ['filled', false],
                    ['user_id', '!=',  auth()->id()],
                ])->get();
                $listings = $listings->concat($relevant);
            }
        }

        // If user has not created a profile, redirect them to profile creation page
        if(auth()->user()->profile == null)
        {
            request()->session()->flash('warning', 'You must create a profile first.');
            return redirect(route('profile.create', auth()->id()));
        }

        // If user has no listings, redirect back
        $userListings = Listing::where([
            ['filled', false],
            ['user_id', auth()->id()],
        ])->get();

        if($userListings->isEmpty())
        {
            request()->session()->flash('warning', 'You need to create some listings, so that we can match you with other listings.');
            return back();
        }

        // If no matching listings are found, redirect back to dashboard
        if($listings->isEmpty())
        {
            request()->session()->flash('warning', 'None of our current active listings match any of yours, please check back later.');
            return back();
        }

        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(auth()->user()->profile == null)
        {
            request()->session()->flash('warning', 'You must create a profile first.');
            return redirect(route('profile.create', auth()->id()));
        }
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $data = $request->validate([
            'produce' => ['required', 'string', 'max:85'],
            'produce_quality' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:85'],
            'buy_sell' => ['required', 'string'],
            'quantity' => ['numeric', 'required'],
            'unit' => ['required', 'string'],
            'unit_price' => ['required', 'numeric'],
        ]);

        $listing = auth()->user()->listings()->create([
            'produce' => strtolower(Str::singular($data['produce'])),
            'produce_quality' => $data['produce_quality'],
            'location' => $data['location'],
            'buy_sell' => $data['buy_sell'],
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'unit_price' => $data['unit_price'] * 100,
        ]);

        // Fire event to search database for matching listings and notify their posters
        $user = auth()->user();
        event(new ListingCreated($listing, $user));

        return redirect(route('listing.show', $listing));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        return view('listings.show', compact('listing'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect(route('home'));
    }
}
