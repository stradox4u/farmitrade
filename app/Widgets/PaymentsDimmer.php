<?php

namespace App\Widgets;

use App\Payment;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Policies\PaymentPolicy;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PaymentsDimmer extends BaseDimmer
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
        $count = Payment::whereDate('created_at', today())->count();
        $string = 'You have ' . $count . ' new payment(s) today.';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-credit-cards',
            'title'  => $count . ' New Payment(s)',
            'text'   => $string . ' Click on the button below to view all payments.',
            'button' => [
                'text' => 'View all Payments',
                'link' => route('voyager.payments.index'),
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
        return Auth::user()->can('read', Payment::first());
    }
}
