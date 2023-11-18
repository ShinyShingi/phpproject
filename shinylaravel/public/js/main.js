
function sortList(ul) {
    Array.from(ul.getElementsByTagName("li"))
    .sort((a, b) => a.textContent.toLowerCase().localeCompare(b.textContent.toLowerCase()))
    .forEach(li => ul.appendChild(li));
}
document.addEventListener('DOMContentLoaded', function () {
    let selects = document.querySelectorAll('.form-select');
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const ul = document.querySelector("ul");
    sortList(ul);
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
            fetch('/updateStatus/' + bookId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ status: newStatus })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Server responded with an error!');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data)

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

    document.querySelectorAll('.edit-book-btn').forEach(button => {
        button.addEventListener('click', function() {
            let bookId = this.dataset.id;

            // Fetch existing book data (Replace this with your actual API)
            fetch('/getBook/' + bookId)
            .then(response => response.json())
            .then(data => {
                // Populate modal fields
                document.querySelector('#edit-title').value = data.title;
                document.querySelector('#edit-author').value = data.author;
                document.querySelector('#edit-series').value = data.series;
                //document.querySelector('#edit-cover').value = data.cover;
                let modal = new bootstrap.Modal(document.getElementById('editBookModal'));
                modal.show();
            });
        });
    });
    let clickedBookId; // This variable will store the bookId of the clicked edit button

    // Add event listener to all edit buttons
    document.querySelectorAll('.edit-book-btn').forEach(button => {
        button.addEventListener('click', function() {
            clickedBookId = this.getAttribute('data-id');
        });
    });

    document.querySelector('#editBookForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let bookId = clickedBookId; // Using the clickedBookId variable here
        console.log(bookId);

        let editBookForm = document.querySelector('#editBookForm');
        let formData = new FormData(editBookForm);

        // Send AJAX request to update the book
        fetch('/updateBook/' + bookId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            // Refresh the book list or individual book
            document.getElementById('editBookModal').classList.remove('show');
            document.body.classList.remove('modal-open');
            let backdrops = document.getElementsByClassName('modal-backdrop');
            for(let backdrop of backdrops) {
                backdrop.parentNode.removeChild(backdrop);
            }
        });
    });

});
