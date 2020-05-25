<template>
  <div>
    <h3 class="text-center">Add Book</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addBook" enctype="multipart/form-data" @submit="checkForm">
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
               <img class="preview" :src="imageData">
            <input type="file" class="form-control" v-on:change="changeImage" @change="onFileChange"/><br>
              <img v-if="url" :src="url" width="20%" />
          </div>

       <div class="form-group">
          <input type="radio" id="male" value="male" v-model="book.gender">
            <label for="male">male</label>
                <br>
          <input type="radio" id="female" value="female" v-model="book.gender">
            <label for="female">female</label>
                <br>
       </div>

       <div class="form-group">
          <label for="2WD" class="pakainfo form-check-label gst">
            <input type="checkbox" 
                    id="2WD" 
                    class="form-check-input"
                    value="2WD" 
                    v-model="checkedmodel"/>            
            2WD
        </label>
             <label for="4WD" class="pakainfo form-check-label gst" style="margin-left:25px">
            <input type="checkbox" 
                    id="4WD" 
                    class="form-check-input"
                    value="4WD" 
                    v-model="checkedmodel"/>            
            4WD
          </label>
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
      checkedmodel:[],
      book: {},
         urlPath: "http://localhost:8000/images/",
         url: null
    };
  },
  methods: {
      onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    changeImage(e) {
      console.log(e.target.files[0]);
      var fileName = e.target.files[0];
      this.$set(this.book, "image", fileName);
    },

      checkForm: function (e) {
      if (this.name && this.author  && this.gender  && this.model) {
        return true;
      }

      this.errors = [];

      if (!this.name) {
        this.errors.push('Name required.');
      }
      if (!this.author) {
        this.errors.push('Age required.');
      }
      if (!this.gender) {
        this.errors.push('Age required.');
      }
      if (!this.model) {
        this.errors.push('Age required.');
      }

      e.preventDefault();
    },
    
    addBook() {
      
       
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        this.book.model = this.checkedmodel;
        let formData = new FormData();
        formData.append('name', this.book.name);
        formData.append('author', this.book.author);
        formData.append('gender', this.book.gender);
        formData.append('model', this.book.model);
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
