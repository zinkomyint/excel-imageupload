<template>
  <div>
    <h3 class="text-center">Edit Book</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="updateBook" enctype="multipart/form-data">
          <div class="form-group">
            <label>Name</label>
            <input type="text" class="form-control" v-model="book.name" id="name"/>
               <span v-if="allerros.name" class="tt">Name is required</span>
          </div>
          <div class="form-group">
            <label>Author</label>
            <input type="text" class="form-control" v-model="book.author" id="author"/>
               <span v-if="allerros.author" class="tt">Author is required</span>
          </div>
          <div class="form-group">
            <label>Image</label>
            <br />
            <img class="preview" :src="imageData">
            <input type="file" v-on:change="changeImage" @change="onFileChange"/>
              <img v-if="url" :src="url" width="20%" />
            <img v-else :src="urlPath + book.image" alt="image" class="img-thumbnail" width="100" id="image"/>
               <span v-if="allerros.image" class="tt">Image is required</span>
            </div>
      <div class="form-group">
             <input type="radio" id="male" value="male" v-model="book.gender">
            <label for="male">male</label>
                <br>
          <input type="radio" id="female" value="female" v-model="book.gender">
            <label for="female">female</label>
               <span v-if="allerros.gender" class="tt">Gender is required</span>
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
             <span v-if="allerros.model" class="tt">Model is required</span>
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
      checkedmodel:[],
       book: {
           name : '',
           author : '',
           image : '',
           gender : '',
           model : '',
           },
      allerros: [],
      success : false,    
      urlPath: "http://localhost:8000/images/",
      url: null,
    };
  },
  created() {
    this.axios
      .get(`http://localhost:8000/api/book/edit/${this.$route.params.id}`)
      .then(response => {
        this.book = response.data;
        console.log(response.data);
         this.checkedmodel = response.data.model.split(",");
        let hiddenImage;
        if(this.book.image)
        {
          hiddenImage = this.book.image;
        }else
        {
          hiddenImage = "";
        }
        this.$set(this.book, "hiddenImage", hiddenImage);
      });
  },
  computed:{
    getUploadedImage(){
        return this.urlPath + this.book.image;
    },
  },
  methods: {
       onFileChange(e) {
      const file = e.target.files[0];
      this.url = URL.createObjectURL(file);
    },
    changeImage(e){
      var fileName = e.target.files[0];
      this.$set(this.book, "image", fileName);
    },
    updateBook() {
      // this.axios
      //   .post(
      //     `http://localhost:8000/api/book/update/${this.$route.params.id}`,
      //     this.book
      //   )
      //   .then(response => {
      //     this.$router.push({ name: "home" });
      //   });
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
        formData.append('hiddenImage', this.book.hiddenImage);

        this.axios
        .post(
          `http://localhost:8000/api/book/update/${this.$route.params.id}`,
          formData , config
        )
        .then(response => {
           this.allerros = [];
                    this.book.name = '';
                    this.book.author = '';
                    this.book.image = '';
                    this.book.gender = '';
                    this.book.model = '';
                   
                    this.success = true;
            
            this.$router.push({ name: "home" })
            console.log(response.data)
        })  .catch((error) => {
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

