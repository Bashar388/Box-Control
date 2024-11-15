<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index()
    {

        $user = Auth::user();
        $transactionss=User::with('transactions')->find(auth()->id());
        $subscriptions = $user->subscribedServices;
        $balance = $user->wallet ? $user->wallet->balance : 0;

        return view('account.index', compact('user', 'subscriptions','balance','transactionss'));
    }
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function addBalance(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);


        $user = Auth::user();
        $amount = $request->input('amount');


        if ($user->wallet) {
            $user->wallet->balance += $amount;
            $user->wallet->save();
        } else {
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->balance = $amount;
            $wallet->save();
        }

        Transaction::create([
            'user_id' => $user->id,
            'amount' => $request->input('amount'),
            'type' => 'add',
            'description'=>'You added credit to your account',
        ]);

        return back()->with('success', 'Balance added successfully!');
    }
    public function updateProfile(Request $request)
    {
//        $request->validate([
//            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
//        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {

            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }


            $imagePath = $request->file('profile_image')->store('profile_images', 'public');


            $user->profile_image = $imagePath;
            $user->save();
        }



        return back()->with('success', 'Profile updated successfully.');
    }
}
