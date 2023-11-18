
<script>
import { Modal } from 'bootstrap';
import axios from 'axios';

export default {
    data() {
        console.log("I'm in EditModal");
        return {
            editedBook: {
                title: '',
                author: '',
                series: '',
                cover: ''
            }
        };
    },
    methods: {
        openModal(book) {
            console.log('openModal called with:', book);
            this.editedBook = { ...book };

            const modalElement = this.$refs.editBookModal;
            const modal = new Modal(modalElement);
            modal.show();
        },
        handleFileChange(event) {
            // Assuming you only want to handle single file uploads
            const file = event.target.files[0];
            if (file) {
                this.editedBook.cover = file;
            }
        },
        saveBook() {
            const formData = new FormData();
            formData.append('title', this.editedBook.title);
            formData.append('author', this.editedBook.author);
            formData.append('series', this.editedBook.series);
            if (this.editedBook.cover instanceof File) {
                formData.append('cover', this.editedBook.cover, this.editedBook.cover.name);
            }

            // Use Axios to send the request
            axios.post(`/api/books/${this.editedBook.id}`, formData, {
                headers: {
                    // Axios will set the Content-Type to multipart/form-data by itself
                    // Include CSRF token if necessary
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            })
                .then(response => {
                    // Handle success
                    console.log('Book updated successfully:', response.data);
                })
                .catch(error => {
                    // Handle error
                    console.error('Error updating book:', error);
                });
        }
    }
}
</script>
<template>
    <div class="modal fade" ref="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBookModalLabel">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBookForm"  @submit.prevent="saveBook" enctype="multipart/form-data">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label for="edit-title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="edit-title"  v-model="editedBook.title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="edit-author"  v-model="editedBook.author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-series" class="form-label">Series</label>
                            <input type="text" class="form-control" id="edit-series"  v-model="editedBook.series" name="series">
                        </div>
                        <div class="mb-3">
                            <label for="edit-cover" class="form-label">Cover Image</label>
                            <input type="file" class="form-control" id="edit-cover" @change="handleFileChange"  name="cover">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
