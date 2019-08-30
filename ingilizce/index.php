<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>İngilizce Kelime Derleme</title>
<!--    <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.min.js" integrity="sha256-S1J4GVHHDMiirir9qsXWc8ZWw74PHHafpsHp5PXtjTs=" crossorigin="anonymous"></script>-->
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
</head>
<body>
<div id="app">
    <form action="sonuclar.php">
        İngilizce Kelime &nbsp; <input type="text" v-model="inputVerisi" name="Kelime">
        İngilizce Okunuşu &nbsp; <input type="text" v-bind:value="inputVerisi" name="KelimeOkunusu"><br/><br/><br/>
        İngilizce Anlami &nbsp; <input type="text" name="KelimeAnlami">

        <input type="submit" value="Kelimeyi Derle">
</form>
</div>


<script>

    var app = new Vue({
        el:"#app",
        data:{
            inputVerisi:""
        }
    })

</script>
</body>
</html>


