<?php

namespace App\Http\Controllers;

use App\User;
use App\Listing;
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
        $userListingsProduce = auth()->user()->listings()->pluck('produce')->toArray();
        if(auth()->user()->user_type == 'farmer')
        {
            $listings = Listing::whereIn('produce', $userListingsProduce)
                    ->where([
                        ['buy_sell', 'buy'],
                        ['filled', false],
                        ['user_id', '!=', auth()->id()],
                    ])->paginate(10);
        }

        if(auth()->user()->user_type == 'buyer')
        {
            $listings = Listing::whereIn('produce', $userListingsProduce)
                    ->where([
                        ['buy_sell', 'sell'],
                        ['filled', false],
                        ['user_id', '!=', auth()->id()],
                    ])->paginate(10);
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
            'location' => ['required', 'string', 'max:85'],
            'buy_sell' => ['required', 'string'],
            'quantity' => ['numeric', 'required'],
            'unit' => ['required', 'string'],
            'unit_price' => ['required', 'numeric'],
        ]);

        $listing = auth()->user()->listings()->create([
            'produce' => $data['produce'],
            'location' => $data['location'],
            'buy_sell' => $data['buy_sell'],
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'unit_price' => $data['unit_price'],
        ]);

        // Fire event to search database for matching listings and notify their posters
        $user = auth()->user();
        event(new ListingCreated($listing, $user));

        return redirect(route('listing.show', $listing->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Listing  $listing
     * @return \Illuminate\Http\Response
     */
    public function show(Listing $listing)
    {
        $listing = Listing::where('id', $listing->id)->first();
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
