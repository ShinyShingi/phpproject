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
                    <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid" alt="Cover Image">
                    <span class="">
                        <input type="checkbox" data-id="{{$book->id}}" class="book-checkbox" {{ $book->completed ? 'checked' : '' }}> 
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
                    <button data-id="{{$book->id}}" class=" btn btn-danger delete-book-btn">Remove</button>
                </li>
            @endforeach
            </ul>
            <h3 class="mb-3 mt-5">Completed Books:</h3>
            <ul class="mb-5" id="completed-books">
            @foreach ($completedBooks as $book)
                <li class="mt-1 mb-1 col-3 book">
                <img src="{{ asset('storage/'.$book->cover) }}" class="img-fluid" alt="Cover Image">
                    <span class="">
                        <input type="checkbox" data-id="{{$book->id}}" class="book-checkbox" {{ $book->completed ? 'checked' : '' }}> 
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
        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll('.book-checkbox');
            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');  // Get CSRF token from meta tag

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    let bookId = this.dataset.id;
                    let isChecked = this.checked;
                    let listItem = this.closest('li');  // Get the parent list item
                    
                    // Identify the incomplete and complete book lists
                    let incompleteList = document.getElementById('incomplete-books');
                    let completedList = document.getElementById('completed-books');
                    
                    // AJAX call to update database
                    fetch('/updateBook/' + bookId, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken  // Include CSRF token in the request header
                        },
                        body: JSON.stringify({ isChecked: isChecked })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        
                        // Move the list item to the appropriate list
                        if (isChecked) {
                            completedList.appendChild(listItem);

                            let deleteButton = listItem.querySelector('.delete-book-btn');
                            if (deleteButton) {
                                deleteButton.remove();
                            }

                            sortList(completedList);
                        } else {
                            incompleteList.appendChild(listItem);

                            let deleteButton = document.createElement('button');
                            deleteButton.textContent = 'Remove';
                            deleteButton.dataset.id = bookId;
                            deleteButton.className = 'btn btn-danger delete-book-btn';
                            listItem.appendChild(deleteButton);

                            sortList(incompleteList); 
                        }
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
