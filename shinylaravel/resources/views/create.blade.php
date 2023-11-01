@extends('layouts.app')

@section('title')
    Add new Book
@endsection

@section('content')

    <form action="store-data" method="post" class="mt-4 p-4"  enctype="multipart/form-data">
        @csrf
        <div class="form-group m-3">
            <label for="name">Book Title</label>
            <input type="text" class="form-control" name="title">
        </div>
        <div class="form-group m-3">
            <label for="description">Author</label>
            <input class="form-control" name="author" rows="3">
        </div>
        <div class="form-group m-3">
            <label for="description">Series</label>
            <input class="form-control" name="series" rows="3">
        </div>
        <div class="form-group m-3">
            <label for="description">Cover</label>
            <input class="form-control" type="file" name="cover" rows="3">
        </div>
        <div class="form-group m-3">
            <input type="submit" class="btn btn-primary float-end" value="Submit">
        </div>
    </form>

@endsection
