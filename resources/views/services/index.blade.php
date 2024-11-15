@extends('layouts.master')

@section('content')
    @if(auth()->user())
    @if(auth()->user()->role == 'admin')
    <a href="{{ route('services.create') }}">Add New Service</a>
    @endif
    @endif
    <h1>Our Services</h1>

    <div class="row">
        @foreach($services as $service)
            <div class="col-md-4 my-3">
                <div class="card h-100 shadow-sm">
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <img src="{{ asset('images/default-service.jpg') }}" alt="Default Service Image" style="width: 100%; height: 200px; object-fit: cover;">
                @endif

                    <div class="card-body">
                    <h3>{{ $service->name }}</h3>
                    <p>{{ Str::limit($service->description, 50) }}</p>
                    <p><strong>Price:</strong> ${{ $service->price ?? 'N/A' }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($service->status) }}</p>
                    <a  style="background-color: yellow; color: white; gap: 10px;  margin: 10px; padding: 5px 20px; border-radius: 6px;  cursor: pointer;" href="{{route('services.show',$service->id)}}">View Service</a>
                     <br>
                    </div>
                    @auth
                    @if(auth()->user()->role != 'admin')

                        @if(auth()->user()->subscribedServices && auth()->user()->subscribedServices->contains($service->id))
                            <p style="color: green;">You are already subscribed.</p>
                        @else

                            <form  action="{{ route('services.subscribe', $service->id) }}" method="POST">
                                @csrf
                                <button  type="submit" style="background-color: green; color: white; gap: 10px;  margin: 10px; padding: 5px 20px; cursor: pointer; border-radius: 6px">Subscribe</button>


                            </form>


                        @endif
                    @else
{{--                        <p>Please <a href="{{ route('login') }}">login</a> to subscribe.</p>--}}



            @endif

            @endauth
                </div>
            </div>
        @endforeach
    </div>
    @auth
    @if(auth()->user()->role != 'admin')
    @isset($service)
        @if($service->ratings && $service->ratings->count() > 0)
            <p>Average Rating: {{ round($service->ratings->avg('rating'), 1) }} من 5</p>
        @else
            <p>No ratings yet</p>
        @endif
    @endisset
    @endauth

    @auth
        @isset($service)
            <h3>Rate this service</h3>
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
                <button type="submit">Submit Rating</button>
            </form>
        @else
            <p>Please <a href="{{ route('login') }}">login</a> to rate this service.</p>
        @endisset
    @endauth
    @endif

    <h3>All Ratings</h3>
    @isset($service)
        @if($service->ratings && $service->ratings->count() > 0)
            <ul>
                @foreach($service->ratings as $rating)
                    <li>
                        <strong>{{ $rating->user->name }}</strong> rated {{ $rating->rating }} stars
                        @if($rating->review)
                            <p>{{ $rating->review }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>No ratings available for this service.</p>
        @endif
    @endisset
@endsection
