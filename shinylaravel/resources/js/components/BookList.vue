<template>
    <div class="row mt-3">
      <div class="col-12 align-self-center">
        <h3 class="mb-3">{{ title }}:</h3>
        <ul class="row">
          <book-item
            v-for="book in books"
            :key="book.id"
            :book="book"
            @remove="removeBook"
            @edit="editBook"
          ></book-item>
        </ul>
      </div>
    </div>
  </template>
  
  <script>
  import BookItem from './BookItem.vue';
  
  export default {
    components: {
      BookItem
    },
    props: {
      books: Array,
      title: String
    },
    methods: {
      removeBook(id) {
        this.$emit('remove', id);
      },
      editBook(book) {
        this.$emit('edit', book);
      }
    }
  };
  </script>
  