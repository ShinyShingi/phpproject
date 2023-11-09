<template>
  <div>
    <book-list title="Books to read" :books="incompleteBooks" />
    <book-list title="Books in progress" :books="inProgressBooks" />
    <book-list title="Completed Books" :books="completedBooks" />
  </div>
</template>

<script>
import axios from 'axios';
import BookList from './components/BookList.vue';
import BookItem from './components/BookItem.vue'; // Corrected import statement

export default {
  components: {
    BookList,
    BookItem, // Corrected component registration
  },
  data() {
    return {
      completedBooks: this.initialData.completedBooks,
      incompleteBooks: this.initialData.incompleteBooks,
      inProgressBooks: this.initialData.inProgressBooks,
      books: window.books || [],
    };
  },
  mounted() {
    this.fetchBooks();
  },
  methods: {
    fetchBooks() {
      axios.get('/api/books')
        .then(response => {
          // Assuming the API returns an object with keys for each book list
          const { incomplete, inProgress, completed } = response.data;
          this.incompleteBooks = incomplete;
          this.inProgressBooks = inProgress;
          this.completedBooks = completed;
        })
        .catch(error => {
          console.error('There was an error fetching the books:', error);
        });
    },
  },
};
</script>
