<?php

namespace App\Jobs;

use App\User;
use App\Listing;
use Illuminate\Bus\Queueable;
use App\Mail\WeeklyNotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WeeklyNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Fetch all users from the table
        $users = User::all();

        // Get the posts relevant to each user
        foreach($users as $user)
        {
            // dd($user->listings()->get());
            $userListingsProduce = $user->listings()->take(3)->pluck('produce')->toArray();
            // $userListingsProduceString = implode(' ', $userListingsProduce->toArray());
            // logger($userListingsProduceString);
            if($user->user_type == 'buyer')
            {
                $relevantListings = Listing::whereIn('produce', $userListingsProduce)
                    ->where([
                        ['buy_sell', 'sell'],
                        ['filled', false],
                        ['user_id', '!=', $user->id],
                    ])->take(7)->get();
            }

            if($user->user_type == 'farmer')
            {
                $relevantListings = Listing::whereIn('produce', $userListingsProduce)
                    ->where([
                        ['buy_sell', 'buy'],
                        ['filled', false],
                        ['user_id', '!=', $user->id],
                    ])->take(7)->get();
            }
            // logger($relevantListings);

            $myOpenListings = $user->listings()->where(['filled', false]);

            // Send email
            Mail::to($user->email)->send(new WeeklyNotificationMail($user, $relevantListings, $myOpenListings));
        }
    }
}
