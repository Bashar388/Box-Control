@extends('layouts.master')

@section('content')
    <h1>Edit Service</h1>

    <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Add New Service</h3>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label>Name</label>
                            <input name="name" type="text" class="form-control" placeholder="Enter ..." value="{{ $service->name }}">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter ..." >{{ $service->description }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Price:</label>
                            <input type="number" name="price" step="0.01" value="{{ $service->price }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Image:</label>
                            <input type="file" name="image" accept="image/*" value="{{$service->image}}">
                        </div>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <div class="form-check">
                                <input name="status" class="form-check-input" type="radio" value="active" >
                                <label class="form-check-label">Active</label>
                                <br>
                                <input name="status" class="form-check-input" type="radio" value="inactive" >
                                <label class="form-check-label">Inactive</label>
                            </div>

                        </div>

                    </div>
                </div>




            </div>

        </div>

        <button type="submit">Update Service</button>

    </form>
@endsection
