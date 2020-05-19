<template>
  <div>
    <h3 class="text-center">Add Book</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addBook" enctype="multipart/form-data">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="book.name" />
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" class="form-control" v-model="book.author" />
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" class="form-control" v-on:change="changeImage" />
          </div>
          <button type="submit" class="btn btn-primary">Add Book</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      book: {}
    };
  },
  methods: {
    changeImage(e) {
      console.log(e.target.files[0]);
      var fileName = e.target.files[0];
      this.$set(this.book, "image", fileName);
    },
    addBook() {
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }

        let formData = new FormData();
        formData.append('name', this.book.name);
        formData.append('author', this.book.author);
        formData.append('image', this.book.image);

        this.axios
        .post("http://localhost:8000/api/book/add", formData, config)
        .then(
          response => this.$router.push({ name: "home" })
          // console.log(response.data)
        )
        .catch(error => console.log(error))
        .finally(() => (this.loading = false));
    }
  }
};
</script>
