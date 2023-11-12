<template>
  <span>
    Status:
    <select class="form-select" :id="'book-status-' + book.id" v-model="selectedStatus" @change="updateStatus">
      <option value="unread">Unread</option>
      <option value="reading">Reading</option>
      <option value="read">Read</option>
    </select>
  </span>
    <button @click="removeBook(book.id)" class="mt-2 mb-2 btn btn-danger">Remove</button>
    <button @click="editBook(book.id)" class="btn btn-secondary">
        <i class="fa fa-pencil"></i>
    </button>
</template>
<script>
export default {
    props: ['book'],
    data() {
        return {
            selectedStatus: this.book.status || 'unread', // Default value or the value from the book prop
        };
    },
    methods: {
        updateStatus() {
            // Handle status update logic here
        },
        removeBook(id) {
            // Handle book removal logic here
        },
        editBook(id) {
            // Handle book edit logic here
        }
    }
}
</script>
