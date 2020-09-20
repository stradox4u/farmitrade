<?php

namespace App\Widgets;

use App\Transfer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Policies\TransferPolicy;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransfersDimmer extends BaseDimmer
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
        $count = Transfer::whereDate('created_at', today())->count();
        $string = 'You have made ' . $count . ' new transfer(s) today.';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-rocket',
            'title'  => $count . ' New Transfer(s)',
            'text'   => $string . ' Click on the button below to view all transfers.',
            'button' => [
                'text' => 'View all Transfers',
                'link' => route('voyager.transfers.index'),
            ],
            'image' => voyager_asset('images/widget-backgrounds/02.jpg'),
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return Auth::user()->can('read', Transfer::first());
    }
}
