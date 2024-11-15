<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::with('ratings')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'description', 'price', 'status']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        Service::create($data);

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }
    public function show($id)
    {
        $service = Service::with('ratings.user')->findOrFail($id);
        $subscriptionCount = $service->subscribers()->count();
        return view('services.show', compact('service','subscriptionCount'));
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['name', 'description', 'price', 'status']);

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully!');
    }


    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.index');
    }

    public function subscribe(Request $request, $serviceId)
    {
        $user = auth()->user();
        $service = Service::findOrFail($serviceId);


        if ($user->wallet->balance < $service->price) {
            return back()->with('error', 'Insufficient balance in your wallet.');
        }


        $user->wallet->balance -= $service->price;
        $user->wallet->save();


        Transaction::create([
            'user_id' => $user->id,
            'amount' => $service->price,
            'type' => 'deduct',
            'description' => 'Subscription to service: ' . $service->name,
        ]);


        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->wallet->balance += $service->price;
            $admin->wallet->save();


            Transaction::create([
                'user_id' => $admin->id,
                'amount' => $service->price,
                'type' => 'add',
                'description' => 'Received subscription payment from user: ' . $user->name,
            ]);
        }


        $user->subscribedServices()->attach($serviceId);

        return back()->with('success', 'Subscription successful and amount transferred to admin.');
    }

    public function rate(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $service = Service::findOrFail($id);


        $existingRating = $service->ratings()->where('user_id', auth()->id())->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        } else {

            $service->ratings()->create([
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'review' => $request->review,
            ]);
        }

        return redirect()->back()->with('success', 'Thank you for your rating!');
    }

}
