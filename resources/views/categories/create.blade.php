@extends('layouts.master')

@section('content')
    <h1>Add New Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <label>Name:</label>
        <input type="text" name="name" required>
        <label>Description:</label>
        <textarea name="description"></textarea>
        <button type="submit">Save</button>
    </form>
@endsection
