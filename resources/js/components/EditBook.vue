<template>
    <div>
        <h3 class="text-center">Edit Book</h3>
        <div class="row">
            <div class="col-md-6">
                <form @submit.prevent="updateBook">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="book.name">
                    </div>
                    <div class="form-group">
                        <label>Author</label>
                        <input type="text" class="form-control" v-model="book.author">
                    </div>
                    <p style="margin-top:-3px">Image</p>
                     <div class="form-group">
               <img :src="urlPath + book.image" alt="image" class="img-thumbnail" width="75"/>
            <input style="margin-top:12px;" type="file" class="form-control" v-on:change="changeImage" />
          </div>
                    <button type="submit" class="btn btn-primary">Update Book</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                 urlPath: "http://localhost:8000/images/",
                book: {}
            }
        },
        created() {
            this.axios
                .get(`http://localhost:8000/api/book/edit/${this.$route.params.id}`)
                .then((response) => {
                    this.book = response.data;
                    // console.log(response.data);
                });
        },
        methods: {
            changeImage(e) {
      console.log(e.target.files[0]);
      var fileName = e.target.files[0];
      this.$set(this.book, "image", fileName);
    },
            updateBook() {
                this.axios
                    .post(`http://localhost:8000/api/book/update/${this.$route.params.id}`, this.book)
                    .then((response) => {
                        this.$router.push({name: 'home'});
                    });
            }
        }
    }
</script>