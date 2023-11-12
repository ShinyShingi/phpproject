@extends('layouts.app')
@section('title')
    Shiny's Reading list
@endsection
@section('content')

    <div class="row mt-3">
        <div class="col-12 align-self-center">
            <h3 class="mb-3">Books to read:</h3>
            <ul class="row" id="incomplete-books">
                @foreach ($incompleteBooks as $book)
                    <li class="mt-3 mb-1 col-12 col-md-3 book">
                        <div class="image-container">
                            <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover"
                                 alt="Cover Image">
                        </div>
                        <input type="hidden" id="bookId" value="{{ $book->id }}">

                        <span class="book-data">
                        <h4>
                            {{$book->title}}
                        </h4>
                        <h5>
                            {{$book->author}}
                        </h5>
                        <p>
                            {{$book->series}}
                        </p>
                    </span>
                    <span>
                        Status:
                        <select class="form-select" id="book-status-{{ $book->id }}" name="status"
                                data-id="{{ $book->id }}">
                            <option selected value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                            <option value="reading">Reading</option>
                            <option value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                        </select>

                    </span>
                        <button data-id="{{$book->id}}" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                        <button data-id="{{$book->id}}" class="btn btn-secondary edit-book-btn">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </li>
                @endforeach
            </ul>


            <h3 class="mb-3">Books in progress:</h3>
            <ul class="row" id="in-progress-books">
                @foreach ($inProgressBooks as $book)
                    <li class="mt-3 mb-1 col-12 col-md-3  book">
                        <div class="image-container">
                            <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover"
                                 alt="Cover Image">
                        </div>
                        <input type="hidden" id="bookId" value="{{ $book->id }}">

                        <span class="book-data">
                            <h4>
                                {{$book->title}}
                            </h4>
                            <h5>
                                {{$book->author}}
                            </h5>
                            <p>
                                {{$book->series}}
                            </p>
                        </span>
                        <span>
                            Status:
                            <select class="form-select" id="book-status-{{ $book->id }}" name="status"
                                    data-id="{{ $book->id }}">
                                <option value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                                <option selected value="reading">Reading</option>
                                <option value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                            </select>

                        </span>
                        <button data-id="{{$book->id}}" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                        <button data-id="{{$book->id}}" class="btn btn-secondary edit-book-btn">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </li>
                @endforeach
            </ul>


            <h3 class="mb-3 mt-5">Completed Books:</h3>
            <ul class="mb-5 row" id="completed-books">
                @foreach ($completedBooks as $book)
                    <li class="mt-3 mb-1 col-12 col-md-3 book">
                        <div class="image-container">
                            <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover"
                                 alt="Cover Image">
                        </div>
                        <input type="hidden" id="bookId" value="{{ $book->id }}">

                        <span class="book-data">
                            <h4>
                                {{$book->title}}
                            </h4>
                            <h5>
                                {{$book->author}}
                            </h5>
                            <p>
                                {{$book->series}}
                            </p>
                        </span>
                        <span>
                        Status:
                            <select class="form-select" id="book-status-{{ $book->id }}" name="status"
                                    data-id="{{ $book->id }}">
                                <option value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                                <option value="reading">Reading</option>
                                <option selected value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                            </select>
                        </span>
                        <button data-id="{{$book->id}}" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                        <button data-id="{{$book->id}}" class="btn btn-secondary edit-book-btn">
                            <i class="fa fa-pencil"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBookForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="edit-author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-series" class="form-label">Series</label>
                            <input type="text" class="form-control" id="edit-series" name="series">
                        </div>
                        <div class="mb-3">
                            <label for="edit-cover" class="form-label">Cover Image</label>
                            <input type="file" class="form-control" id="edit-cover" name="cover">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        Add Review
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" id="addReviewForm" enctype="multipart/form-data">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="addReview">Add Review</label>
                            <input type="textarea" class="form-control" id="addReview">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Review</button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
