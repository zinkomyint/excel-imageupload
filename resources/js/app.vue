<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
          
            <span class="text-secondary">Laravel＆Vue CRUD シングルページアプリケーション（SPA）チュートリアル</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/" class="nav-item nav-link">ホーム</router-link>
                    <router-link to="/add" class="nav-item nav-link">ページを追加</router-link>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {}
</script>