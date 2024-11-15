@extends('layouts.master')

@section('content')
    <h1>Edit Blog</h1>

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label>Title:</label>
            <input type="text" name="title" value="{{ $blog->title }}" required>
        </div>

        <div>
            <label>Content:</label>
            <textarea name="content" rows="5" required>{{ $blog->content }}</textarea>
        </div>

        <div>
            <label>Image:</label>
            <input type="file" name="image" accept="image/*">
            @if($blog->image)
                <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" width="100">
          @endif
        </div>

        <div>
            <label>Status:</label>
            <select name="status">
                <option value="published" {{ $blog->status == 'published' ? 'selected' : '' }}>Published</option>
                <option value="draft" {{ $blog->status == 'draft' ? 'selected' : '' }}>Draft</option>
            </select>
        </div>

        <div>
            <label>Category:</label>
            <select name="category_id" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $blog->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
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
        <button type="submit">Update Blog</button>
    </form>
@endsection
