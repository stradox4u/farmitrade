<?php

namespace App\Widgets;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Policies\TransactionPolicy;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Widgets\BaseDimmer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TransactionsDimmer extends BaseDimmer
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
        $count = Transaction::whereDate('created_at', today())->count();
        $string = 'You have ' . $count . ' new transaction(s) today.';

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-basket',
            'title'  => $count . ' New Transaction(s)',
            'text'   => $string . ' Click on the button below to view all transactions.',
            'button' => [
                'text' => 'View all Transactions',
                'link' => route('voyager.transactions.index'),
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
        return Auth::user()->can('read', Transaction::first());
    }
}
