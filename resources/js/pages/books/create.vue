<template>
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card :title="$t('book_create_header')">
        <form
          ref="form"
          @submit.prevent="submit"
          @keydown="form.onKeydown($event)"
        >
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Title</label>
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
            <div class="mt-3 row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy" class="btn-success">
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
    submit() {
      this.form
        .post("/api/books")
        .then(({ data }) => {
          alert("Book created successfully");
          this.form.reset();
        })
        .catch(() => {
          alert("Error while creating the book");
        });
    },
  },
  mounted() {
    this.fetchAuthors();
  },
};
</script>

<style lang="scss" scoped></style>
