//Vue Code
Vue.config.devtools = true

var app = new Vue({
    el:"#app",
    data:{
        type:"password",
        show:true,
        checked:"",
    },
    created(){
        this.radioButtonSecimi = true;
    },
    methods:{
        InputDurumunuDegistir:function(){
            this.type = "text";
        },
        InputDurumunuGeriDonustur:function(){
            this.type = "password"
        },

        checkkedSecimi:function(){
            this.checked = "checked"
        },


    },

})












