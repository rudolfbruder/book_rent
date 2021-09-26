<template>
  <div>
    <div class="mb-2">
      <router-link to="/books/create" class="btn btn-success"
        >Create</router-link
      >
    </div>
    <datatable
      :data="books"
      :columns="headers"
      :actions="actions"
      :index="false"
    ></datatable>
  </div>
</template>

<script>
import axios from "axios";
import Vue from "vue";
require("bootstrap-vue-datatable");
export default {
  data() {
    return {
      books: [],
      headers: [
        { name: "id", th: "ID" },
        { name: "title", th: "Title" },
        { name: "author", th: "Author" },
        { name: "is_borrowed", th: "Borrowed" },
      ],
      actions: [
        {
          text: "Edit",
          color: "primary",

          action: (row, index) => {
            this.$router.push({ name: "books.edit", params: { book: row.id } });
          },
        },
        {
          text: "Toggle Status",
          color: "info",
          class: "ml-2",
          action: (row, index) => {
            axios.put(`/api/books/${row.id}/toggle-status`).then(({ data }) => {
              Vue.set(this.books, index, data.data);
              alert("Book borrowed status toggled!");
            });
          },
        },
        {
          text: "Delete",
          color: "danger",
          class: "ml-2",
          action: (row, index) => {
            axios.delete(`/api/books/${row.id}`).then(() => {
              Vue.delete(this.books, index);
              alert("Book deleted successfully!");
            });
          },
        },
      ],
    };
  },
  methods: {
    fetchBooks() {
      axios.get("/api/books").then(({ data }) => {
        this.books = data.data;
      });
    },
  },
  mounted() {
    this.fetchBooks();
  },
};
</script>

<style lang="scss">
.btn-undefined {
  margin-left: 10px !important;
}
</style>
