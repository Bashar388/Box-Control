@extends('layouts.master')

@section('content')
    <div class="container">
        <h1>Your Wallet</h1>
        <span><p>Wallet balance:  {{ $balance }} $</p></span>

    </div>
    <div class="card card-primary card-outline">
        <div class="card-body box-profile">
            <div class="text-center">

                    <div class="text-center">
                <img class="profile-user-img img-fluid img-circle" src="{{ Storage::url($user->profile_image) }}" alt="Profile Image" width="100">
                    </div>
{{--               @else--}}

                <form action="{{route('user.photo')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <label>Add Photo:</label>
                    <input type="file" name="profile_image" accept="image/*">
                    <button type="submit">Save Photo</button>
                </form>

            </div>
            <h3 class="profile-username text-center">{{ $user->name }}</h3>
            <p class="text-muted text-center">Software Engineer</p>
            <ul class="list-group list-group-unbordered mb-3">

            </ul>

        </div>

    </div>
    <div class="container">


        @if(auth()->user()->role != 'admin')
        <h3 class="text-center mt-5">الخدمات التي اشتركت بها:</h3>
        @if($subscriptions->isEmpty())
            <p class="text-center mt-3">لم تشترك في أي خدمات بعد.</p>
        @else
            <div class="row">
                @foreach($subscriptions as $service)
                    <div class="col-md-4 my-3">
                        <div class="card h-100 shadow-sm">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-service.jpg') }}" alt="Default Service Image" style="width: 100%; height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $service->name }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($service->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="badge badge-primary">{{ $service->price }} $</span>
                                    <span class="badge badge-success">{{ $service->status == 'active' ? 'نشطة' : 'غير نشطة' }}</span>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <a href="{{ route('services.show', $service->id) }}" class="btn btn-primary">عرض الخدمة</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
            <form action="{{ route('wallet.add_balance') }}" method="POST">
                @csrf
                <label for="amount">Amount to Add:</label>
                <input type="number" name="amount" id="amount" step="0.01" required>
                <button type="submit">Add Balance</button>
            </form>
        @endif
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Wallet operations</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactionss->transactions as $transaction)
                <tr>
                    <td>{{$transaction->id}}</td>
                    <td>{{$transaction->type}}</td>
                    <td>
                       {{$transaction->amount}}
                    </td>
                    <td>{{$transaction->description}}</td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
                <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
            </ul>
        </div>
    </div>
    <style>
        .card {
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-top {
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
        }

        .card-text {
            color: #666;
            font-size: 0.9rem;
        }

        .card-footer {
            background-color: #f8f9fa;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

    </style>



    <script src="{{asset('templet/plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('templet/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('templet/dist/js/adminlte.min2167.js?v=3.2.0')}}"></script>

    <script src="{{asset('templet/dist/js/demo.js')}}"></script>
@endsection
