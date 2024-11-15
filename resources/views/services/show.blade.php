@extends('layouts.master')

@section('content')
    <div style="padding: 20px; max-width: 800px; margin: auto;">
        <h1>{{ $service->name }}</h1>

        @if($service->image)
            <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" style="width: 100%; height: 400px; object-fit: cover; margin-bottom: 20px;">
        @else
            <img src="{{ asset('images/default-service.jpg') }}" alt="Default Service Image" style="width: 100%; height: 400px; object-fit: cover; margin-bottom: 20px;">
        @endif

        <p><strong>Description:</strong> {{ $service->description }}</p>
        <p><strong>Price:</strong> ${{ $service->price ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($service->status) }}</p>
 @auth
     @if(auth()->user()->role == 'admin')
        <div style="margin-top: 20px;">
            <h3>Number of Subscribers:</h3>
            <p>{{ $subscriptionCount }} subscriber(s)</p>
        </div>
        @endif
        @endauth
        <div style="margin-top: 20px;">
            <h3>Average Rating:</h3>
            <p>{{ $service->averageRating() ?? 'No ratings yet' }} / 5</p>
        </div>
        @auth
        @if(auth()->user()->role == 'admin')
            <a class="btn btn-danger" href="{{route('services.edit',$service->id)}}">Edit</a>

            <form action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه المدونة؟');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        @endif

     @if(auth()->user()->role != 'admin')

            @if(auth()->user()->subscribedServices->contains($service->id))
                <p style="color: green;">You are already subscribed.</p>
            @else
                <form action="{{ route('services.subscribe', $service->id) }}" method="POST">
                    @csrf
                    <button type="submit" style="background-color: green; color: white; padding: 8px 12px; border: none; cursor: pointer;">Subscribe</button>
                </form>
            @endif

{{--            <p>Please <a href="{{ route('login') }}">login</a> to subscribe.</p>--}}



        <div style="margin-top: 20px;">
            <h3>Rate this Service</h3>
            <form action="{{ route('services.rate', $service->id) }}" method="POST">
                @csrf
                <div>
                    <label for="rating">Rating (1 to 5):</label>
                    <select name="rating" id="rating" required>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="review">Review (optional):</label>
                    <textarea name="review" id="review" rows="3"></textarea>
                </div>
                <button type="submit" style="margin-top: 10px; padding: 8px 12px; background-color: blue; color: white; border: none; cursor: pointer;">Submit Rating</button>
            </form>
        </div>
        @endif
        @endauth
        <div style="margin-top: 20px;">
            <h3>All Ratings</h3>
            @if($service->ratings->isNotEmpty())
                <ul style="list-style-type: none; padding: 0;">
                    @foreach($service->ratings as $rating)
                        <li style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
                            <strong>{{ $rating->user->name }}</strong> rated {{ $rating->rating }} stars
                            @if($rating->review)
                                <p>{{ $rating->review }}</p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No ratings yet for this service.</p>
            @endif
        </div>
    </div>
@endsection
