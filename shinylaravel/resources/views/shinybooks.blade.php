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
                <li class="mt-1 mb-1 col-3 book">
                    <div class="image-container">
                        <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover" alt="Cover Image">
                    </div>
    
                    <span class="">
                        <h3>
                            {{$book->title}}
                        </h3>
                        <h4>
                            {{$book->author}}
                        </h4>
                        <h4>
                            {{$book->series}}
                        </h4>
                    </span>
                    <span>
                        Status: 
                        <select class="form-select" id="book-status" name="status" data-id="{{ $book->id }}">
                            <option selected value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                            <option value="reading">Reading</option>
                            <option value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                        </select>

                    </span>
                    <button data-id="{{$book->id}}" class=" btn btn-danger delete-book-btn">Remove</button>
                </li>
            @endforeach
            </ul>


            <h3 class="mb-3">Books in progress:</h3>
            <ul class="row" id="in-progress-books">
                @foreach ($inProgressBooks as $book)
                    <li class="mt-1 mb-1 col-3 book">
                        <div class="image-container">
                            <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover" alt="Cover Image">
                        </div>
                        <span class="">
                            <h3>
                                {{$book->title}}
                            </h3>
                            <h4>
                                {{$book->author}}
                            </h4>
                            <h4>
                                {{$book->series}}
                            </h4>
                        </span>
                        <span>
                            Status: 
                            <select class="form-select" id="book-status" name="status" data-id="{{ $book->id }}">
                                <option value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                                <option selected value="reading">Reading</option>
                                <option value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                            </select>

                        </span>
                        <button data-id="{{$book->id}}" class=" btn btn-danger delete-book-btn">Remove</button>
                    </li>
                @endforeach
            </ul>


            <h3 class="mb-3 mt-5">Completed Books:</h3>
            <ul class="mb-5" id="completed-books">
            @foreach ($completedBooks as $book)
                <li class="mt-1 mb-1 col-3 book">
                    <div class="image-container">
                        <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid img-cover" alt="Cover Image">
                    </div>
                    <span class="">
                        <h3>
                            {{$book->title}}
                        </h3>
                        <h4>
                            {{$book->author}}
                        </h4>
                        <h4>
                            {{$book->series}}
                        </h4>
                    </span>
                    <span>
                        Status: 
                        <select class="form-select" id="book-status" name="status" data-id="{{ $book->id }}">
                            <option value="unread" {{ !$book->completed ? 'selected' : '' }}>Unread</option>
                            <option value="reading">Reading</option>
                            <option selected value="read" {{ $book->completed ? 'selected' : '' }}>Read</option>
                        </select>

                    </span>
                    <button data-id="{{$book->id}}" class=" btn btn-danger delete-book-btn">Remove</button>
                </li>
            @endforeach
            </ul>
        </div>
    </div>
    <script>
        function sortList(ul) {
            Array.from(ul.getElementsByTagName("LI"))
            .sort((a, b) => a.textContent.localeCompare(b.textContent))
            .forEach(li => ul.appendChild(li));
        }
        document.addEventListener('DOMContentLoaded', function () {
            let selects = document.querySelectorAll('.form-select');
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            selects.forEach(function(select) {
                select.addEventListener('change', function() {
                    let bookId = this.dataset.id;
                    let newStatus = this.value;  // Get the selected value
                    
                    // Identify the different book lists
                    let incompleteList = document.getElementById('incomplete-books');
                    let completedList = document.getElementById('completed-books');
                    let inProgressList = document.getElementById('in-progress-books');
                    console.log("incompleteList:", incompleteList);
                    console.log("completedList:", completedList);
                    console.log("inProgressList:", inProgressList);

                    let listItem = this.closest('li');

                    
                    // AJAX call to update database
                    fetch('/updateBook/' + bookId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ status: newStatus })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);

                        // Move the list item to the appropriate list
                        if (newStatus === 'unread') {
                            incompleteList.appendChild(listItem);
                        } else if (newStatus === 'reading') {
                            inProgressList.appendChild(listItem);
                        } else if (newStatus === 'read') {
                            completedList.appendChild(listItem);
                        }
                        listItem.querySelector('select').value = newStatus;
                    })
                    .catch((error) => console.error('Error:', error));
                });
            });
       
            document.querySelectorAll('.delete-book-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    let bookId = this.dataset.id;
                    
                    // Confirm the deletion action
                    if (confirm('Are you sure you want to delete this book?')) {
                        // AJAX call to delete book
                        fetch('/updateBook/' + bookId, {
                            method: 'DELETE',  // Make sure this matches your route method
                            headers: {
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);

                            // Remove the list item from DOM
                            this.closest('li').remove();
                        })
                        .catch((error) => console.error('Error:', error));
                    }
                });
            });
        });
    </script>
@endsection
