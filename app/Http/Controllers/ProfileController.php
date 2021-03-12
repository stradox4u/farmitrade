<?php

namespace App\Http\Controllers;

use App\User;
use App\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\ProfileCreatedEvent;
use App\Events\ProfileUpdatedEvent;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $data = $request->validate([
            'shipping_address1' => ['required', 'string', 'max:85'],
            'shipping_address2' => ['required', 'string', 'max:85'],
            'phone_number' => ['required', 'string', 'size:11'],
            'bank_name' => ['nullable', 'string'],
            'account_number' => ['nullable', 'string', 'size:10'],
            'billing_address1' => ['required', 'string', 'max:85'],
            'billing_address2' => ['required', 'string', 'max:85'],
            'profile_image' => ['required', 'image'],
        ]);

        // Handle the profile image
        $imagePath = request('profile_image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(900, 900);
            $image->save();

        // Store the data
        $user = User::where('id', auth()->id())->first();

        if(auth()->user()->user_type == 'farmer')
        {
            $profile = $user->profile()->create([
                'shipping_address' => $data['shipping_address1'] . '; ' . $data['shipping_address2'],
                'phone_number' => Str::replaceFirst('0', '234', $data['phone_number']),
                'bank_name' => $data['bank_name'],
                'account_number' => $data['account_number'],
                'billing_address' => $data['billing_address1'] . '; ' . $data['billing_address2'],
                'profile_image' => $imagePath,
            ]);
        } else 
        {
            $profile = $user->profile()->create([
                'shipping_address' => $data['shipping_address1'] . '; ' . $data['shipping_address2'],
                'phone_number' => $data['phone_number'],
                'billing_address' => $data['billing_address1'] . '; ' . $data['billing_address2'],
                'profile_image' => $imagePath,
            ]);
        }
        

        if(auth()->user()->user_type == 'farmer')
        {
            event(new ProfileCreatedEvent($profile));
        }

        return redirect(route('profile.show', $profile));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        $profile = auth()->user()->profile;

        return view('profiles.show', compact('profile'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        // dd($profile);
        $data = $request->validate([
            'shipping_address1' => ['nullable', 'string', 'max:85'],
            'shipping_address2' => ['nullable', 'string', 'max:85'],
            'phone_number' => ['nullable', 'string', 'size:11'],
            'bank_name' => ['required_with:account_number', 'nullable', 'string'],
            'account_number' => ['required_with:bank_name', 'nullable', 'string', 'size:10'],
            'billing_address1' => ['nullable', 'string', 'max:85'],
            'billing_address2' => ['nullable', 'string', 'max:85'],
            'profile_image' => ['nullable', 'image'],
        ]);

        if(auth()->user()->user_type == 'farmer')
        {
            // dd($data);
            if($data['bank_name'] == null || $data['account_number'] == null)
            {
                $updateData = ([
                    'shipping_address' => $data['shipping_address1'] . '; ' . $data['shipping_address2'],
                    'phone_number' => Str::replaceFirst('0', '234', $data['phone_number']),
                    'billing_address' => $data['billing_address1'] . '; ' . $data['billing_address2'],
                 ]);
            } else 
            {
                $updateData = ([
                    'shipping_address' => $data['shipping_address1'] . '; ' . $data['shipping_address2'],
                    'phone_number' => Str::replaceFirst('0', '234', $data['phone_number']),
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                    'billing_address' => $data['billing_address1'] . '; ' . $data['billing_address2'],
                 ]);
            }
        } else 
        {
            $updateData = ([
                'shipping_address' => $data['shipping_address1'] . '; ' . $data['shipping_address2'],
                'phone_number' => Str::replaceFirst('0', '234', $data['phone_number']),
                'billing_address' => $data['billing_address1'] . '; ' . $data['billing_address2'],
             ]);
        }

        // Handle Image
        if (request('profile_image')) 
        {
            $imagePath = request('profile_image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(900, 900);
            $image->save();

            $imageArray = ['profile_image' => $imagePath];
        }
        
        $profile->update(array_merge(
            $updateData, 
            $imageArray ?? []
        ));
        // dd($profile);

        if(auth()->user()->user_type == 'farmer')
        {
            event(new ProfileUpdatedEvent($profile));
        }
        return redirect(route('profile.show', $profile, compact('profile')));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        $user = auth()->user();

        if($user->profile->profile_image !== null)
        {
            $profile_image = 'storage/' . $user->profile->profile_image;
            File::delete($profile_image);
        }

        $user->delete();
        
        return redirect(route('home'));
    }
}
