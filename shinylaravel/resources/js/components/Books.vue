<script setup>
import { ref, onMounted } from 'vue';

const completedBooks = ref([]);
const incompleteBooks = ref([]);
const inProgressBooks = ref([]);
const baseURL = import.meta.env.VITE_API_URL;

const removeBook = (id) => {
    // Logic to remove the book
    if (confirm('Are you sure you want to delete this book?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/updateBook/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            }
        })
            .then(response => response.json())
            .then(data => {
                incompleteBooks.value   = incompleteBooks.value.filter(book => book.id !== id);
                completedBooks.value    = completedBooks.value.filter(book->book.id !== id);
                inProgressBooks.value   = inProgressBooks.value.filter(book->book.id !== id);
            })
            .catch((error) => console.error('Error:', error));
    }
};

const editBook = (id) => {
    // Logic to edit the book
    fetch(`/getBook/${id}`)
        .then(response => response.json())
        .then(data => {
            // Assuming you have a method or a way to populate the modal fields
            showModalWithBookData(data);
        })
        .catch((error) => console.error('Error:', error));
};

const updateStatus = (book) => {
    // Logic to handle status update
};

onMounted(async () => {
    const response = await fetch(`/api/books`);
    if (response.ok) {
        const data = await response.json();
        completedBooks.value = data.completedBooks;
        incompleteBooks.value = data.incompleteBooks;
        inProgressBooks.value = data.inProgressBooks;
    } else {
        // Handle error
        console.error('Failed to fetch books');
    }
});
</script>


<template>
    <div>
        <h2>Books</h2>
        <div>
            <h3 class="mb-3">Books to read:</h3>
            <ul class="row" id="incomplete-books">
                <li v-for="book in incompleteBooks" :key="book.id" class="mt-3 mb-1 col-12 col-md-3 book">
                    <div class="image-container">
                        <img :src="$getImageUrl(book.cover)" class="img-fluid img-cover"
                             alt="Cover Image">
                    </div>
                    <h4>
                        {{ book.title }}
                    </h4>
                    <h5>
                        {{ book.author }}
                    </h5>
                    <p>
                        {{ book.series }}
                    </p>

                    <span>
                        Status:
                        <select class="form-select" :id="'book-status-' + book.id" v-model="book.status" data-id="book.id">
                            <option selected value="unread">Unread</option>
                            <option value="reading">Reading</option>
                            <option value="read">Read</option>
                        </select>
                    </span>
                    <button @click="removeBook(book.id)" data-id="book.id" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                    <button @click="editBook(book.id)" data-id="book.id" class="btn btn-secondary edit-book-btn">
                        <i class="fa fa-pencil"></i>
                    </button>
                </li>
            </ul>
        </div>
        <div class="">
            <h3 class="mb-3">Books in progress:</h3>
            <ul class="row" id="in-progress-books">
                <li v-for="book in inProgressBooks" :key="book.id" class="mt-3 mb-1 col-12 col-md-3 book">
                    <div class="image-container">
                        <img :src="$getImageUrl(book.cover)" class="img-fluid img-cover"
                             alt="Cover Image">
                    </div>
                    <h4>
                        {{ book.title }}
                    </h4>
                    <h5>
                        {{ book.author }}
                    </h5>
                    <p>
                        {{ book.series }}
                    </p>
                    <span>
                        Status:
                        <select class="form-select" :id="'book-status-' + book.id" v-model="book.status" data-id="book.id">
                            <option  value="unread">Unread</option>
                            <option selected value="reading">Reading</option>
                            <option value="read">Read</option>
                        </select>
                    </span>
                    <button @click="removeBook(book.id)" data-id="book.id" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                    <button @click="editBook(book.id)" data-id="book.id" class="btn btn-secondary edit-book-btn">
                        <i class="fa fa-pencil"></i>
                    </button>
                </li>
            </ul>
        </div>
        <div class="">
            <h3 class="mb-3 mt-5">Completed Books:</h3>
            <ul class="mb-5 row" id="completed-books">
                <li v-for="book in completedBooks" :key="book.id"  class="mt-3 mb-1 col-12 col-md-3 book">
                    <div class="image-container">
                        <img :src="$getImageUrl(book.cover)" class="img-fluid img-cover"
                             alt="Cover Image">
                    </div>
                    <h4>
                        {{ book.title }}
                    </h4>
                    <h5>
                        {{ book.author }}
                    </h5>
                    <p>
                        {{ book.series }}
                    </p>
                    <span>
                        Status:
                        <select class="form-select" :id="'book-status-' + book.id" v-model="book.status" data-id="book.id">
                            <option  value="unread">Unread</option>
                            <option value="reading">Reading</option>
                            <option selected value="read">Read</option>
                        </select>
                    </span>
                    <button @click="removeBook(book.id)" data-id="book.id" class="mt-2 mb-2 btn btn-danger delete-book-btn">Remove</button>
                    <button @click="editBook(book.id)" data-id="book.id" class="btn btn-secondary edit-book-btn">
                        <i class="fa fa-pencil"></i>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</template>
