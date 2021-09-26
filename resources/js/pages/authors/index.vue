<template>
  <div>
    <div class="mb-2">
      <router-link to="/authors/create" class="btn btn-success"
        >Create</router-link
      >
    </div>
    <datatable
      :data="authors"
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
      authors: [],
      headers: [
        { name: "id", th: "ID" },
        { name: "name", th: "Name" },
        { name: "surname", th: "Surname" },
        { name: "book_count", th: "Count" },
        { name: "created_at", th: "Created at" },
      ],
      actions: [
        {
          text: "Edit",
          color: "primary",

          action: (row, index) => {
            this.$router.push({
              name: "authors.edit",
              params: { author: row.id },
            });
          },
        },
        {
          text: "Delete",
          color: "danger",
          class: "ml-2",
          action: (row, index) => {
            axios.delete(`/api/authors/${row.id}`).then(() => {
              Vue.delete(this.authors, index);
              alert("Author deleted successfully!");
            });
          },
        },
      ],
    };
  },
  methods: {
    fetchAuthors() {
      axios.get("/api/authors").then(({ data }) => {
        this.authors = data.data;
      });
    },
  },
  mounted() {
    this.fetchAuthors();
  },
};
</script>

<style lang="scss">
.btn-undefined {
  margin-left: 10px !important;
}
</style>
