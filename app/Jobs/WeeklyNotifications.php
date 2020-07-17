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

        // Get the posts relevant to each user and send emails
        foreach($users as $user)
        {
            $myOpenListings = $user->listings()->where('filled', false)->get();

            // Send email if user has open listings
            if($myOpenListings->isNotEmpty())
            {
                // Get the produce the user has listed for
                $userListingsProduce = $user->listings()->take(3)->pluck('produce')->toArray();

                // Get 7 matching listings
                if($user->user_type == 'buyer')
                {
                    $relevantListings = collect([]);
                    foreach($userListingsProduce as $produce)
                    {
                        $relevant = Listing::where([
                            ['produce', 'like', '%' . $produce . '%'],
                            ['buy_sell', 'sell'],
                            ['filled', false],
                            ['user_id', '!=',  auth()->id()],
                        ])->get();
                        $relevantListings = $relevantListings->concat($relevant)->take(7);
                    }
                }
    
                if($user->user_type == 'farmer')
                {
                    $relevantListings = collect([]);
                    foreach($userListingsProduce as $produce)
                    {
                        $relevant = Listing::where([
                            ['produce', 'like', '%' . $produce . '%'],
                            ['buy_sell', 'buy'],
                            ['filled', false],
                            ['user_id', '!=',  auth()->id()],
                        ])->get();
                        $relevantListings = $relevantListings->concat($relevant)->take(7);
                    }
                }

                // Send email to users
                Mail::to($user->email)->send(new WeeklyNotificationMail($user, $relevantListings, $myOpenListings));
            }
        }
    }
}
