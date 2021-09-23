<template>
  <div class="row">
    <div class="col-lg-7 m-auto">
      <card title="Update Author">
        <form
          ref="form"
          @submit.prevent="submit"
          @keydown="form.onKeydown($event)"
        >
          <div class="mb-3 row">
            <label class="col-md-3 col-form-label text-md-end">Name</label>
            <div class="col-md-7 mb-2">
              <input
                v-model="form.name"
                :class="{ 'is-invalid': form.errors.has('name') }"
                class="form-control"
                type="name"
                name="name"
              />
              <has-error :form="form" field="name" />
            </div>
            <label class="col-md-3 col-form-label text-md-end">Surname</label>
            <div class="col-md-7 mb-2">
              <input
                v-model="form.surname"
                :class="{ 'is-invalid': form.errors.has('surname') }"
                class="form-control"
                type="surname"
                name="surname"
              />
              <has-error :form="form" field="surname" />
            </div>
            <div class="mt-3 row">
              <div class="col-md-7 offset-md-3 d-flex">
                <!-- Submit Button -->
                <v-button :loading="form.busy" class="btn-success">
                  Update
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
      name: "",
      surname: "",
    }),
  }),
  methods: {
    fetchAuthor() {
      axios
        .get("/api/authors/" + this.$route.params.author)
        .then(({ data }) => {
          this.form.name = data.data.name;
          this.form.surname = data.data.surname;
        });
    },
    submit() {
      this.form
        .post("/api/authors")
        .then(({ data }) => {
          alert("Author updated successfully");
        })
        .catch(() => {
          alert("Error while creating the author");
        });
    },
  },
  mounted() {
    this.fetchAuthor();
  },
};
</script>

<style lang="scss" scoped></style>
