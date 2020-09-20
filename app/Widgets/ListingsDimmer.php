<?php

namespace App\Widgets;

use App\Listing;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Policies\ListingPolicy;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListingsDimmer extends BaseDimmer
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Listing::whereDate('created_at', today())->count();
        $string = 'You have ' . $count . ' new listings today.';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-window-list',
            'title'  => $count . ' New Listing(s)',
            'text'   => $string . ' Click on the button below to view all listings.',
            'button' => [
                'text' => 'View all Listings',
                'link' => route('voyager.listings.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/03.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('read', Listing::first());
    }
}
