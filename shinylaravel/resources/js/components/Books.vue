<script setup>
import { ref, onMounted } from 'vue';

const completedBooks = ref([]);
const incompleteBooks = ref([]);
const inProgressBooks = ref([]);
const baseURL = import.meta.env.VITE_API_URL;

onMounted(async () => {
    const response = await fetch('/api/books');
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
                </li>
            </ul>
        </div>
    </div>
</template>
