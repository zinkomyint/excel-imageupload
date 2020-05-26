<template>
  <div>
    <h3 class="text-center">Add Book</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addBook" enctype="multipart/form-data" method="POST">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="book.name" id="name" />
              <span v-if="allerros.name" class="tt">Name is required</span>
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" class="form-control" v-model="book.author" id="author"/>
              <span v-if="allerros.author" class="tt">Author is required</span>
          </div>
          <div class="form-group">
            <label>Image</label>
            <!-- <img class="preview" :src="imageData"> -->
            <input type="file" class="form-control" v-on:change="changeImage" @change="onFileChange" id="image"/><br>
            <img v-if="url" :src="url" width="20%" /><br>
             <span v-if="allerros.image" class="tt">image is required</span>
          </div>

       <div class="form-group">
          <input type="radio" id="male" value="male" v-model="book.gender">
            <label for="male">male</label>
                <br>
          <input type="radio" id="female" value="female" v-model="book.gender">
            <label for="female">female</label>

                <span v-if="allerros.gender" class="tt"><br>gender is required</span>
                <br>
       </div>

       <div class="form-group">
          <label for="2WD" class="pakainfo form-check-label gst">
            <input type="checkbox" 
                    id="model" 
                    class="form-check-input"
                    value="2WD" 
                    v-model="checkedmodel"/>            
            2WD
        </label>
             <label for="4WD" class="pakainfo form-check-label gst" style="margin-left:25px">
            <input type="checkbox" 
                    id="model" 
                    class="form-check-input"
                    value="4WD" 
                    v-model="checkedmodel"/>            
            4WD
          </label>
            <span v-if="allerros.model" class="tt"><br>* model is required</span>
      </div>
           <span v-if="success">Record submitted successfully!</span>
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
      book: {
        name:'',
        author:'',
        gender:'',
        image:'',
        model:'',
      },
      allerros: [],
      success : false,    
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
    

    
    addBook() {
      
       
        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }
        this.book.model = this.checkedmodel;
        let formData = new FormData();
        formData.append('name', this.book.name);
        formData.append('author', this.book.author);
        formData.append('image', this.book.image);
        formData.append('gender', this.book.gender);
        formData.append('model', this.book.model);
        
            console.log(this.book.name);
            console.log(this.book.author)
            console.log(this.book.image);
            console.log(this.book.gender);
            console.log(this.book.model);

        
         this.axios
        .post("http://localhost:8000/api/book/add", formData, config)
        .then(
          response => { 
            
                    this.allerros = [];
                    this.book.name = '';
                    this.book.author = '';
                    this.book.image = '';
                    this.book.gender = '';
                    this.book.model = '';
                   
                    this.success = true;
            
            this.$router.push({ name: "home" })
            console.log(response.data)
    })
        // .catch(error => console.log(error))
        // .finally(() => (this.loading = false));
        .catch((error) => {
                         this.allerros = error.response.data.errors;
                         this.success = false;
                    });
    }
  }
};
</script>

<style scoped>
  .tt{
    color: red;
  }
</style>
