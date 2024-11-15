@extends('layouts.master')

@section('content')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Users</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Subscriptions</th>
                    <th style="width: 40px">Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>

                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>
                       {{$user->subscribedServices->count()}}
                    </td>
                        @if($user->subscribedServices->count()>0)
                    <td><span  style="color: green">effective</span></td>
                        @else
                            <td><span  style="color: red">Ineffective</span></td>
                        @endif
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
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Services</h2>
        </div>

        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th style="width: 40px"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($services as $service)
                <tr>
                    <td>{{$service->id}}</td>
                    <td>{{$service->name}}</td>
                    <td><p>{{ Str::limit($service->description, 50) }}</p></td>
                    <td>{{$service->price ?? 'N/A'}}</td>
                    <td>
                        <a class="btn btn-danger"  href="{{route('services.edit',$service->id)}}">Edit</a>

                    </td>
                    <td>
                        <form  action="{{ route('services.destroy', $service->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذه المدونة؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" >Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>


    </div>
@endsection
