@extends('layouts.master')

@section('content')


    <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Add New Service</h3>
            </div>

            <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">

                            <div class="form-group">
                                <label>Name</label>
                                <input name="name" type="text" class="form-control" placeholder="Enter ...">
                            </div>
                        </div>

                    </div>
                    <div class="row">

                            <div class="col-sm-6">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                        <label>Price:</label>
                        <input type="number" name="price" step="0.01">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                        <label>Image:</label>
                        <input type="file" name="image" accept="image/*">
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

        <button type="submit">Save Service</button>
    </form>
    <script src="{{asset('templet/plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('templet/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('templet/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>

    <script src="{{asset('templet/dist/js/adminlte.min2167.js?v=3.2.0')}}"></script>

    <script src="{{asset('templet/dist/js/demo.js')}}"></script>

    <script>
        $(function () {
            bsCustomFileInput.init();
        });
    </script>
@endsection
