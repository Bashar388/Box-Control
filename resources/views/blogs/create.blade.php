@extends('layouts.master')

@section('content')

    <h1>Add New Blog</h1>

    <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Title:</label>
            <input type="text" name="title" required>
        </div>


            <label>Content:</label>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                Posts
                            </h3>
                        </div>

                        <div class="card-body">
<textarea name="content" id="summernote">

              </textarea>
                        </div>

                    </div>
                </div>

            </div>


        <div>
            <label>Image:</label>
            <input type="file" name="image" accept="image/*">
        </div>

        <div>
            <label>Status:</label>
            <select name="status">
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>
        <div>
            <label>Category:</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="service_id">Chose Service</label>
            <select name="service_id" id="service_id" class="form-control">
                <option value="">-- Chose Service --</option>
                @foreach($availableServices as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Save Blog</button>
    </form>
    <script src="{{asset('templet/plugins/jquery/jquery.min.js')}}"></script>

    <script src="{{asset('templet/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{asset('templet/dist/js/adminlte.min2167.js?v=3.2.0')}}"></script>

    <script src="{{asset('templet/plugins/summernote/summernote-bs4.min.js')}}"></script>

    <script src="{{asset('templet/plugins/codemirror/codemirror.js')}}"></script>
    <script src="{{asset('templet/plugins/codemirror/mode/css/css.js')}}"></script>
    <script src="{{asset('templet/plugins/codemirror/mode/xml/xml.js')}}"></script>
    <script src="{{asset('templet/plugins/codemirror/mode/htmlmixed/htmlmixed.js')}}"></script>

    <script src="{{asset('templet/dist/js/demo.js')}}"></script>

    <script>
        $(function () {
            // Summernote
            $('#summernote').summernote()

            // CodeMirror
            CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
                mode: "htmlmixed",
                theme: "monokai"
            });
        })
    </script>
@endsection
