<template>
    <div>
        <h3 class="text-center">ホームページ</h3><br/>
         <download-excel style="margin-left:-12px;"
            class="btn btn-default"
            :data="json_data"
            :fields="json_fields"
            worksheet="My Worksheet"
            name="book.xls"
        >
            <button
                type="button"
                class="btn btn-success"
                @click="exportBookData"
            >
                エクセルエクスポート
            </button>
        </download-excel>

        
        <table class="table table-bordered">
            <thead>
            <tr>
              <th>ID</th>
                <th><input type="checkbox" id="name" value="name" v-model="checkedNames">名前</th>
                <th>著者</th>
                <th>性別</th>
                <th>モデル</th>
                <th>モデル</th>
                <th>作成日</th>
                <th>更新日</th>
                <th>行動</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in books" :key="book.id">
                <td>{{ book.id }}</td>
                <td>{{ book.name }}</td>
                <td>{{ book.author }}</td>
                <td>{{ book.gender }}</td>
                <td>{{ book.model }}</td>
                <td><img :src="urlPath + book.image" alt="image" class="img-thumbnail" width="75"/></td>
                <td>{{ book.created_at }}</td>
                <td>{{ book.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: book.id }}" class="btn btn-primary">編集
                        </router-link>
                        <button class="btn btn-danger" @click="deleteBook(book.id)" style="margin-left: 3px;">削除</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <span>Checked names: {{ checkedNames | json }}</span>
    </div>
</template>

<script>
import Vue from 'vue'
import JsonExcel from 'vue-json-excel'

Vue.component('downloadExcel', JsonExcel)

    export default {
        data() {
            return {
                checkedNames: [],
                urlPath: "http://localhost:8000/images/",
                books: [],
                json_fields: {
                Id: "id",
                Name: "name",
                Author: "author",
                Gender: "gender",
                Image: "image"
            },
               
            json_data: [],
            json_meta: [
                [
                    {
                        key: "charset",
                        value: "utf-8"
                    }
                ]
            ]
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/books')
                .then(response => {
                    this.books = response.data;
                });
        },
        methods: {
            deleteBook(id) {
                this.axios
                    .delete(`http://localhost:8000/api/book/delete/${id}`)
                    .then(response => {
                        let i = this.books.map(item => item.id).indexOf(id); // find index of your object
                        this.books.splice(i, 1)
                    });
            },
            exportBookData()
            {
                 this.axios
                .get('http://localhost:8000/api/book/export')
                .then(response => {
                    this.json_data = response.data;

                });
            }
        }
    }
</script>