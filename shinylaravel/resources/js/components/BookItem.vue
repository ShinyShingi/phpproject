<template>
    <li class="mt-3 mb-1 col-12 col-md-3 book">
        <div class="image-container">
                        <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover" alt="Cover Image">
                    </div>
                    <input type="hidden" id="bookId" value="{{ $book->id }}">

                    <span class="book-item">
                        <h4>{{ bookData.title }}</h4>
                        <h5>{{ bookData.author }}</h5>
                        <p>{{ bookData.series }}</p>
                    </span>
                    <span>
                        Status: 
                        <select class="form-select" id="book-status-{{ $book->id }}" name="status" data-id="{{ $book->id }}">
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
  </template>
  
  <script>
    export default {
        props: {
            bookData: {
            type: Object,
            required: true,
            },
        },
    };
  </script>
  