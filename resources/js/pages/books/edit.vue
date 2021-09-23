<template>
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card title="Edit book">
        <form
          ref="form"
          @submit.prevent="submit"
          @keydown="form.onKeydown($event)"
        >
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">{{
              $t("book_title")
            }}</label>
            <div class="col-md-7 mb-2">
              <input
                v-model="form.title"
                :class="{ 'is-invalid': form.errors.has('title') }"
                class="form-control"
                type="title"
                name="title"
              />
              <has-error :form="form" field="title" />
            </div>
            <label class="col-md-3 col-form-label text-md-end">Author</label>
            <div class="col-md-7">
              <select
                name="author_id"
                id="author_id"
                class="form-select"
                v-model="form.author_id"
              >
                <option
                  :value="author.id"
                  v-for="author in authors"
                  :key="author.id"
                  >{{ author.name }}</option
                >
              </select>
              <has-error :form="form" field="author_id" />
            </div>
            <label class="col-md-3 col-form-label text-md-end">Borrowed</label>
            <div class="col-md-7 mt-2">
              <select
                name="is_borrowed"
                id="is_borrowed"
                class="form-select"
                v-model="form.is_borrowed"
              >
                <option value="0">Not borrowed</option>
                <option value="1">borrowed</option>
              </select>
              <has-error :form="form" field="is_borrowed" />
            </div>
            <div class="mt-3 row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy">
                  Submit
                </v-button>
              </div>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  data: () => ({
    form: new Form({
      title: "",
      author_id: "",
      is_borrowed: "",
    }),
    authors: [],
  }),
  methods: {
    fetchAuthors() {
      axios
        .get("/api/authors-for-select")
        .then(({ data }) => {
          this.authors = data.data;
        })
        .catch(() => {
          alert("Error fetching authors");
        });
    },
    fetchBook() {
      axios.get(`/api/books/${this.$route.params.book}`).then(({ data }) => {
        this.form.title = data.data.title;
        this.form.id = data.data.id;
        this.form.author_id = data.data.author_id;
        this.form.is_borrowed = data.data.is_borrowed;
      });
    },
    submit() {
      this.form
        .put("/api/books/" + this.form.id)
        .then(({ data }) => {
          alert("Book updated successfully");
        })
        .catch(() => {
          alert("Error while updating the book");
        });
    },
  },
  mounted() {
    this.fetchAuthors();
    this.fetchBook();
  },
};
</script>

<style lang="scss" scoped></style>
