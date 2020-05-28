<template>
  <div>
    <h3 class="text-center">ページを追加</h3>
    <div class="row">
      <div class="col-md-6">
        <form @submit.prevent="addBook" enctype="multipart/form-data" method="POST" autocomplete="off">
          <p class="star">*</p>
          <div class="form-group">
            <label class="nn">Name</label>
            <input type="text" class="form-control" v-model="book.name" id="name" @focusout="focusName" @keyup="focusName"/>
              <!-- <span v-if="allerros.name" class="tt">Name is required</span> -->
               <span class="error m-l-30 tt" v-if="focus_name">※入力は必須です。</span>
          </div>
            <p class="star">*</p>
          <div class="form-group">
            <label class="nn">Author</label>
            <input type="text" class="form-control" v-model="book.author" id="author" @focusout="focusauthor" @keyup="focusauthor"/>
              <!-- <span v-if="allerros.author" class="tt">Author is required</span> -->
               <span class="error m-l-30 tt" v-if="focus_author">※入力は必須です。</span>
          </div>
           <p class="star">*</p>
          <div class="form-group">
            <label class="nn">Image</label>
            <!-- <img class="preview" :src="imageData"> -->
            <input type="file" class="form-control" v-on:change="changeImage" @change="onFileChange" id="image" @focusout="focusimage" @keyup="focusimage"/><br>
            <img v-if="url" :src="url" width="20%" /><br>
             <!-- <span v-if="allerros.image" class="tt">image is required</span> -->
                   <span class="error m-l-30 tt" v-if="focus_image">※入力は必須です。</span>
          </div>
        <p class="star2">*</p>
       <div class="form-group">
          <input type="radio" id="male" value="male" v-model="book.gender">
            <label for="male">male</label>
                <br>
          <input type="radio" id="female" value="female" v-model="book.gender">
            <label for="female">female</label>

                <span v-if="allerros.gender" class="tt"><br>※入力は必須です。</span> 
                <span v-else></span>
                <br>
       </div>
      <p class="star2">*</p>
       <div class="form-group" style="margin-left: 22px;">
          <label for="2WD" class="pakainfo form-check-label gst">
            <input type="checkbox" 
                    id="2WD" 
                    class="form-check-input"
                    value="2WD" 
                    v-model="checkedmodel" @click="focusmodel"/>            
            2WD
        </label>
             <!-- <label for="4WD" class="pakainfo form-check-label gst" style="margin-left:25px">
            <input type="checkbox" 
                    id="model" 
                    class="form-check-input"
                    value="4WD" 
                    v-model="checkedmodel"  @focusout="focusmodel" @keyup="focusmodel"/>            
            4WD
          </label> -->
            <!-- <span v-if="allerros.model" class="tt"><br>* model is required</span> -->
            <span class="error m-l-30 tt" v-if="focus_model"></span>
            <span class="error m-l-30 tt" v-else-if="focus_model == false">※入力は必須です。</span>
           
      </div>
         
          <button type="submit" class="btn btn-primary" >追加ボタン</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
          errors: {
            name:"",
            author:"",
            image:"",
            model:"",
      },
      checkedmodel:[],
      book: {
        name:'',
        author:'',
        gender:'',
        image:'',
        model:'',
        focus_name: false,
        focus_author: false,
        focus_image: false,
        focus_model: false,
      },
      
      focus_name: false,
      focus_author: false,
      focus_image: false,
      focus_model: false,
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

     focusName: function(event) {
        if(this.book.name != ''){
            this.focus_name=false;
            // this.aggreBtn();
        }
           else{
            this.focus_name=true;
            // this.btn_disable = true;
        }
      },

      focusauthor: function(event) {
        if(this.book.author != ''){
            this.focus_author=false;
            // this.aggreBtn();
        }
           else{
            this.focus_author=true;
            // this.btn_disable = true;
        }
      },

      focusimage: function(event) {
        if(this.book.image != ''){
            this.focus_image=false;
            // this.aggreBtn();
        }
           else{
            this.focus_image=true;
            // this.btn_disable = true;
        }
      },

      focusmodel: function(event) {
        if(this.book.model != ''){
            this.focus_model=false;
            // this.aggreBtn();
        }
           else{
            this.focus_model=true;
            // this.btn_disable = true;
        }
      },
      

    //   aggreBtn: function(){
    //     if((this.book.name != '')){
    //         this.btn_disable=false;
    //     }else{
    //         this.btn_disable=true;
    //     }
    // }, 
    

    
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
  .nn{
    margin-left: 20px;
    margin-top: 7px;
  }
  .star{
    color: red;
    font-size: 30px;
    margin-bottom: -15px;
    position: absolute;
  }
   .star2{
    color: red;
    font-size: 30px;
    margin-bottom: -15px;
    /* position: absolute; */
  }
</style>
